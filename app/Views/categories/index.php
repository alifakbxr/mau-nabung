<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Kelola Kategori</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="fas fa-plus me-2"></i> Tambah Kategori
    </button>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Expense Categories -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold text-danger"><i class="fas fa-arrow-up me-2"></i> Pengeluaran</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php 
                    $hasExpense = false;
                    foreach ($categories as $cat): 
                        if ($cat['type'] == 'expense'):
                            $hasExpense = true;
                    ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <span class="rounded-circle p-2 me-3" style="background-color: <?= $cat['color'] ?>; width: 15px; height: 15px; display: inline-block;"></span>
                                <span class="fw-medium"><?= htmlspecialchars($cat['name']) ?></span>
                            </div>
                            <form action="<?= base_url('/categories/delete') ?>" method="POST" onsubmit="return confirm('Hapus kategori ini? Transaksi terkait mungkin akan kehilangan kategori.');">
                                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-link text-muted hover-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    <?php 
                        endif; 
                    endforeach; 
                    
                    if (!$hasExpense): ?>
                        <div class="text-muted text-center py-3">Belum ada kategori pengeluaran.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Categories -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold text-success"><i class="fas fa-arrow-down me-2"></i> Pemasukan</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php 
                    $hasIncome = false;
                    foreach ($categories as $cat): 
                        if ($cat['type'] == 'income'):
                            $hasIncome = true;
                    ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <span class="rounded-circle p-2 me-3" style="background-color: <?= $cat['color'] ?>; width: 15px; height: 15px; display: inline-block;"></span>
                                <span class="fw-medium"><?= htmlspecialchars($cat['name']) ?></span>
                            </div>
                            <form action="<?= base_url('/categories/delete') ?>" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-link text-muted hover-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    <?php 
                        endif; 
                    endforeach; 
                    
                    if (!$hasIncome): ?>
                        <div class="text-muted text-center py-3">Belum ada kategori pemasukan.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/categories/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Belanja, Gaji, Transportasi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-select" required>
                            <option value="expense">Pengeluaran</option>
                            <option value="income">Pemasukan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna Label</label>
                        <input type="color" name="color" class="form-control form-control-color w-100" value="#4f46e5" title="Pilih warna">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
