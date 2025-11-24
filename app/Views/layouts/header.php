<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maunabung - Kelola Keuanganmu</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
    <!-- Mobile Toggle -->
    <button class="btn btn-dark d-md-none position-fixed top-0 start-0 m-3 z-3 shadow-lg rounded-circle p-3" style="width: 50px; height: 50px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar d-none d-md-flex">
        <div class="sidebar-brand">
            <i class="fas fa-wallet"></i> Maunabung
        </div>
        <div class="d-flex flex-column gap-1 flex-grow-1">
            <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="<?= base_url('/transactions') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/transactions') !== false ? 'active' : '' ?>">
                <i class="fas fa-exchange-alt"></i> Transaksi
            </a>
            <a href="<?= base_url('/categories') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/categories') !== false ? 'active' : '' ?>">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="<?= base_url('/reports') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/reports') !== false ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Laporan
            </a>
            <a href="<?= base_url('/profile') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/profile') !== false ? 'active' : '' ?>">
                <i class="fas fa-user"></i> Profil
            </a>
        </div>
        <div class="mt-auto">
            <a href="<?= base_url('/logout') ?>" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </nav>

    <!-- Mobile Sidebar (Offcanvas) -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold text-white"><i class="fas fa-wallet text-primary"></i> Maunabung</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div class="d-flex flex-column gap-2 flex-grow-1">
                <a href="<?= base_url('/dashboard') ?>" class="nav-link text-white-50"><i class="fas fa-home me-2"></i> Dashboard</a>
                <a href="<?= base_url('/transactions') ?>" class="nav-link text-white-50"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a>
                <a href="<?= base_url('/categories') ?>" class="nav-link text-white-50"><i class="fas fa-tags me-2"></i> Kategori</a>
                <a href="<?= base_url('/reports') ?>" class="nav-link text-white-50"><i class="fas fa-chart-pie me-2"></i> Laporan</a>
                <a href="<?= base_url('/profile') ?>" class="nav-link text-white-50"><i class="fas fa-user me-2"></i> Profil</a>
            </div>
            <div class="mt-auto">
                <a href="<?= base_url('/logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
            </div>
        </div>
    </div>

    <main class="main-content">
<?php endif; ?>
