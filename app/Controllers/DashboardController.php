<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Transaction;
use App\Models\Category;

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        
        // Default to current month
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        $totals = $transactionModel->getTotals($userId, $startDate, $endDate);
        $recentTransactions = $transactionModel->getByUser($userId, 5);
        $expenseBreakdown = $transactionModel->getCategoryBreakdown($userId, $startDate, $endDate, 'expense');
        $incomeBreakdown = $transactionModel->getCategoryBreakdown($userId, $startDate, $endDate, 'income');

        View::render('dashboard/index', [
            'totals' => $totals,
            'recentTransactions' => $recentTransactions,
            'expenseBreakdown' => $expenseBreakdown,
            'incomeBreakdown' => $incomeBreakdown,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}
