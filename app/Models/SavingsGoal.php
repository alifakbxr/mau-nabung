<?php

namespace App\Models;

use App\Core\Model;

class SavingsGoal extends Model {
    protected $table = 'savings_goals';

    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM savings_goals WHERE user_id = :user_id ORDER BY deadline ASC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM savings_goals WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO savings_goals (user_id, name, target_amount, current_amount, deadline, color) VALUES (:user_id, :name, :target_amount, :current_amount, :deadline, :color)");
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'target_amount' => $data['target_amount'],
            'current_amount' => $data['current_amount'] ?? 0,
            'deadline' => $data['deadline'] ?: NULL,
            'color' => $data['color'] ?? '#4e73df'
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE savings_goals SET name = :name, target_amount = :target_amount, current_amount = :current_amount, deadline = :deadline, color = :color WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            'name' => $data['name'],
            'target_amount' => $data['target_amount'],
            'current_amount' => $data['current_amount'],
            'deadline' => $data['deadline'] ?: NULL,
            'color' => $data['color'],
            'id' => $id,
            'user_id' => $data['user_id']
        ]);
    }

    public function deleteForUser($id, $userId) {
        $stmt = $this->db->prepare("DELETE FROM savings_goals WHERE id = :id AND user_id = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}
