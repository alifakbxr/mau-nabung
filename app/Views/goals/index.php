<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Target Menabung</h2>
    <a href="<?= base_url('/goals/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Buat Target Baru</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <?php foreach ($goals as $goal): 
        $percentage = $goal['target_amount'] > 0 ? ($goal['current_amount'] / $goal['target_amount']) * 100 : 0;
        $timeLeft = $goal['deadline'] ? (strtotime($goal['deadline']) - time()) / (60 * 60 * 24) : null;
    ?>
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><?= htmlspecialchars($goal['name']) ?></h5>
                    <form action="<?= base_url('/goals/delete') ?>" method="POST" onsubmit="return confirm('Hapus target ini?')">
                        <input type="hidden" name="id" value="<?= $goal['id'] ?>">
                        <button type="submit" class="btn btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                
                <h3 class="fw-bold text-dark mb-1"><?= number_format($goal['current_amount'], 0, ',', '.') ?> <span class="text-muted fs-6 fw-normal">/ <?= number_format($goal['target_amount'], 0, ',', '.') ?></span></h3>
                
                <div class="progress my-3" style="height: 10px;">
                    <div class="progress-bar rounded-pill" role="progressbar" style="width: <?= $percentage ?>%; background-color: <?= $goal['color'] ?>" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><?= number_format($percentage, 0) ?>% Tercapai</span>
                    <?php if ($timeLeft !== null): ?>
                        <span><?= $timeLeft > 0 ? ceil($timeLeft) . ' hari lagi' : 'Jatuh tempo' ?></span>
                    <?php else: ?>
                        <span>Tidak ada batas waktu</span>
                    <?php endif; ?>
                </div>

                <div class="d-grid">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFundsModal" 
                        onclick="setGoalInfo('<?= $goal['id'] ?>', '<?= htmlspecialchars($goal['name']) ?>')">
                        <i class="fas fa-plus-circle me-1"></i> Nabung (Alokasi Dana)
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('/goals/add-funds') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="modal_goal_id">
                <div class="modal-header">
                    <h5 class="modal-title">Nabung ke: <span id="modal_goal_name" class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Alokasi (Rp)</label>
                        <input type="number" name="amount" class="form-control" required min="1" placeholder="Contoh: 500000">
                        <div class="form-text">Uang ini akan ditambahkan ke progress target, tapi tidak mengubah saldo akun kas/bank Anda (Virtual Allocation).</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setGoalInfo(id, name) {
    document.getElementById('modal_goal_id').value = id;
    document.getElementById('modal_goal_name').textContent = name;
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
