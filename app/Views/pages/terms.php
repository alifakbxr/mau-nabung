<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero / Header Section -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Legal</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Ketentuan Layanan</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Harap baca ketentuan penggunaan ini dengan seksama sebelum menggunakan layanan kami.
        </p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                       <div class="d-flex align-items-center gap-3 mb-5 border-bottom pb-4">
                            <div class="bg-soft-primary text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-file-contract fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Terakhir Diperbarui</h6>
                                <p class="mb-0 fw-bold text-dark"><?= date('d F Y') ?></p>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">1. Penerimaan Ketentuan</h4>
                            <p class="text-muted leading-relaxed">Dengan mengakses, mendaftar, atau menggunakan aplikasi Maunabung, Anda menyetujui untuk terikat oleh Ketentuan Layanan ini. Jika Anda tidak setuju dengan bagian mana pun dari ketentuan ini, Anda tidak diperkenankan menggunakan layanan kami.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">2. Penggunaan Layanan</h4>
                            <p class="text-muted leading-relaxed">Maunabung adalah alat bantu pencatatan keuangan pribadi.</p>
                            <div class="alert alert-soft-warning border-0 d-flex align-items-start gap-3 mt-3">
                                <i class="fas fa-exclamation-triangle mt-1"></i>
                                <div class="small">
                                    <strong>Penafian:</strong> Kami tidak menyediakan nasihat keuangan profesional, investasi, atau pajak. Segala keputusan keuangan yang Anda buat berdasarkan data aplikasi adalah tanggung jawab Anda sepenuhnya.
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">3. Akun Pengguna</h4>
                            <p class="text-muted leading-relaxed mb-3">Untuk menggunakan fitur penuh, Anda harus mendaftar akun. Terkait akun:</p>
                            <ul class="text-muted d-flex flex-column gap-2 mb-0">
                                <li><i class="fas fa-check text-primary me-2"></i> Anda bertanggung jawab menjaga kerahasiaan kata sandi Anda.</li>
                                <li><i class="fas fa-check text-primary me-2"></i> Anda setuju untuk memberikan informasi yang akurat saat pendaftaran.</li>
                                <li><i class="fas fa-check text-primary me-2"></i> Kami berhak menonaktifkan akun yang melanggar hukum atau ketentuan ini.</li>
                            </ul>
                        </div>

                        <div class="mb-0">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">4. Perubahan Layanan</h4>
                            <p class="text-muted leading-relaxed">Kami terus mengembangkan aplikasi ini. Kami berhak mengubah, menunda, atau menghentikan layanan (gratis) ini kapan saja dengan atau tanpa pemberitahuan, meskipun kami akan selalu berusaha memberikan layanan terbaik dan stabil bagi pengguna kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
