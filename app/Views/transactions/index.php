<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Daftar Transaksi</h2>
    <a href="<?= base_url('/transactions/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Tambah Baru</a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= base_url('/transactions') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="<?= $filters['start_date'] ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="<?= $filters['end_date'] ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $filters['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Transaction List -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Tidak ada transaksi ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td class="ps-4"><?= date('d M Y', strtotime($t['transaction_date'])) ?></td>
                                <td>
                                    <span class="badge rounded-pill fw-normal text-dark" style="background-color: <?= $t['category_color'] ?>40">
                                        <?= htmlspecialchars($t['category_name'] ?? 'Tanpa Kategori') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($t['description']) ?></td>
                                <td class="fw-bold <?= $t['type'] == 'income' ? 'text-success' : 'text-danger' ?>">
                                    <?= $t['type'] == 'income' ? '+' : '-' ?> <?= number_format($t['amount'], 0, ',', '.') ?>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= base_url('/transactions/edit?id=' . $t['id']) ?>" class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                                    <form action="<?= base_url('/transactions/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
