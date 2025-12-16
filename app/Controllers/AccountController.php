<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Account;

class AccountController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $accountModel = new Account();
        $accounts = $accountModel->getByUser($_SESSION['user_id']);

        View::render('accounts/index', ['accounts' => $accounts]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        View::render('accounts/create');
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $accountModel = new Account();
        $data = [
            'user_id' => $_SESSION['user_id'],
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'balance' => $_POST['balance']
        ];

        $accountModel->create($data);
        $_SESSION['success'] = 'Akun berhasil ditambahkan';
        View::redirect('/accounts');
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_POST['id'];
        $accountModel = new Account();
        
        // Prevent deleting the last account usually, but for now just delete
        $accountModel->deleteForUser($id, $_SESSION['user_id']);
        
        $_SESSION['success'] = 'Akun berhasil dihapus';
        View::redirect('/accounts');
    }
}
