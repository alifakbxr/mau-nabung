<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use App\Models\SavingsGoal;

class SalaryController {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $accountModel = new Account();
        $accounts = $accountModel->getByUser($_SESSION['user_id']);

        $goalModel = new SavingsGoal();
        $goals = $goalModel->getByUser($_SESSION['user_id']);
        
        // Find "Gaji" or "Salary" category for convenience
        $categoryModel = new Category();
        $categories = $categoryModel->getByUserAndType($_SESSION['user_id'], 'income');

        View::render('salary/allocator', [
            'accounts' => $accounts, 
            'goals' => $goals,
            'categories' => $categories
        ]);
    }

    public function process() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $amount = (float)$_POST['amount']; // Total Salary
        $accountId = $_POST['account_id']; // Where money enters
        $categoryId = $_POST['category_id']; // Income Category

        // Allocation Data
        $savingsAmount = (float)$_POST['savings_amount'];
        $savingsGoalId = $_POST['savings_goal_id'] ?? null;
        
        // Validation
        if ($amount <= 0) {
            $_SESSION['error'] = 'Jumlah gaji tidak valid';
            View::redirect('/salary/allocator');
            return;
        }

        // 1. Record Income Transaction
        $transactionModel = new Transaction();
        $trxData = [
            'user_id' => $userId,
            'amount' => $amount,
            'type' => 'income',
            'category_id' => $categoryId ?: null,
            'account_id' => $accountId,
            'description' => 'Pemasukan Gaji (via Allocator)',
            'transaction_date' => date('Y-m-d')
        ];
        
        try {
            $transactionModel->create($trxData);
            
            // 2. Allocate to Savings Goal (Virtual Allocation)
            if ($savingsAmount > 0 && $savingsGoalId) {
                $goalModel = new SavingsGoal();
                $goal = $goalModel->findById($savingsGoalId);
                
                if ($goal) {
                    $newGoalAmount = $goal['current_amount'] + $savingsAmount;
                    $goalModel->update($savingsGoalId, [
                        'user_id' => $userId,
                        'name' => $goal['name'],
                        'target_amount' => $goal['target_amount'],
                        'current_amount' => $newGoalAmount,
                        'deadline' => $goal['deadline'],
                        'color' => $goal['color']
                    ]);
                    
                    $msg = "Gaji Rp " . number_format($amount) . " dicatat. Rp " . number_format($savingsAmount) . " dialokasikan ke " . $goal['name'];
                }
            } else {
                $msg = "Gaji Rp " . number_format($amount) . " berhasil dicatat.";
            }

            $_SESSION['success'] = $msg;
            View::redirect('/dashboard');

        } catch (\Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            View::redirect('/salary/allocator');
        }
    }
}
