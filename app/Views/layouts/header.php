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
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-white border-bottom">
        <div class="container-fluid px-4 py-2">
            <!-- Brand -->
            <a class="navbar-brand d-block" href="<?= base_url('/dashboard') ?>">
                <img src="<?= base_url('/assets/img/maunabung_logo.png') ?>" alt="Maunabung" height="32">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Main Menu -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a href="<?= base_url('/dashboard') ?>" class="nav-link px-3 <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : '' ?>">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/transactions') ?>" class="nav-link px-3 <?= strpos($_SERVER['REQUEST_URI'], '/transactions') !== false ? 'active' : '' ?>">
                            Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/accounts') ?>" class="nav-link px-3 <?= strpos($_SERVER['REQUEST_URI'], '/accounts') !== false ? 'active' : '' ?>">
                            Dompet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/goals') ?>" class="nav-link px-3 <?= strpos($_SERVER['REQUEST_URI'], '/goals') !== false ? 'active' : '' ?>">
                            Target
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/categories') ?>" class="nav-link px-3 <?= strpos($_SERVER['REQUEST_URI'], '/categories') !== false ? 'active' : '' ?>">
                            Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/reports') ?>" class="nav-link px-3 <?= strpos($_SERVER['REQUEST_URI'], '/reports') !== false ? 'active' : '' ?>">
                            Laporan
                        </a>
                    </li>
                </ul>

                <!-- User Menu & Actions -->
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item d-none d-lg-block">
                        <div class="vr h-100 mx-2 text-muted opacity-25"></div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border" style="width: 36px; height: 36px;">
                                <i class="fas fa-user text-secondary"></i>
                            </div>
                            <span class="d-lg-none">Akun Saya</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-3 p-2 rounded-3">
                            <li>
                                <a class="dropdown-item rounded-2 px-3 py-2" href="<?= base_url('/profile') ?>">
                                    <i class="fas fa-user me-2 text-muted"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-2 px-3 py-2" href="<?= base_url('/faq') ?>">
                                    <i class="fas fa-question-circle me-2 text-muted"></i> Bantuan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item rounded-2 px-3 py-2 text-danger" href="<?= base_url('/logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 76px;"></div> <!-- Spacer for fixed navbar -->
    <main class="main-content pt-4">
<?php endif; ?>
