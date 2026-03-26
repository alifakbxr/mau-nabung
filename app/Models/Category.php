<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model {
    protected $table = 'categories';

    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE user_id = :user_id ORDER BY type, name");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getByUserAndType($userId, $type) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE user_id = :user_id AND type = :type ORDER BY name");
        $stmt->execute(['user_id' => $userId, 'type' => $type]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO categories (user_id, name, type, color) VALUES (:user_id, :name, :type, :color)");
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'type' => $data['type'],
            'color' => $data['color'] ?? '#6c757d'
        ]);
    }
    
    public function update($id, $data) {
        // Ensure user owns the category
        $stmt = $this->db->prepare("UPDATE categories SET name = :name, type = :type, color = :color WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            'name' => $data['name'],
            'type' => $data['type'],
            'color' => $data['color'],
            'id' => $id,
            'user_id' => $data['user_id']
        ]);
    }

    public function deleteForUser($id, $userId) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id AND user_id = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}
