<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
    protected $table = 'users';

    public function register($data) {
        $stmt = $this->db->prepare("INSERT INTO users (full_name, email, password, currency) VALUES (:full_name, :email, :password, :currency)");
        return $stmt->execute([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'currency' => $data['currency'] ?? 'IDR'
        ]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $data) {
        $sql = "UPDATE users SET full_name = :full_name, currency = :currency";
        $params = [
            'full_name' => $data['full_name'],
            'currency' => $data['currency'],
            'id' => $id
        ];

        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
