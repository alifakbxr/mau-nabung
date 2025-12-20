<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-lg rounded-lg">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Smart Salary Allocator</h4>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-light border-start border-5 border-success mb-4">
                    <p class="mb-0 text-muted">Fitur ini membantu Anda mencatat Gaji Bulanan sekaligus membaginya secara cerdas menggunakan prinsip <strong>50/30/20</strong> (Needs, Wants, Savings).</p>
                </div>

                <form action="<?= base_url('/salary/process') ?>" method="POST" id="salaryForm">
                    <?= csrf_field() ?>

                    <!-- Step 1: Input Salary -->
                    <div class="mb-4">
                        <label class="form-label h5">Berapa Gaji Anda bulan ini?</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount" id="salaryInput" class="form-control fw-bold" placeholder="0" required min="100000">
                        </div>
                    </div>

                    <!-- Step 2: Select Account & Category -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Masuk ke Akun</label>
                            <select name="account_id" class="form-select" required>
                                <?php foreach ($accounts as $acc): ?>
                                    <option value="<?= $acc['id'] ?>"><?= htmlspecialchars($acc['name']) ?> (<?= htmlspecialchars($acc['type']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori Pemasukan</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Step 3: Allocation Preview -->
                    <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Rekomendasi Alokasi (50/30/20)</h5>
                    
                    <div class="row g-3 text-center mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <span class="badge bg-secondary mb-2">50% Needs</span>
                                <h5 class="mb-0 fw-bold text-dark" id="valNeeds">Rp 0</h5>
                                <small class="text-muted">Biaya Hidup</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <span class="badge bg-info mb-2">30% Wants</span>
                                <h5 class="mb-0 fw-bold text-dark" id="valWants">Rp 0</h5>
                                <small class="text-muted">Hiburan/Belanja</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded border-success bg-white shadow-sm">
                                <span class="badge bg-success mb-2">20% Savings</span>
                                <h5 class="mb-0 fw-bold text-success" id="valSavings">Rp 0</h5>
                                <small class="text-muted">Tabungan</small>
                                <input type="hidden" name="savings_amount" id="savingsAmountInput">
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Action (Savings) -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="autoAllocate" checked>
                            <label class="form-check-label fw-bold" for="autoAllocate">Otomatis Masukkan Tabungan ke Target?</label>
                        </div>
                        
                        <div id="savingsOption" class="mt-3">
                            <label class="form-label small">Pilih Target Tabungan</label>
                            <select name="savings_goal_id" class="form-select text-success fw-bold">
                                <option value="">-- Pilih Target (Opsional) --</option>
                                <?php foreach ($goals as $goal): ?>
                                    <option value="<?= $goal['id'] ?>"><?= htmlspecialchars($goal['name']) ?> (Total: <?= number_format($goal['target_amount']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Nominal 20% (atau yang Anda atur nanti) akan langsung menambah progress bar target ini.</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg shadow">
                            <i class="fas fa-check-circle me-2"></i> Simpan Pemasukan & Alokasikan
                        </button>
                        <a href="<?= base_url('/dashboard') ?>" class="btn btn-link text-muted">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const salaryInput = document.getElementById('salaryInput');
    const valNeeds = document.getElementById('valNeeds');
    const valWants = document.getElementById('valWants');
    const valSavings = document.getElementById('valSavings');
    const savingsAmountInput = document.getElementById('savingsAmountInput');
    const autoAllocate = document.getElementById('autoAllocate');
    const savingsOption = document.getElementById('savingsOption');

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }

    salaryInput.addEventListener('input', function() {
        const salary = parseFloat(this.value) || 0;
        
        const needs = salary * 0.5;
        const wants = salary * 0.3;
        const savings = salary * 0.2;

        valNeeds.textContent = formatRupiah(needs);
        valWants.textContent = formatRupiah(wants);
        valSavings.textContent = formatRupiah(savings);
        savingsAmountInput.value = savings;
    });

    autoAllocate.addEventListener('change', function() {
        if(this.checked) {
            savingsOption.classList.remove('d-none');
            savingsOption.querySelector('select').disabled = false;
        } else {
            savingsOption.classList.add('d-none');
            savingsOption.querySelector('select').disabled = true;
        }
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
