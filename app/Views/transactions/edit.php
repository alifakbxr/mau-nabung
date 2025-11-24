<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit Transaksi</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/transactions/update') ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $transaction['id'] ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipe Transaksi</label>
                            <select name="type" class="form-select" required>
                                <option value="expense" <?= $transaction['type'] == 'expense' ? 'selected' : '' ?>>Pengeluaran</option>
                                <option value="income" <?= $transaction['type'] == 'income' ? 'selected' : '' ?>>Pemasukan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" value="<?= $transaction['transaction_date'] ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah (<?= $_SESSION['currency'] ?>)</label>
                        <input type="number" name="amount" class="form-control" value="<?= $transaction['amount'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $transaction['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                    <?= $cat['name'] ?> (<?= $cat['type'] == 'income' ? 'Pemasukan' : 'Pengeluaran' ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($transaction['description']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/transactions') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
