<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Laporan Keuangan</h2>
    <a href="<?= base_url('/reports/export?start_date=' . $startDate . '&end_date=' . $endDate) ?>" class="btn btn-outline-primary">
        <i class="fas fa-download me-2"></i> Export CSV
    </a>
</div>

<!-- Date Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= base_url('/reports') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="<?= $startDate ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="<?= $endDate ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <h6 class="opacity-75 mb-2">Total Pemasukan</h6>
                <h3 class="fw-bold mb-0"><?= $_SESSION['currency'] ?> <?= number_format($totals['total_income'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-danger text-white h-100">
            <div class="card-body">
                <h6 class="opacity-75 mb-2">Total Pengeluaran</h6>
                <h3 class="fw-bold mb-0"><?= $_SESSION['currency'] ?> <?= number_format($totals['total_expense'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-dark text-white h-100">
            <div class="card-body">
                <h6 class="opacity-75 mb-2">Saldo Periode Ini</h6>
                <h3 class="fw-bold mb-0"><?= $_SESSION['currency'] ?> <?= number_format(($totals['total_income'] ?? 0) - ($totals['total_expense'] ?? 0), 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Expense Breakdown -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Rincian Pengeluaran</h5>
            </div>
            <div class="card-body">
                <?php if (empty($expenseBreakdown)): ?>
                    <p class="text-muted text-center py-4">Tidak ada data pengeluaran.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <?php foreach ($expenseBreakdown as $item): ?>
                                    <tr>
                                        <td style="width: 20px;">
                                            <span class="rounded-circle d-block" style="width: 12px; height: 12px; background-color: <?= $item['color'] ?>"></span>
                                        </td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td class="text-end fw-bold"><?= number_format($item['total'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Income Breakdown -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Rincian Pemasukan</h5>
            </div>
            <div class="card-body">
                <?php if (empty($incomeBreakdown)): ?>
                    <p class="text-muted text-center py-4">Tidak ada data pemasukan.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <?php foreach ($incomeBreakdown as $item): ?>
                                    <tr>
                                        <td style="width: 20px;">
                                            <span class="rounded-circle d-block" style="width: 12px; height: 12px; background-color: <?= $item['color'] ?>"></span>
                                        </td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td class="text-end fw-bold"><?= number_format($item['total'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
