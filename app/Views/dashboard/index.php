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
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card border-0 h-100 stat-card-wrapper">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <p class="text-secondary fw-medium mb-1">Pemasukan</p>
                        <h3 class="fw-bold text-dark mb-0"><?= $_SESSION['currency'] ?> <?= number_format($totals['total_income'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                    <div class="stat-icon bg-soft-success">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center text-sm">
                    <span class="badge bg-soft-success text-success rounded-pill px-2 py-1">
                        <i class="fas fa-arrow-up me-1"></i> +0%
                    </span>
                    <span class="text-muted ms-2 small">dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 stat-card-wrapper">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <p class="text-secondary fw-medium mb-1">Pengeluaran</p>
                        <h3 class="fw-bold text-dark mb-0"><?= $_SESSION['currency'] ?> <?= number_format($totals['total_expense'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                    <div class="stat-icon bg-soft-danger">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center text-sm">
                    <span class="badge bg-soft-danger text-danger rounded-pill px-2 py-1">
                        <i class="fas fa-arrow-up me-1"></i> +0%
                    </span>
                    <span class="text-muted ms-2 small">dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 stat-card-wrapper">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <p class="text-secondary fw-medium mb-1">Saldo Bulan Ini</p>
                        <h3 class="fw-bold text-dark mb-0"><?= $_SESSION['currency'] ?> <?= number_format(($totals['total_income'] ?? 0) - ($totals['total_expense'] ?? 0), 0, ',', '.') ?></h3>
                    </div>
                    <div class="stat-icon bg-soft-primary">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center text-sm">
                    <span class="text-muted small">Total akumulasi aset lancar</span>
                </div>
            </div>
        </div>
    </div>
</div>

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
