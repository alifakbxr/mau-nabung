<?php require __DIR__ . '/../layouts/public_header.php'; ?>

<!-- Hero / Header Section -->
<section class="py-5 bg-gradient-light border-bottom">
    <div class="container py-5 text-center">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 fw-bold">Kontak Kami</span>
        <h1 class="fw-bold display-5 mb-3 text-dark">Hubungi Kami</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Punya pertanyaan, kritik, atau saran? Kami siap mendengarkan.
        </p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-5 order-2 order-lg-1">
                <div class="d-flex flex-column gap-4">
                     <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Informasi Kontak</h5>
                            
                            <div class="d-flex gap-3 mb-4">
                                <div class="bg-soft-primary text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email</h6>
                                    <p class="text-muted mb-0">andikawirastudents@usu.ac.id</p>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-3 mb-4">
                                <div class="bg-soft-primary text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Lokasi</h6>
                                    <p class="text-muted mb-0">Medan, Indonesia</p>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-3">
                                <div class="bg-soft-primary text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Jam Operasional</h6>
                                    <p class="text-muted mb-0">Senin - Jumat, 09:00 - 17:00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                        <div class="card-body p-4 position-relative overflow-hidden">
                             <div class="position-absolute top-0 end-0 p-3 opacity-25">
                                <i class="fab fa-whatsapp fa-5x transform-rotate-15"></i>
                            </div>
                            <h5 class="fw-bold mb-3 position-relative z-1">Chat WhatsApp</h5>
                            <p class="text-white-50 mb-4 position-relative z-1 small">Lebih suka chatting? Hubungi kami langsung via WhatsApp untuk respons cepat.</p>
                            <a href="https://wa.me/6285765521588" class="btn btn-white text-primary w-100 fw-bold position-relative z-1">
                                <i class="fab fa-whatsapp me-2"></i> Chat Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="card border-0 shadow-lg rounded-4 h-100">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center gap-2 mb-4">
                             <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-paper-plane fa-sm"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Kirim Pesan</h4>
                        </div>
                        
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control bg-light border-0 py-3" placeholder="Nama Anda">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small fw-bold">Email</label>
                                    <input type="email" class="form-control bg-light border-0 py-3" placeholder="email@contoh.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-secondary small fw-bold">Subjek</label>
                                    <select class="form-select bg-light border-0 py-3">
                                        <option>Pertanyaan Umum</option>
                                        <option>Bantuan Teknis</option>
                                        <option>Kerjasama</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-secondary small fw-bold">Pesan</label>
                                    <textarea class="form-control bg-light border-0" rows="5" placeholder="Tulis pesan Anda di sini..."></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm hover-lift">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/public_footer.php'; ?>
