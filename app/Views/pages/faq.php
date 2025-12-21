<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero / Header Section -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Pusat Bantuan</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Bantuan & Informasi</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Temukan jawaban atas pertanyaan Anda dan pelajari lebih lanjut tentang fitur-fitur Maunabung.
        </p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5">
            <!-- FAQ List -->
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="fas fa-question fa-sm"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Frequently Asked Questions</h4>
                </div>
                
                <div class="accordion accordion-flush" id="accordionFAQ">
                    <!-- Q1 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                1. Apa itu Aplikasi Manajemen Keuangan?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Aplikasi Manajemen Keuangan adalah platform berbasis website yang membantu pengguna mencatat, mengelola, dan memantau pemasukan, pengeluaran, serta target keuangan secara terstruktur.</div>
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                2. Siapa yang dapat menggunakan aplikasi ini?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Aplikasi ini dapat digunakan oleh individu, mahasiswa, pelaku UMKM, maupun siapa saja yang ingin mengelola keuangan pribadi secara online.</div>
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                3. Fitur apa saja yang tersedia di aplikasi ini?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">
                                Fitur utama yang tersedia meliputi:
                                <ul class="mb-0 mt-2 list-unstyled ps-3 border-start border-3 border-primary">
                                    <li class="mb-1 ms-2">Pencatatan pemasukan dan pengeluaran</li>
                                    <li class="mb-1 ms-2">Kategori keuangan</li>
                                    <li class="mb-1 ms-2">Target keuangan (tabungan / tujuan finansial)</li>
                                    <li class="mb-1 ms-2">Progress pencapaian target</li>
                                    <li class="mb-1 ms-2">Laporan keuangan (harian/bulanan)</li>
                                    <li class="mb-1 ms-2">Pencarian dan filter data</li>
                                    <li class="mb-1 ms-2">Dashboard ringkasan keuangan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Q4 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                4. Apa itu fitur Target Keuangan?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Fitur Target Keuangan memungkinkan pengguna menetapkan tujuan keuangan tertentu, seperti menabung untuk liburan, membeli gadget, atau dana darurat, lengkap dengan nominal dan batas waktu.</div>
                        </div>
                    </div>

                    <!-- Q5 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                5. Bagaimana cara menggunakan fitur Target Keuangan?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">
                                Pengguna dapat:
                                <ul class="mb-0 mt-2 list-unstyled ps-3 border-start border-3 border-primary">
                                    <li class="mb-1 ms-2">Menentukan nama target</li>
                                    <li class="mb-1 ms-2">Mengisi jumlah dana yang ingin dicapai</li>
                                    <li class="mb-1 ms-2">Menentukan tenggat waktu</li>
                                    <li class="mb-1 ms-2">Memantau progress pencapaian target melalui dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Q6 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                6. Apakah progress target keuangan dapat dipantau?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Ya, aplikasi menampilkan progress target dalam bentuk persentase atau indikator visual untuk memudahkan pemantauan.</div>
                        </div>
                    </div>

                    <!-- Q7 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                7. Apakah saya bisa mengubah atau menghapus target keuangan?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Ya, pengguna dapat mengedit atau menghapus target keuangan kapan saja sesuai kebutuhan.</div>
                        </div>
                    </div>

                    <!-- Q8 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                8. Apakah fitur target keuangan terhubung dengan pemasukan dan pengeluaran?
                            </button>
                        </h2>
                        <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Ya, target keuangan dapat disesuaikan dengan data pemasukan dan pengeluaran sehingga membantu perencanaan keuangan yang lebih realistis.</div>
                        </div>
                    </div>

                    <!-- Q9 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                9. Apakah data target keuangan saya aman?
                            </button>
                        </h2>
                        <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Ya, data target keuangan disimpan bersama data keuangan pengguna dan hanya dapat diakses oleh akun pengguna yang bersangkutan.</div>
                        </div>
                    </div>

                    <!-- Q10 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                10. Apakah aplikasi ini cocok untuk perencanaan keuangan jangka panjang?
                            </button>
                        </h2>
                        <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-muted pb-4">Ya, dengan adanya fitur target keuangan, aplikasi ini sangat membantu pengguna dalam merencanakan dan mencapai tujuan keuangan jangka pendek maupun jangka panjang.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- About Widget -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white overflow-hidden position-relative">
                         <div class="position-absolute top-0 end-0 p-3 opacity-25">
                            <i class="fas fa-wallet fa-5x transform-rotate-15"></i>
                        </div>
                        <div class="card-body p-4 position-relative z-1">
                            <h5 class="fw-bold mb-4">Tentang Maunabung</h5>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white/20 rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold small opacity-75">FITUR UTAMA</span>
                                    <span class="fw-bold">Target Menabung</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white/20 rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold small opacity-75">ANALISIS</span>
                                    <span class="fw-bold">Grafik Keuangan</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="bg-white/20 rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold small opacity-75">AKUN</span>
                                    <span class="fw-bold">Multi Dompet</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advantages Widget -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-dark">Keunggulan</h5>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex gap-3">
                                    <div class="text-success"><i class="fas fa-check-circle"></i></div>
                                    <div class="text-muted small"><strong>Terorganisir:</strong> Catat pemasukan dan pengeluaran rapi per kategori.</div>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="text-success"><i class="fas fa-check-circle"></i></div>
                                    <div class="text-muted small"><strong>Berorientasi Tujuan:</strong> Tetapkan target tabungan dengan deadline jelas.</div>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="text-success"><i class="fas fa-check-circle"></i></div>
                                    <div class="text-muted small"><strong>Transparan:</strong> Pantau progress langsung dari dashboard.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Widget -->
                    <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-danger">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-dark">Masih Butuh Bantuan?</h5>
                            <p class="text-muted small mb-4">Tim support kami siap membantu kendala Anda.</p>
                            
                            <div class="d-flex flex-column gap-2">
                                <a href="mailto:andikawirastudents@usu.ac.id" class="d-flex align-items-center p-2 rounded bg-light text-decoration-none text-dark hover-bg-gray">
                                    <i class="fas fa-envelope text-danger me-3"></i>
                                    <span class="fw-bold small">Email Support</span>
                                </a>
                                <a href="https://wa.me/6285765521588" class="d-flex align-items-center p-2 rounded bg-light text-decoration-none text-dark hover-bg-gray">
                                    <i class="fab fa-whatsapp text-danger me-3"></i>
                                    <span class="fw-bold small">WhatsApp Us</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
