<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Cara Kerja</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Mulai Dalam 3 Langkah Mudah</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Tidak perlu tutorial rumit. Maunabung didesain seintuitif mungkin agar Anda bisa langsung fokus menata keuangan.
        </p>
    </div>
</section>

<!-- Steps -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5 position-relative">
            <!-- Line connector for desktop -->
            <div class="d-none d-lg-block position-absolute start-50 top-0 bottom-0 border-start border-2 border-primary opacity-25" style="transform: translateX(-50%); z-index: 0;"></div>
            
            <!-- Step 1 -->
            <div class="col-lg-12 position-relative z-1">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-lg-end pe-lg-5">
                         <div class="d-inline-flex align-items-center justify-content-center bg-white shadow-sm rounded-circle p-4 mb-3 mb-lg-0" style="width: 100px; height: 100px;">
                            <span class="display-4 fw-bold text-primary">1</span>
                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 hover-lift">
                            <h3 class="fw-bold mb-3">Buat Akun Gratis</h3>
                            <p class="text-muted">Cukup daftar dengan nama dan email. Tidak perlu kartu kredit, tidak perlu verifikasi KTP. Privasi Anda terjaga.</p>
                        </div>
                    </div>
                </div>
            </div>
            
             <!-- Step 2 -->
            <div class="col-lg-12 position-relative z-1 mt-5">
                <div class="row align-items-center flex-row-reverse">
                     <div class="col-lg-6 text-lg-start ps-lg-5">
                         <div class="d-inline-flex align-items-center justify-content-center bg-white shadow-sm rounded-circle p-4 mb-3 mb-lg-0" style="width: 100px; height: 100px;">
                            <span class="display-4 fw-bold text-primary">2</span>
                        </div>
                    </div>
                    <div class="col-lg-6 pe-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 hover-lift text-lg-end bg-primary text-white">
                            <h3 class="fw-bold mb-3">Catat & Alokasikan</h3>
                            <p class="text-white-50">Input pemasukan gaji Anda, lalu gunakan fitur <strong class="text-white">Smart Allocator</strong> untuk membagi dana ke pos-pos kebutuhan secara otomatis.</p>
                        </div>
                    </div>
                </div>
            </div>
            
             <!-- Step 3 -->
            <div class="col-lg-12 position-relative z-1 mt-5">
                <div class="row align-items-center">
                     <div class="col-lg-6 text-lg-end pe-lg-5">
                         <div class="d-inline-flex align-items-center justify-content-center bg-white shadow-sm rounded-circle p-4 mb-3 mb-lg-0" style="width: 100px; height: 100px;">
                            <span class="display-4 fw-bold text-primary">3</span>
                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 hover-lift">
                            <h3 class="fw-bold mb-3">Pantau & Wujudkan</h3>
                            <p class="text-muted">Lihat grafik keuangan Anda tumbuh. Pantau progress bar target tabungan Anda hingga mencapai 100%.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="py-5 bg-light text-center">
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Gampang, Kan?</h2>
        <a href="<?= base_url('/register') ?>" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg hover-up">Mulai Sekarang</a>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
