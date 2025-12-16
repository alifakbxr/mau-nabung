<?php

// Database Backup Script
// Usage: php utils/backup.php

// Define configuration
$host = 'localhost';
$user = 'root';
$password = ''; // Typically empty in local XAMPP/Laragon, change if needed
$database = 'maunabung';
$backupDir = __DIR__ . '/../backups/';

if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$filename = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sql';

// Command for mysqldump (assuming it's in PATH, otherwise specify full path)
// On Windows, you might need "C:/xampp/mysql/bin/mysqldump.exe" etc.
$command = "mysqldump --user={$user} --password={$password} --host={$host} {$database} > {$filename}";

// For XAMPP typical install if mysqldump not in path:
// $command = "c:\xampp\mysql\bin\mysqldump --user={$user} --password={$password} --host={$host} {$database} > {$filename}";

// Execute
system($command, $output);

if ($output === 0) {
    echo "Backup berhasil: {$filename}\n";
    
    // Retention Policy: Delete backups older than 7 days
    $files = glob($backupDir . '*.sql');
    $now = time();
    $days = 7;
    
    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= 60 * 60 * 24 * $days) {
                unlink($file);
                echo "Backup lama dihapus: " . basename($file) . "\n";
            }
        }
    }
    
} else {
    echo "Backup gagal. Pastikan mysqldump terinstall dan konfigurasi benar.\n";
}
