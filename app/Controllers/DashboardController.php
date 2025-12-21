<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use App\Models\SavingsGoal;

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            return View::render('pages/landing');
        }

        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        
        // Default to current month
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        $accountModel = new Account();
        $accounts = $accountModel->getByUser($userId);

        $goalModel = new SavingsGoal();
        $goals = $goalModel->getByUser($userId);

        $totals = $transactionModel->getTotals($userId, $startDate, $endDate);
        $recentTransactions = $transactionModel->getByUser($userId, 5);
        $expenseBreakdown = $transactionModel->getCategoryBreakdown($userId, $startDate, $endDate, 'expense');
        $incomeBreakdown = $transactionModel->getCategoryBreakdown($userId, $startDate, $endDate, 'income');

        // Calculate Net Worth
        $netWorth = 0;
        foreach ($accounts as $acc) {
            $netWorth += $acc['balance'];
        }

        View::render('dashboard/index', [
            'totals' => $totals,
            'accounts' => $accounts, // Display wallets on dashboard
            'goals' => $goals,      // Display goals on dashboard
            'netWorth' => $netWorth,
            'recentTransactions' => $recentTransactions,
            'expenseBreakdown' => $expenseBreakdown,
            'incomeBreakdown' => $incomeBreakdown,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}
