<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero Section -->
<section class="hero-section py-5 py-lg-7 d-flex align-items-center position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start z-1">
                <div class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-check-circle me-1"></i> #1 Aplikasi Keuangan Gratis
                </div>
                <h1 class="display-4 fw-bolder mb-3 text-dark lh-tight">
                    Atur Keuangan.<br>
                    <span class="text-primary">Wujudkan Impian.</span>
                </h1>
                <p class="lead text-secondary mb-4 col-lg-10 ps-0 mx-auto mx-lg-0">
                    Catat pengeluaran, pantau tabungan, dan capai target finansial Anda dengan mudah. Tanpa biaya langganan, tanpa ribet.
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="<?= base_url('/register') ?>" class="btn btn-primary btn-lg px-5 py-3 shadow-lg hover-lift">
                        Mulai Gratis Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="#how-it-works" class="btn btn-outline-secondary btn-lg px-4 py-3">
                        <i class="fas fa-play-circle me-2"></i> Cara Kerja
                    </a>
                </div>
                <div class="mt-4 pt-3 d-flex align-items-center justify-content-center justify-content-lg-start gap-4 text-muted small">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check text-success"></i> Gratis Selamanya
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check text-success"></i> Data Aman
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check text-success"></i> Tanpa Iklan
                    </div>
                </div>
            </div>
            <div class="col-lg-6 position-relative z-0">
                <!-- Abstract Background Blobs -->
                <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 bg-primary opacity-10 rounded-circle blur-3xl scale-75"></div>
                
                <!-- Dashboard Preview Card -->
                <div class="card border-0 shadow-2xl rounded-4 overflow-hidden transform-tilt-left bg-white" style="transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-2">
                        <div class="d-flex gap-2">
                            <div class="rounded-circle bg-danger opacity-25" style="width: 10px; height: 10px;"></div>
                            <div class="rounded-circle bg-warning opacity-25" style="width: 10px; height: 10px;"></div>
                            <div class="rounded-circle bg-success opacity-25" style="width: 10px; height: 10px;"></div>
                        </div>
                        <div class="bg-light rounded-pill px-3 py-1 text-xs text-muted mx-auto w-50 text-center small">maunabung.com/dashboard</div>
                    </div>
                    <div class="card-body p-0">
                         <!-- Mimic Dashboard UI with HTML/CSS only to avoid image dependency -->
                         <div class="p-4 bg-light">
                             <div class="row g-3">
                                 <div class="col-12">
                                     <div class="h5 fw-bold mb-3">Ringkasan Keuangan</div>
                                 </div>
                                 <div class="col-6">
                                     <div class="bg-primary text-white p-3 rounded-3 h-100">
                                         <small class="opacity-75">Total Saldo</small>
                                         <div class="h4 mb-0 fw-bold">Rp 12.500.000</div>
                                     </div>
                                 </div>
                                 <div class="col-6">
                                     <div class="bg-white p-3 rounded-3 shadow-sm h-100 border">
                                         <small class="text-muted">Pengeluaran</small>
                                         <div class="h4 mb-0 fw-bold text-danger">- Rp 2.400.000</div>
                                     </div>
                                 </div>
                                 <div class="col-12">
                                     <div class="bg-white p-3 rounded-3 shadow-sm border mt-1">
                                         <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-bold small">Cashflow</span>
                                            <span class="badge bg-success bg-opacity-10 text-success">+15% vs Last Month</span>
                                         </div>
                                         <div class="d-flex align-items-end gap-2" style="height: 60px;">
                                             <div class="bg-primary opacity-25 rounded-top w-100" style="height: 40%"></div>
                                             <div class="bg-primary opacity-50 rounded-top w-100" style="height: 70%"></div>
                                             <div class="bg-primary opacity-25 rounded-top w-100" style="height: 30%"></div>
                                             <div class="bg-primary rounded-top w-100" style="height: 85%"></div>
                                             <div class="bg-primary opacity-25 rounded-top w-100" style="height: 50%"></div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5 mw-lg mx-auto" style="max-width: 700px;">
            <div class="text-primary fw-bold text-uppercase tracking-wide small mb-2">Kenapa Maunabung?</div>
            <h2 class="fw-bold display-6 mb-3">Semua Fitur Premium, <span class="text-primary">Tanpa Biaya</span></h2>
            <p class="text-muted lead">Kami percaya pengelolaan keuangan yang baik adalah hak semua orang. Nikmati fitur lengkap tanpa batasan.</p>
        </div>
        
        <div class="row g-4 pt-3">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-up p-4 text-center text-md-start">
                    <div class="icon-box bg-soft-primary text-primary rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Manajemen Dompet</h5>
                    <p class="text-muted">Kelola banyak akun sekaligus. Tunai, Bank, E-Wallet, semua tercatat rapi dalam satu dashboard.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-up p-4 text-center text-md-start">
                    <div class="icon-box bg-soft-success text-success rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Target Tabungan</h5>
                    <p class="text-muted">Set target impianmu, pantau progressnya, dan capai tujuan finansial lebih cepat dengan visualisasi yang jelas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-up p-4 text-center text-md-start">
                    <div class="icon-box bg-soft-danger text-danger rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-chart-pie fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Laporan & Analisis</h5>
                    <p class="text-muted">Pahami kebiasaan belanjamu dengan grafik yang mudah dibaca. Tahu kemana perginya setiap rupiah.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works & CTA -->
<section id="how-it-works" class="py-5 bg-gradient-light">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="pe-lg-5">
                    <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">Mudah & Cepat</span>
                    <h2 class="fw-bold display-6 mb-4">Mulai Perbaiki Keuanganmu dalam 3 Menit</h2>
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 bg-white shadow-sm text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 50px; height: 50px;">1</div>
                            <div>
                                <h5 class="fw-bold">Daftar Akun</h5>
                                <p class="text-muted mb-0">Hanya butuh email dan nama. Tanpa verifikasi KTP/data sensitif.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 bg-white shadow-sm text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 50px; height: 50px;">2</div>
                            <div>
                                <h5 class="fw-bold">Catat Transaksi</h5>
                                <p class="text-muted mb-0">Input pemasukan dan pengeluaran harianmu dengan cepat.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 bg-white shadow-sm text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 50px; height: 50px;">3</div>
                            <div>
                                <h5 class="fw-bold">Pantau & Evaluasi</h5>
                                <p class="text-muted mb-0">Lihat grafik pertumbuhan asetmu dan evaluasi budget bulanan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card bg-dark text-white p-5 rounded-4 text-center position-relative overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-10" style="background: radial-gradient(circle at top right, #2563eb, transparent);"></div>
                    <div class="position-relative z-1">
                        <h2 class="fw-bold mb-3">Siap Mengatur Keuangan?</h2>
                        <p class="text-white-50 mb-4 px-lg-4">Bergabunglah dengan ribuan pengguna lain yang telah berhasil mencapai target finansial mereka bersama Maunabung.</p>
                        <a href="<?= base_url('/register') ?>" class="btn btn-light text-primary fw-bold px-5 py-3 rounded-pill hvr-scale">
                            Buat Akun Gratis Sekarang
                        </a>
                        <p class="mt-4 text-white-50 small mb-0">100% Gratis • Data Aman • Tanpa Komitmen</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 bg-white border-top border-secondary border-opacity-10">
    <div class="container py-5 text-center">
        <h2 class="fw-bold mb-4">Tentang Maunabung</h2>
        <p class="lead text-muted mx-auto" style="max-width: 800px;">
            Maunabung dibangun dengan satu misi sederhana: <strong>Membantu masyarakat Indonesia mencapai kebebasan finansial melalui pencatatan yang disiplin.</strong> Kami percaya bahwa alat keuangan yang baik tidak harus mahal, itulah sebabnya Maunabung hadir 100% Gratis untuk selamanya.
        </p>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
