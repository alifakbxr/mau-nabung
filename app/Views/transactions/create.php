<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Tambah Transaksi Baru</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/transactions/store') ?>" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipe Transaksi</label>
                            <select name="type" class="form-select" required>
                                <option value="expense">Pengeluaran</option>
                                <option value="income">Pemasukan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah (<?= $_SESSION['currency'] ?>)</label>
                        <input type="number" name="amount" class="form-control" placeholder="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?> (<?= $cat['type'] == 'income' ? 'Pemasukan' : 'Pengeluaran' ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">
                            <a href="<?= base_url('/categories') ?>" class="text-decoration-none">Kelola Kategori</a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Contoh: Makan siang di warteg"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/transactions') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
