<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark"><i class="fas fa-fingerprint me-2"></i>Audit Trail (Forensik)</h2>
    <div class="text-muted small">
        Menampilkan 100 aktivitas terakhir sistem.
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-light sticky-top">
                    <tr>
                        <th width="15%">Waktu</th>
                        <th width="15%">User</th>
                        <th width="10%">Aksi</th>
                        <th width="15%">Entitas</th>
                        <th width="45%">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="text-nowrap"><?= date('d-M-Y H:i:s', strtotime($log['created_at'])) ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($log['user_name'] ?? 'System') ?></td>
                            <td>
                                <?php 
                                    $badge = 'secondary';
                                    if ($log['action'] == 'CREATE') $badge = 'success';
                                    if ($log['action'] == 'UPDATE') $badge = 'primary';
                                    if ($log['action'] == 'DELETE') $badge = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($log['action']) ?></span>
                            </td>
                            <td>
                                <code><?= htmlspecialchars($log['table_name']) ?></code> #<?= htmlspecialchars($log['record_id']) ?>
                            </td>
                            <td class="font-monospace text-wrap" style="font-size: 0.85em;">
                                <?php if ($log['old_values']): ?>
                                    <div class="text-danger mb-1">
                                        <i class="fas fa-minus-circle me-1"></i> Prev: <?= substr($log['old_values'], 0, 100) . (strlen($log['old_values']) > 100 ? '...' : '') ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($log['new_values']): ?>
                                    <div class="text-success">
                                        <i class="fas fa-plus-circle me-1"></i> New: <?= substr($log['new_values'], 0, 100) . (strlen($log['new_values']) > 100 ? '...' : '') ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
