<?php

namespace App\Models;

use App\Core\Model;

class AuditLog extends Model {
    protected $table = 'audit_logs';

    public function log($userId, $action, $table, $recordId, $oldValues = null, $newValues = null) {
        $stmt = $this->db->prepare("INSERT INTO audit_logs (user_id, action, table_name, record_id, old_values, new_values, ip_address, user_agent) VALUES (:user_id, :action, :table_name, :record_id, :old_values, :new_values, :ip_address, :user_agent)");
        return $stmt->execute([
            'user_id' => $userId,
            'action' => $action,
            'table_name' => $table,
            'record_id' => $recordId,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN'
        ]);
    }
}
