<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
        <p class="text-secondary mb-0">Ringkasan keuanganmu bulan ini (<?= date('F Y', strtotime($startDate)) ?>)</p>
    </div>
    <a href="<?= base_url('/transactions/create') ?>" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus"></i> Tambah Transaksi
    </a>
</div>

<!-- Stats Cards -->

<!-- Net Worth & Overview -->
<div class="row g-4 mb-4">
    <!-- Total Net Worth Card -->
    <div class="col-md-12">
        <div class="card border-0 bg-primary text-white shadow-sm overflow-hidden position-relative">
            <div class="card-body p-4 position-relative z-1">
                <p class="mb-1 text-white-50">Total Kekayaan Bersih (Net Worth)</p>
                <h1 class="fw-bold mb-0"><?= $_SESSION['currency'] ?> <?= number_format($netWorth ?? 0, 0, ',', '.') ?></h1>
            </div>
            <i class="fas fa-wallet position-absolute opacity-25" style="font-size: 10rem; right: -2rem; bottom: -2rem; transform: rotate(-15deg);"></i>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Quick Accounts Preview -->
    <div class="col-md-8">
        <div class="card border-0 h-100 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Dompet & Akun Saya</h6>
                <a href="<?= base_url('/accounts') ?>" class="btn btn-sm btn-light text-primary">Kelola</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if (!empty($accounts)): ?>
                        <?php foreach (array_slice($accounts, 0, 4) as $acc): ?>
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block"><?= htmlspecialchars($acc['name']) ?></small>
                                    <span class="fw-bold"><?= number_format($acc['balance'], 0, ',', '.') ?></span>
                                </div>
                                <i class="fas <?= $acc['type'] == 'cash' ? 'fa-money-bill-wave' : ($acc['type'] == 'bank' ? 'fa-university' : 'fa-mobile-alt') ?> text-secondary opacity-50"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-muted py-3">Belum ada akun.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Cashflow Summary -->
    <div class="col-md-4">
         <div class="card border-0 h-100 shadow-sm">
            <div class="card-header bg-white text-center">
                <h6 class="mb-0 fw-bold">Cashflow Bulan Ini</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted">Masuk</span>
                    <span class="text-success fw-bold">+ <?= number_format($totals['total_income'] ?? 0, 0, ',', '.') ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted">Keluar</span>
                    <span class="text-danger fw-bold">- <?= number_format($totals['total_expense'] ?? 0, 0, ',', '.') ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Selisih</span>
                    <?php $diff = ($totals['total_income'] ?? 0) - ($totals['total_expense'] ?? 0); ?>
                    <span class="fw-bold <?= $diff >= 0 ? 'text-primary' : 'text-danger' ?>">
                        <?= number_format($diff, 0, ',', '.') ?>
                    </span>
                </div>
            </div>
         </div>
    </div>
</div>

<!-- Savings Goals Preview -->
<?php if (!empty($goals)): ?>
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Target Tabungan</h5>
        <a href="<?= base_url('/goals') ?>" class="text-decoration-none">Lihat Semua</a>
    </div>
    <div class="row g-3">
        <?php foreach (array_slice($goals, 0, 3) as $goal): 
              $percentage = $goal['target_amount'] > 0 ? ($goal['current_amount'] / $goal['target_amount']) * 100 : 0;
        ?>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold small"><?= htmlspecialchars($goal['name']) ?></span>
                        <span class="small text-muted"><?= number_format($percentage, 0) ?>%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar rounded-pill" style="width: <?= $percentage ?>%; background-color: <?= $goal['color'] ?>"></div>
                    </div>
                    <div class="mt-2 text-end small text-muted">
                        <?= number_format($goal['current_amount'], 0, ',', '.') ?> / <?= number_format($goal['target_amount'], 0, ',', '.') ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="row g-4">
    <!-- Charts -->
    <div class="col-lg-8">
        <div class="card border-0 h-100">
            <div class="card-header bg-transparent">
                <h5 class="mb-0 fw-bold">Pengeluaran per Kategori</h5>
            </div>
            <div class="card-body">
                <div style="height: 300px; position: relative;">
                    <canvas id="expenseChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="col-lg-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Transaksi Terakhir</h5>
                <a href="<?= base_url('/transactions') ?>" class="btn btn-sm btn-light text-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php if (empty($recentTransactions)): ?>
                        <div class="p-5 text-center text-muted">
                            <i class="fas fa-receipt fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada transaksi.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recentTransactions as $t): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-bottom-0">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: <?= $t['category_color'] ?>15; color: <?= $t['category_color'] ?>">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark fw-semibold"><?= htmlspecialchars($t['description']) ?></h6>
                                        <small class="text-muted"><?= date('d M Y', strtotime($t['transaction_date'])) ?></small>
                                    </div>
                                </div>
                                <span class="fw-bold <?= $t['type'] == 'income' ? 'text-success' : 'text-danger' ?>">
                                    <?= $t['type'] == 'income' ? '+' : '-' ?> <?= number_format($t['amount'], 0, ',', '.') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Prepare data for chart
$labels = [];
$data = [];
$colors = [];
foreach ($expenseBreakdown as $cat) {
    $labels[] = $cat['name'];
    $data[] = $cat['total'];
    $colors[] = $cat['color'];
}
?>

<?php ob_start(); ?>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                data: <?= json_encode($data) ?>,
                backgroundColor: <?= json_encode($colors) ?>,
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            },
            cutout: '75%'
        }
    });
</script>
<?php $extraScripts = ob_get_clean(); ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
