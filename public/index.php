<?php

session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;

$router = new Router();

// Global Helper for Views
function base_url($path = '') {
    global $router;
    $base = $router->getBaseUrl();
    return $base . '/' . ltrim($path, '/');
}

function csrf_field() {
    $token = \App\Core\Security::generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function esc($string) {
    return \App\Core\Security::esc($string);
}

// Define Routes
// Auth
$router->add('GET', '/', 'AuthController', 'login');
$router->add('GET', '/login', 'AuthController', 'login');
$router->add('POST', '/login', 'AuthController', 'processLogin');
$router->add('GET', '/register', 'AuthController', 'register');
$router->add('POST', '/register', 'AuthController', 'processRegister');
$router->add('GET', '/logout', 'AuthController', 'logout');

// Dashboard
$router->add('GET', '/dashboard', 'DashboardController', 'index');

// Transactions
$router->add('GET', '/transactions', 'TransactionController', 'index');
$router->add('GET', '/transactions/create', 'TransactionController', 'create');
$router->add('POST', '/transactions/store', 'TransactionController', 'store');
$router->add('GET', '/transactions/edit', 'TransactionController', 'edit');
$router->add('POST', '/transactions/update', 'TransactionController', 'update');
$router->add('POST', '/transactions/delete', 'TransactionController', 'delete');

// Categories
$router->add('GET', '/categories', 'CategoryController', 'index');
$router->add('POST', '/categories/store', 'CategoryController', 'store');
$router->add('POST', '/categories/delete', 'CategoryController', 'delete');


// Accounts
$router->add('GET', '/accounts', 'AccountController', 'index');
$router->add('GET', '/accounts/create', 'AccountController', 'create');
$router->add('POST', '/accounts/store', 'AccountController', 'store');
$router->add('POST', '/accounts/delete', 'AccountController', 'delete');

// Goals
$router->add('GET', '/goals', 'SavingsGoalController', 'index');
$router->add('GET', '/goals/create', 'SavingsGoalController', 'create');
$router->add('POST', '/goals/store', 'SavingsGoalController', 'store');
$router->add('POST', '/goals/delete', 'SavingsGoalController', 'delete');

// Reports
$router->add('GET', '/reports', 'ReportController', 'index');
$router->add('GET', '/reports/export', 'ReportController', 'export');

// Profile
$router->add('GET', '/profile', 'ProfileController', 'index');
$router->add('POST', '/profile/update', 'ProfileController', 'update');


// Dispatch
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Handle query strings in router (simple version)
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$router->dispatch($uri, $method);
