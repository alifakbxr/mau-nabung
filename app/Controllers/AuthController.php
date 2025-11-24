<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

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
