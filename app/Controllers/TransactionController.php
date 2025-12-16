<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use App\Models\AuditLog;
use App\Core\Security;

class TransactionController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        $categoryModel = new Category();

        $filters = [
            'start_date' => $_GET['start_date'] ?? date('Y-m-01'),
            'end_date' => $_GET['end_date'] ?? date('Y-m-t'),
            'category_id' => $_GET['category_id'] ?? ''
        ];

        $transactions = $transactionModel->getByUser($userId, null, $filters);
        $categories = $categoryModel->getByUser($userId);

        View::render('transactions/index', [
            'transactions' => $transactions,
            'categories' => $categories,
            'filters' => $filters
        ]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getByUser($_SESSION['user_id']);
        
        $accountModel = new Account();
        $accounts = $accountModel->getByUser($_SESSION['user_id']);

        View::render('transactions/create', [
            'categories' => $categories,
            'accounts' => $accounts
        ]);
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }
        
        Security::verifyCsrfToken($_POST['csrf_token'] ?? '');

        $data = [
            'user_id' => $_SESSION['user_id'],
            'category_id' => $_POST['category_id'],
            'account_id' => $_POST['account_id'],
            'amount' => $_POST['amount'],
            'type' => $_POST['type'],
            'description' => $_POST['description'],
            'transaction_date' => $_POST['transaction_date']
        ];

        $transactionModel = new Transaction();
        $transactionModel->create($data);
        
        $auditLog = new AuditLog();
        $auditLog->log($_SESSION['user_id'], 'CREATE', 'transactions', $this->db->lastInsertId(), null, $data);

        $_SESSION['success'] = 'Transaksi berhasil disimpan';
        View::redirect('/transactions');
    }

    public function edit() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_GET['id'];
        $transactionModel = new Transaction();
        $transaction = $transactionModel->findById($id);

        // Security check
        if (!$transaction || $transaction['user_id'] != $_SESSION['user_id']) {
            View::redirect('/transactions');
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getByUser($_SESSION['user_id']);
        
        $accountModel = new Account();
        $accounts = $accountModel->getByUser($_SESSION['user_id']);

        View::render('transactions/edit', [
            'transaction' => $transaction,
            'categories' => $categories,
            'accounts' => $accounts
        ]);
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }
        
        Security::verifyCsrfToken($_POST['csrf_token'] ?? '');

        $id = $_POST['id'];
        $data = [
            'user_id' => $_SESSION['user_id'],
            'category_id' => $_POST['category_id'],
            'account_id' => $_POST['account_id'],
            'amount' => $_POST['amount'],
            'type' => $_POST['type'],
            'description' => $_POST['description'],
            'transaction_date' => $_POST['transaction_date']
        ];

        $transactionModel = new Transaction();
        // For audit, fetch old data
        $oldData = $transactionModel->findById($id);
        
        $transactionModel->update($id, $data);
        
        $auditLog = new AuditLog();
        $auditLog->log($_SESSION['user_id'], 'UPDATE', 'transactions', $id, $oldData, $data);

        $_SESSION['success'] = 'Transaksi berhasil diperbarui';
        View::redirect('/transactions');
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }
        
        Security::verifyCsrfToken($_POST['csrf_token'] ?? '');

        $id = $_POST['id'];
        $transactionModel = new Transaction();
        
        // Audit
        $oldData = $transactionModel->findById($id);
        
        $transactionModel->deleteForUser($id, $_SESSION['user_id']);
        
        $auditLog = new AuditLog();
        $auditLog->log($_SESSION['user_id'], 'DELETE', 'transactions', $id, $oldData, null);

        $_SESSION['success'] = 'Transaksi berhasil dihapus';
        View::redirect('/transactions');
    }
}
