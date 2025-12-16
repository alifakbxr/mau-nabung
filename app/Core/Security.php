<?php

namespace App\Core;

class Security {
    public static function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken($token) {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            die('CSRF Token Validation Failed.');
        }
    }

    public static function encrypt($data) {
        // ENCRYPTION_KEY should be defined in environment, but for this demo using a fixed key if not set.
        // In production, this key must be kept secret and out of code.
        $key = defined('ENCRYPTION_KEY') ? ENCRYPTION_KEY : 'super-secret-key-please-change-me';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function decrypt($data) {
        $key = defined('ENCRYPTION_KEY') ? ENCRYPTION_KEY : 'super-secret-key-please-change-me';
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }

    public static function esc($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
