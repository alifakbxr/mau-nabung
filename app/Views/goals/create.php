<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Buat Target Menabung</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/goals/store') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Target</label>
                        <input type="text" name="name" class="form-control" placeholder="Cth: Beli iPhone 15, Liburan ke Bali" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Jumlah (<?= $_SESSION['currency'] ?? 'IDR' ?>)</label>
                        <input type="number" name="target_amount" class="form-control" placeholder="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Saldo Terkumpul Saat Ini</label>
                        <input type="number" name="current_amount" class="form-control" placeholder="0" value="0">
                        <div class="form-text">Jika Anda sudah mulai menabung sebelumnya.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Batas Waktu (Opsional)</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Warna Label</label>
                            <input type="color" name="color" class="form-control form-control-color w-100" value="#4e73df">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/goals') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Target</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
