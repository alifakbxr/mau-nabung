<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Transaction;
use App\Models\Category;

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

        View::render('transactions/create', ['categories' => $categories]);
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'category_id' => $_POST['category_id'],
            'amount' => $_POST['amount'],
            'type' => $_POST['type'],
            'description' => $_POST['description'],
            'transaction_date' => $_POST['transaction_date']
        ];

        $transactionModel = new Transaction();
        $transactionModel->create($data);

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

        View::render('transactions/edit', [
            'transaction' => $transaction,
            'categories' => $categories
        ]);
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_POST['id'];
        $data = [
            'user_id' => $_SESSION['user_id'],
            'category_id' => $_POST['category_id'],
            'amount' => $_POST['amount'],
            'type' => $_POST['type'],
            'description' => $_POST['description'],
            'transaction_date' => $_POST['transaction_date']
        ];

        $transactionModel = new Transaction();
        $transactionModel->update($id, $data);

        $_SESSION['success'] = 'Transaksi berhasil diperbarui';
        View::redirect('/transactions');
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_POST['id'];
        $transactionModel = new Transaction();
        $transactionModel->deleteForUser($id, $_SESSION['user_id']);

        $_SESSION['success'] = 'Transaksi berhasil dihapus';
        View::redirect('/transactions');
    }
}
