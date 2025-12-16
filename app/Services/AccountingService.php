<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Transaction;
use App\Models\Account;
use App\Core\Security;
use Exception;
use PDO;

class AccountingService {
    private $db;
    private $transactionModel;
    private $accountModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->transactionModel = new Transaction();
        $this->accountModel = new Account();
    }

    /**
     * Records a transaction with ACID compliance and Audit Logging.
     * Ensures atomic updates of Transaction History and Account Balance.
     */
    public function recordTransaction($userId, $data) {
        try {
            $this->db->beginTransaction();

            // 1. Create Transaction (Logic)
            $this->transactionModel->create(array_merge($data, ['user_id' => $userId]));
            $transactionId = $this->db->lastInsertId();

            // 2. Update Account Balance (Logic)
            // Income adds to balance, Expense subtracts
            $multiplier = ($data['type'] === 'expense') ? -1 : 1;
            $amount = $data['amount'] * $multiplier;
            
            $this->accountModel->updateBalance($data['account_id'], $amount);

            // 3. Security: Audit Trail
            // We log the raw data. Ideally, we should encrypt specific fields if they are highly sensitive.
            // For this implementation, we will encrypt the entire payload in the log to satisfy
            // "Implementasi enkripsi untuk data sensitif (bukan hanya password)" within the Audit context.
            $this->logAudit($userId, 'CREATE', 'transactions', $transactionId, null, $data);

            $this->db->commit();
            return $transactionId;

        } catch (Exception $e) {
            $this->db->rollBack();
            // Log error internally or rethrow
            throw $e;
        }
    }

    /**
     * Validates that the stored Account Balance matches the sum of all transactions.
     * Use this for "Validasi otomatis".
     */
    public function validateConfiguration($accountId) {
        // Calculate theoretical balance from history
        $stmt = $this->db->prepare("
            SELECT 
                SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as calculated_balance
            FROM transactions 
            WHERE account_id = :account_id
        ");
        $stmt->execute(['account_id' => $accountId]);
        $result = $stmt->fetch();
        $calculatedBalance = (float) ($result['calculated_balance'] ?? 0);

        // Get actual stored balance
        $stmtAccount = $this->db->prepare("SELECT balance FROM accounts WHERE id = :id");
        $stmtAccount->execute(['id' => $accountId]);
        $actualBalance = (float) $stmtAccount->fetchColumn();

        $diff = $calculatedBalance - $actualBalance;
        $isValid = abs($diff) < 0.01;

        return [
            'is_valid' => $isValid,
            'calculated' => $calculatedBalance,
            'actual' => $actualBalance,
            'difference' => $diff
        ];
    }

    /**
     * Correction Mechanism.
     * Fixes discrepancies by updating the Account Balance to match Transaction History.
     * This is the "Self-Healing" approach. 
     */
    public function reconcileBalance($userId, $accountId) {
        $validation = $this->validateConfiguration($accountId);
        
        if ($validation['is_valid']) {
            return false; // No need to fix
        }

        try {
            $this->db->beginTransaction();

            $newBalance = $validation['calculated'];
            $stmt = $this->db->prepare("UPDATE accounts SET balance = :bal WHERE id = :id");
            $stmt->execute(['bal' => $newBalance, 'id' => $accountId]);
                 
            $this->logAudit($userId, 'RECONCILE', 'accounts', $accountId, ['balance' => $validation['actual']], ['balance' => $newBalance]);
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Updates a transaction and adjusts account balances accordingly.
     * Reverts the old transaction's impact and applies the new one.
     */
    public function updateTransaction($userId, $id, $data) {
        try {
            $this->db->beginTransaction();

            $oldTx = $this->transactionModel->findById($id);
            if (!$oldTx || $oldTx['user_id'] != $userId) {
                throw new Exception("Transaction not found or unauthorized");
            }

            // 1. Revert Old Balance Effect
            // If it was Expense (Subtracted), we Add it back.
            // If it was Income (Added), we Subtract it.
            $oldMultiplier = ($oldTx['type'] === 'expense') ? -1 : 1;
            $oldAmount = $oldTx['amount'] * $oldMultiplier;
            // Reverse: subtract the signed amount
            $this->accountModel->updateBalance($oldTx['account_id'], -1 * $oldAmount);

            // 2. Update Transaction Record
            $this->transactionModel->update($id, array_merge($data, ['user_id' => $userId]));

            // 3. Apply New Balance Effect
            $newMultiplier = ($data['type'] === 'expense') ? -1 : 1;
            $newAmount = $data['amount'] * $newMultiplier;
            $this->accountModel->updateBalance($data['account_id'], $newAmount);

            // 4. Audit
            $this->logAudit($userId, 'UPDATE', 'transactions', $id, $oldTx, $data);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Deletes a transaction and reverts its impact on the balance.
     */
    public function deleteTransaction($userId, $id) {
        try {
            $this->db->beginTransaction();

            $oldTx = $this->transactionModel->findById($id);
            if (!$oldTx || $oldTx['user_id'] != $userId) {
                throw new Exception("Transaction not found or unauthorized");
            }

            // 1. Revert Balance
            $multiplier = ($oldTx['type'] === 'expense') ? -1 : 1;
            $amount = $oldTx['amount'] * $multiplier;
            $this->accountModel->updateBalance($oldTx['account_id'], -1 * $amount);

            // 2. Delete Record
            $this->transactionModel->deleteForUser($id, $userId);

            // 3. Audit
            $this->logAudit($userId, 'DELETE', 'transactions', $id, $oldTx, null);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Internal Audit Logger with Encryption.
     */
    private function logAudit($userId, $action, $table, $refId, $old, $new) {
        // Enforce Encryption on Audit Logs as requested
        // Wrapping in array to ensure it's valid JSON: {"secure_payload": "..."}
        // This protects the historical data even if DB is dumped.
        
        $oldEncrypted = $old ? json_encode(['secure_payload' => Security::encrypt(json_encode($old))]) : null;
        $newEncrypted = $new ? json_encode(['secure_payload' => Security::encrypt(json_encode($new))]) : null;

        $stmt = $this->db->prepare("
            INSERT INTO audit_logs 
            (user_id, action, table_name, record_id, old_values, new_values, ip_address, user_agent) 
            VALUES (:uid, :act, :tbl, :rid, :old, :new, :ip, :agent)
        ");
        
        $stmt->execute([
            'uid' => $userId,
            'act' => $action,
            'tbl' => $table,
            'rid' => $refId,
            'old' => $oldEncrypted,
            'new' => $newEncrypted,
            'ip'  => $_SERVER['REMOTE_ADDR'] ?? 'CLI',
            'agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI'
        ]);
    }
}
