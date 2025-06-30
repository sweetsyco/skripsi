<div class="main-content">
    <div class="page-header">
        <h1>Laporan Penugasan Kurir</h1>
        <a href="<?= site_url('distributor/kurir') ?>" class="btn-action secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kurir
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Semua Penugasan Kurir</h3>
        </div>
        <div class="card-body">
            <?php if (empty($penugasan)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon text-muted">
                        <i class="fas fa-clipboard-list fa-3x"></i>
                    </div>
                    <h5 class="mt-3">Belum ada penugasan</h5>
                    <p>Belum ada penugasan untuk kurir Anda.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kurir</th>
                                <th>Komoditas</th>
                                <th>Petani</th>
                                <th>Jumlah (kg)</th>
                                <th>Catatan</th>
                                <th>Bukti Foto</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penugasan as $t): ?>
                                <tr>
                                    <td><?= date('d M Y H:i', strtotime($t->ditugaskan_pada)) ?></td>
                                    <td><?= $t->nama_kurir ?></td>
                                    <td><?= $t->nama_komoditas ?></td>
                                    <td><?= $t->nama_petani ?></td>
                                    <td><?= $t->jumlah ?></td>
                                    <td><?= $t->catatan ?: '-' ?></td>
                                    <td>
                                        <?php if ($t->foto_bukti): ?>
                                            <a href="<?= base_url($t->foto_bukti) ?>" 
                                            target="_blank" 
                                            class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($t->status == 'pending'): ?>
                                            <span class="badge badge-warning">Pending</span>
                                        <?php elseif ($t->status == 'approved'): ?>
                                            <span class="badge badge-success">Disetujui</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>