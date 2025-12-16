<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\SavingsGoal;

class SavingsGoalController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $goalModel = new SavingsGoal();
        $goals = $goalModel->getByUser($_SESSION['user_id']);

        View::render('goals/index', ['goals' => $goals]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        View::render('goals/create');
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $goalModel = new SavingsGoal();
        $data = [
            'user_id' => $_SESSION['user_id'],
            'name' => $_POST['name'],
            'target_amount' => $_POST['target_amount'],
            'current_amount' => $_POST['current_amount'] ?? 0,
            'deadline' => $_POST['deadline'],
            'color' => $_POST['color']
        ];

        $goalModel->create($data);
        $_SESSION['success'] = 'Target tabungan berhasil dibuat';
        View::redirect('/goals');
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_POST['id'];
        $goalModel = new SavingsGoal();
        $goalModel->deleteForUser($id, $_SESSION['user_id']);
        
        $_SESSION['success'] = 'Target tabungan berhasil dihapus';
        View::redirect('/goals');
    }
}
