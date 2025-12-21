<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero / Header Section -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Legal</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Kebijakan Privasi</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Kami menghargai privasi Anda sebagaimana kami menghargai privasi kami sendiri.
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
                                <i class="fas fa-user-shield fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Terakhir Diperbarui</h6>
                                <p class="mb-0 fw-bold text-dark"><?= date('d F Y') ?></p>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">1. Informasi yang Kami Kumpulkan</h4>
                            <p class="text-muted leading-relaxed">Kami mengumpulkan informasi yang Anda berikan saat mendaftar, seperti nama dan alamat email. Kami juga mencatat data transaksi keuangan yang Anda input secara sukarela untuk keperluan fitur aplikasi.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">2. Penggunaan Informasi</h4>
                            <p class="text-muted leading-relaxed">Data Anda digunakan semata-mata untuk menyediakan fitur manajemen keuangan pribadi. Kami berkomitmen untuk:</p>
                            <ul class="text-muted mt-3 d-flex flex-column gap-2 mb-0">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Tidak menjual data Anda kepada pihak ketiga.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Tidak menggunakan data untuk iklan yang tidak relevan.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Hanya menggunakan data untuk peningkatan layanan.</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">3. Keamanan Data</h4>
                            <p class="text-muted leading-relaxed">Kami menggunakan enkripsi standar industri untuk melindungi data Anda. Namun, perlu diingat bahwa tidak ada metode transmisi internet atau penyimpanan elektronik yang 100% aman.</p>
                        </div>

                         <div class="mb-0">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">4. Hak Anda</h4>
                            <p class="text-muted leading-relaxed">Anda memiliki kendali penuh atas data Anda. Anda berhak meminta penghapusan akun dan seluruh data Anda kapan saja melalui dashboard pengguna atau dengan menghubungi tim support kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
