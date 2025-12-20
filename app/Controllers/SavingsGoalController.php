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

    public function simulate() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $target = filter_input(INPUT_GET, 'target', FILTER_VALIDATE_FLOAT);
        $monthly = filter_input(INPUT_GET, 'monthly', FILTER_VALIDATE_FLOAT);

        if (!$target || !$monthly || $monthly <= 0) {
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $months = ceil($target / $monthly);
        
        // Calculate estimated date
        $date = new \DateTime();
        $date->modify("+$months months");

        echo json_encode([
            'months' => $months,
            'estimated_date' => $date->format('d M Y')
        ]);
    }

    public function addFunds() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_POST['id'];
        $amount = (float)$_POST['amount'];

        if ($amount <= 0) {
            $_SESSION['error'] = 'Jumlah harus lebih besar dari 0';
            View::redirect('/goals');
            return;
        }

        $goalModel = new SavingsGoal();
        $goal = $goalModel->findById($id);

        if (!$goal || $goal['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Target tidak ditemukan';
            View::redirect('/goals');
            return;
        }

        $newAmount = $goal['current_amount'] + $amount;
        
        // Prepare data for update (we only update current_amount)
        // Note: Ideally Model should have specific updateAmount method, 
        // but for now we reuse update() which needs other fields.
        // Let's modify the Model to be easier or just fetch and update all.
        // For safety, let's create a specific method in the Model in the next step?
        // OR just pass all data back.
        $data = [
            'name' => $goal['name'],
            'target_amount' => $goal['target_amount'],
            'current_amount' => $newAmount,
            'deadline' => $goal['deadline'],
            'color' => $goal['color'],
            'user_id' => $_SESSION['user_id']
        ];

        $goalModel->update($id, $data);
        
        $_SESSION['success'] = 'Berhasil mengalokasikan Rp ' . number_format($amount, 0, ',', '.');
        View::redirect('/goals');
    }
}
