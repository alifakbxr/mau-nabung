<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Tambah Akun Baru</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/accounts/store') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="name" class="form-control" placeholder="Cth: Dompet Utama, BCA, OVO" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Akun</label>
                        <select name="type" class="form-select" required>
                            <option value="cash">Tunai / Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="ewallet">E-Wallet (Gopay/OVO/Dana)</option>
                            <option value="investment">Investasi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Saldo Awal (<?= $_SESSION['currency'] ?? 'IDR' ?>)</label>
                        <input type="number" name="balance" class="form-control" placeholder="0" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/accounts') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
