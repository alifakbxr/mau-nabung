<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Transaction;
use App\Models\Category;

class ReportController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();
        $categoryModel = new Category();

        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');

        $totals = $transactionModel->getTotals($userId, $startDate, $endDate);
        $expenseBreakdown = $transactionModel->getCategoryBreakdown($userId, $startDate, $endDate, 'expense');
        $incomeBreakdown = $transactionModel->getCategoryBreakdown($userId, $startDate, $endDate, 'income');

        View::render('reports/index', [
            'totals' => $totals,
            'expenseBreakdown' => $expenseBreakdown,
            'incomeBreakdown' => $incomeBreakdown,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function export() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $transactionModel = new Transaction();

        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');

        $transactions = $transactionModel->getByUser($userId, null, [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="laporan_keuangan_' . $startDate . '_to_' . $endDate . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Tanggal', 'Tipe', 'Kategori', 'Jumlah', 'Deskripsi']);

        foreach ($transactions as $row) {
            fputcsv($output, [
                $row['id'],
                $row['transaction_date'],
                $row['type'],
                $row['category_name'] ?? 'Tanpa Kategori',
                $row['amount'],
                $row['description']
            ]);
        }
        fclose($output);
        exit;
    }
}
