<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Dompet & Akun</h2>
    <a href="<?= base_url('/accounts/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Tambah Akun</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <?php foreach ($accounts as $acc): ?>
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($acc['name']) ?></h5>
                        <span class="badge bg-light text-dark border"><?= ucfirst($acc['type']) ?></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="<?= base_url('/accounts/delete') ?>" method="POST" onsubmit="return confirm('Hapus akun ini? Transaksi terkait mungkin akan error datanya.')">
                                    <input type="hidden" name="id" value="<?= $acc['id'] ?>">
                                    <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="fw-bold text-primary mb-0"><?= number_format($acc['balance'], 0, ',', '.') ?></h3>
                <small class="text-muted">Saldo Saat Ini</small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
