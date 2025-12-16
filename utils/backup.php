<?php
// Maunabung Auto-Backup Script
// Usage: php utils/backup.php

require_once __DIR__ . '/../app/Core/Security.php';
$config = require __DIR__ . '/../config/database.php';

use App\Core\Security;

// Configuration
$backupDir = __DIR__ . '/../backups/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$date = date('Y-m-d_H-i-s');
$filename = "maunabung_backup_{$date}.sql";
$encryptedFilename = "maunabung_backup_{$date}.enc";

echo "[*] Starting Backup Process...\n";

// 1. Dump Database
$command = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s > %s',
    escapeshellarg($config['username']),
    escapeshellarg($config['password']),
    escapeshellarg($config['host']),
    escapeshellarg($config['dbname']),
    escapeshellarg($backupDir . $filename)
);

system($command, $returnVar);

if ($returnVar !== 0) {
    die("[!] Error: mysqldump failed with code $returnVar\n");
}

echo "[+] Database dumped to: {$filename}\n";

// 2. Encrypt Backup (Security Requirement)
// We use OpenSSL to encrypt the file content
$content = file_get_contents($backupDir . $filename);
if ($content === false) {
    die("[!] Error reading dump file.\n");
}

// Generate a random key for this backup or use system key
//Ideally we use a master public key, but for this standalone app we use the app key.
// Note: Security::encrypt is for strings and adds base64 overhead. 
// For files, we usually want raw binary. But let's stick to the App's Security class for consistency if possible,
// OR use a dedicated file encryption routine. 
// Given file size might be large, streaming encryption is better, but app is small.
// We will use a custom encryption loop or just the Security class if it handles length well.
// Security::encrypt uses AES-256-CBC and internal key. 
// WARNING: If content is huge, memory limit might be hit.

$encryptedContent = Security::encrypt($content);
file_put_contents($backupDir . $encryptedFilename, $encryptedContent);

// 3. Cleanup Plaintext
unlink($backupDir . $filename);

echo "[+] Backup Encrypted and Saved: {$encryptedFilename}\n";
echo "[*] Done.\n";

// Retention Policy: Keep only last 5 backups
$files = glob($backupDir . '*.enc');
if (count($files) > 5) {
    usort($files, function($a, $b) {
        return filemtime($a) - filemtime($b);
    });
    
    $toDelete = count($files) - 5;
    for ($i = 0; $i < $toDelete; $i++) {
        unlink($files[$i]);
        echo "[-] Rotation: Deleted old backup " . basename($files[$i]) . "\n";
    }
}
