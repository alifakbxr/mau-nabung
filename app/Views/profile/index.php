<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark mb-4">Profil Saya</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('/profile/update') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                        <div class="form-text">Email tidak dapat diubah.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Uang Preferensi</label>
                        <select name="currency" class="form-select">
                            <option value="IDR" <?= $user['currency'] == 'IDR' ? 'selected' : '' ?>>IDR (Rupiah)</option>
                            <option value="USD" <?= $user['currency'] == 'USD' ? 'selected' : '' ?>>USD (Dollar)</option>
                            <option value="EUR" <?= $user['currency'] == 'EUR' ? 'selected' : '' ?>>EUR (Euro)</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Ganti Password</h5>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengganti">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
