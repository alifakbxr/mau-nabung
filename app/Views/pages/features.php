<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Fitur Lengkap</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Kelola Keuangan dengan Cara Cerdas</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Dari pencatatan harian hingga simulasi mimpi masa depan, Maunabung punya semua alat yang Anda butuhkan.
        </p>
    </div>
</section>

<!-- Core Features -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5 align-items-center mb-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="lc-block mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center p-3 bg-soft-primary text-primary rounded-circle mb-4">
                         <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Double-Entry Lite</h2>
                    <p class="text-muted lead">Sistem akuntansi standar industri yang disederhanakan. Jaminan saldo di aplikasi 100% sama dengan uang di dompet nyata Anda.</p>
                </div>
                <ul class="list-unstyled d-flex flex-column gap-3 text-muted">
                    <li><i class="fas fa-check-circle text-primary me-2"></i> Validasi transaksi otomatis.</li>
                    <li><i class="fas fa-check-circle text-primary me-2"></i> Mencegah selisih saldo yang membingungkan.</li>
                    <li><i class="fas fa-check-circle text-primary me-2"></i> Mendukung multi-akun (Bank, E-Wallet, Tunai).</li>
                </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                 <!-- Abstract Visual using CSS -->
                 <div class="bg-light rounded-4 p-5 text-center position-relative overflow-hidden">
                    <div class="position-absolute top-50 start-50 translate-middle bg-white shadow-lg rounded-3 p-4" style="width: 80%; min-height: 200px; transform: rotate(-3deg);">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <span class="fw-bold">Dompet Utama</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="text-start">
                            <small class="text-muted">Total Saldo</small>
                            <h3 class="fw-bold">Rp 5.250.000</h3>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        
        <div class="row g-5 align-items-center py-5">
            <div class="col-lg-6">
                  <div class="bg-light rounded-4 p-5 text-center position-relative overflow-hidden">
                    <div class="position-absolute top-50 start-50 translate-middle bg-white shadow-lg rounded-3 p-4" style="width: 80%; min-height: 200px; transform: rotate(3deg);">
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold small">Macbook Air M1</span>
                            <span class="text-primary fw-bold small">75%</span>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="col-lg-6">
                <div class="lc-block mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center p-3 bg-soft-warning text-warning rounded-circle mb-4">
                         <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Dream Simulator (Target Tabungan)</h2>
                    <p class="text-muted lead">Jangan cuma mencatat pengeluaran. Rencanakan masa depan dengan fitur simulasi target yang cerdas.</p>
                </div>
                 <ul class="list-unstyled d-flex flex-column gap-3 text-muted">
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Hitung kapan target barang impian terbeli.</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Visualisasi progress bar yang memotivasi.</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Alokasi dana dengan satu klik tombol "Nabung".</li>
                </ul>
            </div>
        </div>
        
         <div class="row g-5 align-items-center py-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="lc-block mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center p-3 bg-soft-success text-success rounded-circle mb-4">
                         <i class="fas fa-chart-pie fa-2x"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Smart Salary Allocator</h2>
                    <p class="text-muted lead">Begitu gajian masuk, asisten cerdas ini akan membantu membagi uang Anda dengan metode 50/30/20.</p>
                </div>
                <ul class="list-unstyled d-flex flex-column gap-3 text-muted">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Otomatis alokasi: Needs, Wants, Savings.</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Mencegah uang habis sebelum akhir bulan.</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Membangun kebiasaan disiplin finansial.</li>
                </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                 <div class="bg-light rounded-4 p-5 text-center position-relative overflow-hidden">
                    <div class="position-absolute top-50 start-50 translate-middle bg-white shadow-lg rounded-circle p-4 d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                        <div class="text-center">
                            <span class="d-block text-muted small">Alokasi</span>
                            <span class="d-block fw-bold display-6">50%</span>
                            <span class="badge bg-success rounded-pill mt-2">Kebutuhan</span>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Semua Fitur Ini, 100% Gratis.</h2>
        <a href="<?= base_url('/register') ?>" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg hover-up">Coba Sekarang</a>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
