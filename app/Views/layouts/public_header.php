<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maunabung - Aplikasi Keuangan Pribadi Gratis</title>
    
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
<body class="landing-page">

<!-- Public Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white/95 backdrop-blur shadow-sm">
    <div class="container icon-link-hover">
        <a class="navbar-brand d-block" href="<?= base_url('/') ?>">
            <img src="<?= base_url('/assets/img/maunabung_logo.png') ?>" alt="Maunabung" height="32">
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="publicNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/features') ?>">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/how-it-works') ?>">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/faq') ?>">FAQ</a>
                </li>
                <li class="nav-item">
                     <a class="nav-link" href="<?= base_url('/contact') ?>">Kontak</a>
                </li>
            </ul>
            <div class="d-flex gap-2">
                <a href="<?= base_url('/login') ?>" class="btn btn-outline-primary px-4 rounded-pill fw-bold">Masuk</a>
                <a href="<?= base_url('/register') ?>" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm hover-lift">Daftar Gratis</a>
            </div>
        </div>
    </div>
</nav>
