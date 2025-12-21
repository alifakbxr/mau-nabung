<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero / Header Section -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Perbandingan</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Mengapa Maunabung?</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Lihat bagaimana kami berbeda dari aplikasi pencatatan bisnis UMKM dan pelacak pengeluaran biasa. Maunabung didesain khusus untuk kesehatan finansial pribadi Anda.
        </p>
    </div>
</section>

<!-- Comparison Matrix Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white p-4 border-bottom">
                        <h4 class="fw-bold mb-0 text-center">Tabel Perbandingan</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-4 px-3 text-start text-dark fw-bold" style="width: 25%;">Aspek</th>
                                    <th class="py-4 px-3 text-muted fw-semibold" style="width: 25%;">Aplikasi UMKM<br><small class="fw-light">(BukuWarung, Majoo)</small></th>
                                    <th class="py-4 px-3 text-muted fw-semibold" style="width: 25%;">Expense Tracker Biasa</th>
                                    <th class="py-4 px-3 bg-soft-primary text-primary fw-bold" style="width: 25%;">
                                        <i class="fas fa-check-circle me-1"></i> Maunabung
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start py-3 px-4 fw-medium text-dark">Logika Pencatatan</td>
                                    <td class="text-muted">Bisnis (Stok & Kasir)</td>
                                    <td class="text-muted">Single Entry (Catat Saja)</td>
                                    <td class="bg-soft-primary text-dark fw-bold">Double Entry Lite (Validasi)</td>
                                </tr>
                                <tr>
                                    <td class="text-start py-3 px-4 fw-medium text-dark">Kepemilikan Data</td>
                                    <td class="text-muted">Cloud (Milik Vendor)</td>
                                    <td class="text-muted">Cloud / Lokal</td>
                                    <td class="bg-soft-primary text-dark fw-bold">Lokal / Pribadi (Aman)</td>
                                </tr>
                                <tr>
                                    <td class="text-start py-3 px-4 fw-medium text-dark">Fokus Utama</td>
                                    <td class="text-muted">Jualan & Operasional</td>
                                    <td class="text-muted">Mencatat Pengeluaran</td>
                                    <td class="bg-soft-primary text-dark fw-bold">Kesehatan & Target Finansial</td>
                                </tr>
                                <tr>
                                    <td class="text-start py-3 px-4 fw-medium text-dark">Monetisasi</td>
                                    <td class="text-muted">Iklan Pinjaman / Langganan</td>
                                    <td class="text-muted">Freemium (Banyak Iklan)</td>
                                    <td class="bg-soft-primary text-success fw-bold">100% Gratis Tanpa Iklan</td>
                                </tr>
                                <tr>
                                    <td class="text-start py-3 px-4 fw-medium text-dark">User Experience</td>
                                    <td class="text-muted">Ramai (Banyak Menu Jualan)</td>
                                    <td class="text-muted">Simpel tapi Terbatas</td>
                                    <td class="bg-soft-primary text-dark fw-bold">Modern, Fokus, Tenang</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detailed Comparison Cards -->
        <div class="row g-4 mt-5">
            <!-- Vs UMKM -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-soft-danger text-danger rounded-circle p-3 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-store-slash"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Bukan Aplikasi Kasir UMKM</h4>
                        </div>
                        <p class="text-muted mb-4">
                            Aplikasi seperti BukuWarung atau Majoo sangat hebat untuk pedagang karena memiliki fitur stok, kasir, dan cetak struk. Tapi untuk **keuangan pribadi**, fitur-fitur itu adalah gangguan ("bloatware").
                        </p>
                        <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                            <li class="d-flex align-items-start">
                                <i class="fas fa-check text-primary mt-1 me-3"></i>
                                <span class="text-muted"><strong>Maunabung Bersih:</strong> Tidak ada tawaran pinjaman modal atau menu "Jualan Pulsa" yang mengganggu fokus menabung Anda.</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="fas fa-check text-primary mt-1 me-3"></i>
                                <span class="text-muted"><strong>Fokus Gaji, Bukan Omzet:</strong> Kami membantu mengelola gaji bulanan, bukan menghitung profit jualan harian.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Vs Expense Trackers -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-soft-warning text-warning rounded-circle p-3 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Lebih Dari Sekadar Mencatat</h4>
                        </div>
                        <p class="text-muted mb-4">
                            Aplikasi pencatat biasa hanya memberitahu kemana uang Anda pergi (masa lalu). Maunabung membantu Anda merencanakan kemana uang harus pergi (masa depan).
                        </p>
                         <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                            <li class="d-flex align-items-start">
                                <i class="fas fa-check text-primary mt-1 me-3"></i>
                                <span class="text-muted"><strong>Validasi Double-Entry:</strong> Anda tidak bisa sekadar "mengedit saldo" jika uang hilang. Selisih harus dipertanggungjawabkan agar data akurat.</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="fas fa-check text-primary mt-1 me-3"></i>
                                <span class="text-muted"><strong>Simulasi Mimpi:</strong> Kalkulator built-in untuk menghitung kapan target tabungan Anda tercapai.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- Final CTA -->
<section class="py-5 bg-gradient-primary text-white">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-4">Siap untuk Upgrade Cara Mengelola Uang?</h2>
        <p class="lead mb-5 opacity-75">Tinggalkan cara lama yang rumit. Mulai perjalanan finansial yang lebih tenang hari ini.</p>
        <a href="<?= base_url('/register') ?>" class="btn btn-light text-primary btn-lg rounded-pill fw-bold px-5 py-3 shadow-lg hover-up">
            Mulai Sekarang - Gratis Selamanya
        </a>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
