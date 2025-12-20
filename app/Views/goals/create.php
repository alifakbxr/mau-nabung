<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Buat Target Tabungan Baru</h5>
            </div>
            <div class="card-body p-4">
                
                <!-- Dream Simulator Section -->
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <h6 class="alert-heading fw-bold"><i class="fas fa-calculator me-2"></i>Dream Simulator</h6>
                    <p class="mb-0 small">Bingung kapan target tercapai? Masukkan angka di bawah ini, kami akan hitungkan estimasinya untuk Anda.</p>
                    
                    <div class="row g-2 mt-2 align-items-end">
                        <div class="col-md-4">
                            <label class="small text-muted">Target (Rp)</label>
                            <input type="number" id="sim_target" class="form-control form-control-sm" placeholder="Contoh: 15000000">
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted">Nabung per Bulan (Rp)</label>
                            <input type="number" id="sim_monthly" class="form-control form-control-sm" placeholder="Contoh: 1000000">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-sm btn-dark w-100" onclick="simulateGoal()">
                                <i class="fas fa-magic me-1"></i> Hitung Estimasi
                            </button>
                        </div>
                    </div>
                    <div id="sim_result" class="mt-3 d-none">
                        <hr>
                        <div class="d-flex align-items-center">
                            <div class="display-6 fw-bold text-primary me-3" id="sim_months">0</div>
                            <div>
                                <span class="d-block fw-bold">Bulan lagi</span>
                                <span class="d-block small text-muted">Estimasi tercapai: <span id="sim_date">-</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="<?= base_url('/goals/store') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Target Impian</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Misal: Beli MacBook Air, Liburan ke Bali">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="target_amount" class="form-label">Total Target (Rp)</label>
                            <input type="number" class="form-control" id="target_amount" name="target_amount" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="current_amount" class="form-label">Saldo Awal (Opsional)</label>
                            <input type="number" class="form-control" id="current_amount" name="current_amount" value="0">
                            <div class="form-text">Jika Anda sudah mulai menabung.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label">Target Tanggal (Opsional)</label>
                            <input type="date" class="form-control" id="deadline" name="deadline">
                            <div class="form-text">Bisa diisi manual atau hasil simulasi.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="color" class="form-label">Warna Label</label>
                            <input type="color" class="form-control form-control-color w-100" id="color" name="color" value="#4e73df" title="Pilih warna">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="<?= base_url('/goals') ?>" class="text-decoration-none text-muted"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">Simpan Target</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
async function simulateGoal() {
    const target = document.getElementById('sim_target').value;
    const monthly = document.getElementById('sim_monthly').value;
    const resultDiv = document.getElementById('sim_result');

    if (!target || !monthly) {
        alert("Mohon isi Target dan Nabung per Bulan terlebih dahulu.");
        return;
    }

    try {
        const response = await fetch(`<?= base_url('/goals/simulate') ?>?target=${target}&monthly=${monthly}`);
        const data = await response.json();

        if (data.error) {
            alert(data.error);
            return;
        }

        document.getElementById('sim_months').textContent = data.months;
        document.getElementById('sim_date').textContent = data.estimated_date;
        resultDiv.classList.remove('d-none');
        
        // Auto fill real form
        document.getElementById('target_amount').value = target;
        
        // Don't autofill deadline because it depends on when they start, 
        // but checking the logic, the backend returns a calculated date based on "now".
        // It might be nice to format `data.estimated_date` (which is "d M Y") to YYYY-MM-DD
        // But for now, let the user manually input or we can enhance later.
        
    } catch (e) {
        console.error(e);
        alert("Gagal melakukan simulasi.");
    }
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
