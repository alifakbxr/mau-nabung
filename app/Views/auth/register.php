<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm border-0" style="max-width: 450px; width: 100%;">
        <div class="card-body p-5">
            <div class="text-center mb-5">
                <h1 class="h3 fw-bold text-dark mb-2">
                    <img src="<?= base_url('/assets/img/maunabung_logo.png') ?>" alt="Maunabung" height="32">
                </h1>
                <p class="text-secondary">Buat akun baru</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/register') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control" required placeholder="Budi Santoso">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="nama@email.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mata Uang</label>
                    <select name="currency" class="form-select">
                        <option value="IDR">IDR (Rupiah)</option>
                        <option value="USD">USD (Dollar)</option>
                        <option value="EUR">EUR (Euro)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="******" minlength="6">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Daftar</button>
            </form>

            <div class="text-center mt-5">
                <p class="text-secondary small">Sudah punya akun? <a href="<?= base_url('/login') ?>" class="text-primary fw-semibold text-decoration-none">Masuk</a></p>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
