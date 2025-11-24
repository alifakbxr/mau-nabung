<?php

namespace App\Models;

use App\Core\Model;

class Transaction extends Model {
    protected $table = 'transactions';

    public function getByUser($userId, $limit = null, $filters = []) {
        $sql = "SELECT t.*, c.name as category_name, c.color as category_color 
                FROM transactions t 
                LEFT JOIN categories c ON t.category_id = c.id 
                WHERE t.user_id = :user_id";
        
        $params = ['user_id' => $userId];

        if (!empty($filters['start_date'])) {
            $sql .= " AND t.transaction_date >= :start_date";
            $params['start_date'] = $filters['start_date'];
        }
        if (!empty($filters['end_date'])) {
            $sql .= " AND t.transaction_date <= :end_date";
            $params['end_date'] = $filters['end_date'];
        }
        if (!empty($filters['category_id'])) {
            $sql .= " AND t.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        $sql .= " ORDER BY t.transaction_date DESC, t.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO transactions (user_id, category_id, amount, type, description, transaction_date) VALUES (:user_id, :category_id, :amount, :type, :description, :transaction_date)");
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id'] ?: null,
            'amount' => $data['amount'],
            'type' => $data['type'],
            'description' => $data['description'],
            'transaction_date' => $data['transaction_date']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE transactions SET category_id = :category_id, amount = :amount, type = :type, description = :description, transaction_date = :transaction_date WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            'category_id' => $data['category_id'] ?: null,
            'amount' => $data['amount'],
            'type' => $data['type'],
            'description' => $data['description'],
            'transaction_date' => $data['transaction_date'],
            'id' => $id,
            'user_id' => $data['user_id']
        ]);
    }
    
    public function deleteForUser($id, $userId) {
        $stmt = $this->db->prepare("DELETE FROM transactions WHERE id = :id AND user_id = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }

    public function getTotals($userId, $startDate, $endDate) {
        $sql = "SELECT 
                    SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
                    SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense
                FROM transactions 
                WHERE user_id = :user_id AND transaction_date BETWEEN :start_date AND :end_date";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId, 
            'start_date' => $startDate, 
            'end_date' => $endDate
        ]);
        return $stmt->fetch();
    }

    public function getCategoryBreakdown($userId, $startDate, $endDate, $type = 'expense') {
        $sql = "SELECT c.name, c.color, SUM(t.amount) as total 
                FROM transactions t
                JOIN categories c ON t.category_id = c.id
                WHERE t.user_id = :user_id 
                AND t.type = :type
                AND t.transaction_date BETWEEN :start_date AND :end_date
                GROUP BY c.id
                ORDER BY total DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'type' => $type,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
        return $stmt->fetchAll();
    }
}
