<?php

namespace App\Models;

use App\Core\Model;

class Settings extends Model {
    protected $table = 'settings';

    public function get($userId, $key) {
        $stmt = $this->db->prepare("SELECT value FROM settings WHERE user_id = :user_id AND key_name = :key_name");
        $stmt->execute(['user_id' => $userId, 'key_name' => $key]);
        $result = $stmt->fetch();
        return $result ? $result['value'] : null;
    }

    public function set($userId, $key, $value) {
        // Insert or Update
        $stmt = $this->db->prepare("
            INSERT INTO settings (user_id, key_name, value) 
            VALUES (:user_id, :key_name, :value) 
            ON DUPLICATE KEY UPDATE value = :value_update
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'key_name' => $key,
            'value' => $value,
            'value_update' => $value
        ]);
    }
}
