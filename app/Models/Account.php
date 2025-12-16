<?php

namespace App\Models;

use App\Core\Model;

class Account extends Model {
    protected $table = 'accounts';

    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM accounts WHERE user_id = :user_id ORDER BY is_default DESC, name ASC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM accounts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO accounts (user_id, name, type, balance, is_default) VALUES (:user_id, :name, :type, :balance, :is_default)");
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'type' => $data['type'],
            'balance' => $data['balance'] ?? 0,
            'is_default' => $data['is_default'] ?? 0
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE accounts SET name = :name, type = :type, balance = :balance WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            'name' => $data['name'],
            'type' => $data['type'],
            'balance' => $data['balance'],
            'id' => $id,
            'user_id' => $data['user_id']
        ]);
    }
    
    public function updateBalance($id, $amount) {
        // Amount can be positive or negative
        $stmt = $this->db->prepare("UPDATE accounts SET balance = balance + :amount WHERE id = :id");
        return $stmt->execute([
            'amount' => $amount,
            'id' => $id
        ]);
    }

    public function deleteForUser($id, $userId) {
        $stmt = $this->db->prepare("DELETE FROM accounts WHERE id = :id AND user_id = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}
