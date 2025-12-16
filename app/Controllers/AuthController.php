<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\Account;

class AuthController {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            View::redirect('/dashboard');
        }
        View::render('auth/login');
    }

    public function processLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['currency'] = $user['currency'];
            View::redirect('/dashboard');
        } else {
            $_SESSION['error'] = 'Email atau password salah.';
            View::redirect('/login');
        }
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            View::redirect('/dashboard');
        }
        View::render('auth/register');
    }

    public function processRegister() {
        $data = [
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'currency' => $_POST['currency']
        ];

        $userModel = new User();
        try {
            if ($userModel->register($data)) {
                // Get the new user ID (assuming we can get it or just login immediately)
                // Since register usually returns bool, we might need to query the user or change register to return ID.
                // Assuming standard flow, let's try to find the user to get ID, or if register logs them in.
                
                // For now, let's find the user we just created to get the ID
                $newUser = $userModel->findByEmail($data['email']);
                if ($newUser) {
                    $accountModel = new Account();
                    $accountModel->create([
                        'user_id' => $newUser['id'],
                        'name' => 'Dompet Tunai',
                        'type' => 'cash',
                        'balance' => 0,
                        'is_default' => 1
                    ]);
                }

                $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
                View::redirect('/login');
            } else {
                $_SESSION['error'] = 'Registrasi gagal.';
                View::redirect('/register');
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Email mungkin sudah terdaftar.';
            View::redirect('/register');
        }
    }

    public function logout() {
        session_destroy();
        View::redirect('/login');
    }
}
