<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class ProfileController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        View::render('profile/index', ['user' => $user]);
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $data = [
            'full_name' => $_POST['full_name'],
            'currency' => $_POST['currency'],
            'password' => $_POST['password'] // Optional
        ];

        $userModel = new User();
        $userModel->updateProfile($_SESSION['user_id'], $data);

        // Update session info
        $_SESSION['user_name'] = $data['full_name'];
        $_SESSION['currency'] = $data['currency'];

        $_SESSION['success'] = 'Profil berhasil diperbarui';
        View::redirect('/profile');
    }
}
