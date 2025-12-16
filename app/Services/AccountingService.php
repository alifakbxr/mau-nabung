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

    private function checkLockDate($userId, $date) {
        // Simple direct query to avoid heavyweight Model instantiation if desired, 
        // but since we made Settings model, let's use it or a Helper.
        // For performance inside a Service, we can query DB directly or use the model.
        // Let's use the Model pattern.
        $settingsModel = new \App\Models\Settings();
        $lockDate = $settingsModel->get($userId, 'lock_date');
        
        if ($lockDate && $date <= $lockDate) {
            throw new Exception("Accounting Period Closed. Cannot modify transactions on or before $lockDate.");
        }
    }

    /**
     * Records a transaction with ACID compliance and Audit Logging.
     * Ensures atomic updates of Transaction History and Account Balance.
     */
    public function recordTransaction($userId, $data) {
        try {
            $this->db->beginTransaction();

            $this->checkLockDate($userId, $data['transaction_date']);

            // 1. Create Transaction (Logic)
            $this->transactionModel->create(array_merge($data, ['user_id' => $userId]));
            $transactionId = $this->db->lastInsertId();

            // 2. Update Account Balance (Logic)
            $type = $data['type'];
            $amount = $data['amount']; // Assumed to be string/decimal
            
            if ($type === 'transfer') {
                // Determine Source and Destination
                $sourceId = $data['account_id'];
                $destId = $data['related_account_id'];

                if (!$sourceId || !$destId) {
                    throw new Exception("Transfers require both account_id (Source) and related_account_id (Destination)");
                }

                // Debit Destination (Increase), Credit Source (Decrease)
                // Source: balance - amount
                $this->accountModel->updateBalance($sourceId, bcmul($amount, '-1', 2));
                
                // Dest: balance + amount
                $this->accountModel->updateBalance($destId, $amount);
                
            } elseif ($type === 'adjustment') {
                 // Adjustments directly apply the signed amount
                 // If amount is negative, it reduces balance. If positive, it increases.
                 $this->accountModel->updateBalance($data['account_id'], $amount);

            } else {
                // Standard Income/Expense
                $multiplier = ($type === 'expense') ? '-1' : '1';
                $balanceChange = bcmul($amount, $multiplier, 2);
                
                $this->accountModel->updateBalance($data['account_id'], $balanceChange);
            }

            // 3. Security: Audit Trail
            $this->logAudit($userId, 'CREATE', 'transactions', $transactionId, null, $data);

            $this->db->commit();
            return $transactionId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // ... (validateConfiguration remains same)

    public function validateConfiguration($accountId) {
        // Calculate theoretical balance from history
        // Modified query to handle Transfers and Adjustments
        $stmt = $this->db->prepare("
            SELECT 
                SUM(
                    CASE 
                        WHEN type = 'income' THEN amount 
                        WHEN type = 'expense' THEN -amount 
                        WHEN type = 'adjustment' THEN amount
                        WHEN type = 'transfer' AND related_account_id = :acc_id_in THEN amount
                        WHEN type = 'transfer' AND account_id = :acc_id_out THEN -amount
                        ELSE 0 
                    END
                ) as calculated_balance
            FROM transactions 
            WHERE (account_id = :acc_id_1 OR related_account_id = :acc_id_2)
            AND deleted_at IS NULL
        ");
        
        $stmt->execute([
            'acc_id_in' => $accountId,
            'acc_id_out' => $accountId,
            'acc_id_1' => $accountId,
            'acc_id_2' => $accountId
        ]);
        
        $result = $stmt->fetch();
        $calculatedBalance = $result['calculated_balance'] ?? '0.00';

        // Get actual stored balance
        $stmtAccount = $this->db->prepare("SELECT balance FROM accounts WHERE id = :id");
        $stmtAccount->execute(['id' => $accountId]);
        $actualBalance = $stmtAccount->fetchColumn() ?? '0.00';

        // Use BCMath for comparison
        $diff = bcsub($calculatedBalance, $actualBalance, 2);
        // Note: calculatedBalance is what Logic says it SHOULD be. 
        // If LogicSays=100, Actual=90. It means we are missing 10 in Actual OR we have extra 10 in History?
        // Wait, History Sum = 100. Stored = 90.
        // It means valid sum is 100.
        // So Actual is wrong by -10.
        
        $isValid = (bccomp(abs($diff), '0.01', 2) === -1); // abs(diff) < 0.01

        return [
            'is_valid' => $isValid,
            'calculated' => $calculatedBalance,
            'actual' => $actualBalance,
            'difference' => $diff
        ];
    }


    /**
     * Correction Mechanism.
     * Fixes discrepancies by creating an Adjustment Transaction.
     * This preserves the Audit Trail and avoids destructive updates.
     */
    public function reconcileBalance($userId, $accountId) {
        $validation = $this->validateConfiguration($accountId);
        
        if ($validation['is_valid']) {
            return false; // No need to fix
        }

        // We want to insert a transaction that makes calculated_balance MATCH actual_balance (if Actual is truth/bank)
        // OR make Actual match calculated (if code is truth).
        // Recommendation: "System Correction"
        // Let's assume Audit Standard: We add a transparent adjustment to history so it aligns with reality (Actual).
        
        $target = $validation['actual']; 
        $currentHistory = $validation['calculated'];
        
        // Needed Adjustment = Target - CurrentHistory
        // Example: Target(Bank)=90, History=100. We need -10.
        
        $diff = bcsub($target, $currentHistory, 2);
        
        if (bccomp($diff, '0', 2) !== 0) {
             try {
                $this->db->beginTransaction();
                
                // We insert this transaction effectively to modify History Sum.
                // BUT recordTransaction() updates Balance too!
                // If we use recordTransaction, we add -10 to History AND -10 to Balance.
                // New History = 90. New Balance = 80. Still mismatch!
                
                // Therefore, we must insert RAW transaction without triggering Balance Update 
                // OR we update balance back using a compensating logic?
                // "Adjustments directly apply the signed amount".
                
                // If we want to ONLY fix history (because Balance is correct), we should not touch Balance.
                // So we manually insert here.
                
                $this->transactionModel->create([
                    'user_id' => $userId,
                    'account_id' => $accountId,
                    'amount' => $diff,
                    'type' => 'adjustment',
                    'description' => '[SYSTEM CORRECTION] Reconciliation Adjustment',
                    'transaction_date' => date('Y-m-d')
                ]);
                $tid = $this->db->lastInsertId();
                
                $this->logAudit($userId, 'RECONCILE_ENTRY', 'transactions', $tid, null, ['amount' => $diff, 'reason' => 'Fix History to match Stored Balance']);
                
                $this->db->commit();
                return true;
             } catch (Exception $e) {
                $this->db->rollBack();
                throw $e;
             }
        }
        return false;
    }

    /**
     * Updates a transaction and adjusts account balances accordingly.
     */
    public function updateTransaction($userId, $id, $data) {
        try {
            $this->db->beginTransaction();

            $oldTx = $this->transactionModel->findById($id);
            if (!$oldTx || $oldTx['user_id'] != $userId) {
                throw new Exception("Transaction not found or unauthorized");
            }
            
            $this->checkLockDate($userId, $oldTx['transaction_date']);
            $this->checkLockDate($userId, $data['transaction_date']);

            // 1. Revert Old Balance Effect
            $this->revertTransactionEffect($oldTx);

            // 2. Update Transaction Record
            $this->transactionModel->update($id, array_merge($data, ['user_id' => $userId]));

            // 3. Apply New Balance Effect
            $this->applyTransactionEffect($data);

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

            $this->checkLockDate($userId, $oldTx['transaction_date']);

            // 1. Revert Balance (Because even if Soft Deleted, the money must 'leave' the account)
            $this->revertTransactionEffect($oldTx);

            // 2. Soft Delete Record
            // Note: The Model::deleteForUser now performs a Soft Delete (UPDATE deleted_at=NOW)
            $this->transactionModel->deleteForUser($id, $userId);

            // 3. Audit
            $this->logAudit($userId, 'DELETE (SOFT)', 'transactions', $id, $oldTx, null);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Helper to apply transaction effect
    private function applyTransactionEffect($data) {
        $type = $data['type'];
        $amount = $data['amount'];

        if ($type === 'transfer') {
            $this->accountModel->updateBalance($data['account_id'], bcmul($amount, '-1', 2));
            if (!empty($data['related_account_id'])) {
                $this->accountModel->updateBalance($data['related_account_id'], $amount);
            }
        } elseif ($type === 'adjustment') {
             $this->accountModel->updateBalance($data['account_id'], $amount);
        } else {
            $multiplier = ($type === 'expense') ? '-1' : '1';
            $this->accountModel->updateBalance($data['account_id'], bcmul($amount, $multiplier, 2));
        }
    }

    // Helper to revert transaction effect
    private function revertTransactionEffect($data) {
        $type = $data['type'];
        $amount = $data['amount'];

        if ($type === 'transfer') {
            // Revert transfer: Add to Source, Subtract from Dest
            $this->accountModel->updateBalance($data['account_id'], $amount);
            if (!empty($data['related_account_id'])) {
                $this->accountModel->updateBalance($data['related_account_id'], bcmul($amount, '-1', 2));
            }
        } elseif ($type === 'adjustment') {
             // Revert adjustment: Subtract amount
             $this->accountModel->updateBalance($data['account_id'], bcmul($amount, '-1', 2));
        } else {
            // Revert Income/Expense
            $multiplier = ($type === 'expense') ? '-1' : '1';
            // If expense (-100), we need to ADD 100. So -1 * -100 = 100.
            $reverseChange = bcmul($amount, $multiplier, 2);
            $this->accountModel->updateBalance($data['account_id'], bcmul($reverseChange, '-1', 2));
        }
    }

    /**
     * Internal Audit Logger with Encryption.
     */
    private function logAudit($userId, $action, $table, $refId, $old, $new) {
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
