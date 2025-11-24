<?php

namespace App\Core;

class Router {
    protected $routes = [];
    protected $baseUrl = '';

    public function __construct() {
        // Calculate Base URL automatically
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g. /maunabung/public/index.php
        $dirName = dirname($scriptName);       // e.g. /maunabung/public
        
        // Normalize slashes
        $dirName = str_replace('\\', '/', $dirName);
        
        // If we are in public, and it's not the root, we might want to treat the parent as base
        // if we are using the root .htaccess rewrite.
        // But simpler: just treat $dirName as the base prefix for matching.
        
        // However, if the request comes via the root .htaccess rewrite, 
        // the URI is /maunabung/dashboard, but the script is /maunabung/public/index.php.
        // The common part is /maunabung.
        
        // Let's try to match the URI against the route.
        $this->baseUrl = $dirName;
        
        // Special handling for the root .htaccess rewrite case
        // If URI is /maunabung/foo and Dir is /maunabung/public
        // We want to detect /maunabung as the base.
        if (substr($dirName, -7) === '/public') {
            $parent = substr($dirName, 0, -7);
            if (strpos($_SERVER['REQUEST_URI'], $parent) === 0) {
                // Check if 'public' is explicitly in the URI
                if (strpos($_SERVER['REQUEST_URI'], $dirName) !== 0) {
                    $this->baseUrl = $parent;
                }
            }
        }
        
        // Ensure trailing slash is removed
        $this->baseUrl = rtrim($this->baseUrl, '/');
    }

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Strip Base URL from URI
        if ($this->baseUrl !== '' && strpos($uri, $this->baseUrl) === 0) {
            $uri = substr($uri, strlen($this->baseUrl));
        }

        // Remove query string and trailing slash (unless it's root)
        $uri = rtrim($uri, '/');
        if ($uri === '') $uri = '/';

        // Basic routing logic
        foreach ($this->routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {
                $controllerClass = "App\\Controllers\\" . $route['controller'];
                $controller = new $controllerClass();
                $action = $route['action'];
                return $controller->$action();
            }
        }

        // 404 Not Found
        http_response_code(404);
        require __DIR__ . '/../Views/404.php';
    }
    
    public function getBaseUrl() {
        return $this->baseUrl;
    }
}
