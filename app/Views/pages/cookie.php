<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero / Header Section -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Legal</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Kebijakan Cookie</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Transparansi mengenai penggunaan teknologi pelacakan di platform kami.
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
                                <i class="fas fa-cookie-bite fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Status</h6>
                                <p class="mb-0 fw-bold text-dark">Berlaku Aktif</p>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">Apa itu Cookie?</h4>
                            <p class="text-muted leading-relaxed">Cookie adalah file teks kecil yang disimpan di perangkat Anda saat mengunjungi website. Cookie membantu kami mengingat preferensi Anda dan meningkatkan pengalaman pengguna.</p>
                        </div>

                         <div class="mb-5">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">Bagaimana Kami Menggunakan Cookie</h4>
                            <p class="text-muted leading-relaxed mb-3">Kami menggunakan beberapa jenis cookie untuk memastikan aplikasi berjalan lancar:</p>
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped rounded-3 overflow-hidden">
                                     <thead class="bg-light">
                                        <tr>
                                            <th class="py-3 ps-4 text-dark fw-bold">Jenis Cookie</th>
                                            <th class="py-3 text-dark fw-bold">Fungsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-4 fw-medium text-dark"><i class="fas fa-shield-alt text-primary me-2"></i> Wajib</td>
                                            <td class="text-muted small">Diperlukan untuk login, keamanan sesi (PHPSESSID), dan pencegahan CSRF.</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 fw-medium text-dark"><i class="fas fa-cog text-primary me-2"></i> Preferensi</td>
                                            <td class="text-muted small">Mengingat pengaturan seperti bahasa atau tema tampilan (Dark/Light Mode).</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 fw-medium text-dark"><i class="fas fa-chart-bar text-primary me-2"></i> Analitik</td>
                                            <td class="text-muted small">Membantu kami memahami interaksi pengguna secara anonim untuk perbaikan fitur.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-0">
                            <h4 class="fw-bold fs-4 mb-3 text-dark">Mengelola Cookie</h4>
                            <p class="text-muted leading-relaxed">Anda dapat mengatur browser Anda untuk menolak cookie, namun harap diperhatikan bahwa beberapa fitur aplikasi (seperti Login dan Dashboard) <span class="text-danger fw-bold">tidak akan berfungsi</span> tanpa cookie wajib.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
