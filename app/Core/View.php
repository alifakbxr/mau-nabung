<?php

namespace App\Core;

class View {
    public static function render($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View file not found: $viewFile");
        }
    }

    public static function redirect($url) {
        // Use the global base_url helper if available
        if (function_exists('base_url')) {
            $url = base_url($url);
        }
        header("Location: $url");
        exit;
    }
}
