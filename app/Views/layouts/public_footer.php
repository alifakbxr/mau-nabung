<footer class="bg-dark text-white py-5 mt-auto">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="bg-white rounded px-2 py-1 d-inline-block mb-3">
                    <img src="<?= base_url('/assets/img/maunabung_logo.png') ?>" alt="Maunabung" height="32">
                </div>
                <p class="text-white-50">Kelola keuangan pribadi Anda dengan lebih cerdas, hemat, dan terencana. 100% Gratis untuk semua orang.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50 hover-text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white-50 hover-text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white-50 hover-text-white"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2 offset-lg-1">
                <h6 class="fw-bold mb-3">Produk</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="<?= base_url('/features') ?>" class="text-white-50 text-decoration-none">Fitur</a></li>
                    <li><a href="<?= base_url('/how-it-works') ?>" class="text-white-50 text-decoration-none">Cara Kerja</a></li>
                    <li><a href="<?= base_url('/about') ?>" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3">Bantuan</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="<?= base_url('/faq') ?>" class="text-white-50 text-decoration-none">FAQ</a></li>
                    <li><a href="<?= base_url('/contact') ?>" class="text-white-50 text-decoration-none">Kontak</a></li>
                    <li><a href="<?= base_url('/compare') ?>" class="text-white-50 text-decoration-none">Perbandingan Fitur</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="<?= base_url('/terms') ?>" class="text-white-50 text-decoration-none">Ketentuan Layanan</a></li>
                    <li><a href="<?= base_url('/privacy') ?>" class="text-white-50 text-decoration-none">Kebijakan Privasi</a></li>
                    <li><a href="<?= base_url('/cookie-policy') ?>" class="text-white-50 text-decoration-none">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-4 border-top border-secondary text-center text-white-50 small">
            &copy; <?= date('Y') ?> Maunabung. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
