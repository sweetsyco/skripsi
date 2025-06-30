<div class="main-content">
    <div class="container py-4">
        <div class="page-header">
            <h1><i class="fas fa-clipboard-list me-2"></i> Detail Permintaan</h1>
            <a href="<?= site_url('distributor/permintaan') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="mb-0">Informasi Permintaan</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Komoditas</div>
                    <div class="col-md-8"><?= $permintaan->nama_komoditas ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jumlah</div>
                    <div class="col-md-8"><?= number_format($permintaan->jumlah, 2) . ' ' . $permintaan->satuan ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Harga Maksimum</div>
                    <div class="col-md-8">Rp <?= number_format($permintaan->harga_maks, 0, ',', '.') ?> / <?= $permintaan->satuan ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Sisa Kebutuhan</div>
                    <div class="col-md-8">
                        <div class="progress-container">
                            <div class="progress-label">
                                <span><?= number_format($permintaan->sisa_permintaan, 2) . ' ' . $permintaan->satuan ?></span>
                                <span><?= round(($permintaan->jumlah - $permintaan->sisa_permintaan) / $permintaan->jumlah * 100, 2) ?>%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" 
                                    role="progressbar" 
                                    style="width: <?= ($permintaan->jumlah - $permintaan->sisa_permintaan) / $permintaan->jumlah * 100 ?>%" 
                                    aria-valuenow="<?= ($permintaan->jumlah - $permintaan->sisa_permintaan) / $permintaan->jumlah * 100 ?>" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8">
                        <span class="status-badge <?= ($permintaan->status == 'open') ? 'badge-open' : 'badge-closed' ?>">
                            <i class="fas fa-circle me-1"></i>
                            <?= ($permintaan->status == 'open') ? 'Aktif' : 'Selesai' ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Dibuat pada</div>
                    <div class="col-md-8"><?= format_tanggal_indonesia($permintaan->dibuat_pada) ?></div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Daftar Penawaran Masuk</h3>
                <div class="text-muted">Total diterima: <?= number_format($total_diterima, 2) ?> <?= $permintaan->satuan ?></div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Petani</th>
                                <th width="15%">Jumlah Penawaran</th>
                                <th width="15%">Harga</th>
                                <th width="15%">Tanggal Penawaran</th>
                                <th width="15%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($penawaran)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada penawaran</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($penawaran as $index => $p): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <div class="fw-bold"><?= $p->nama_petani ?></div>
                                        <div class="text-muted small"><?= $p->alamat ?></div>
                                        <div class="text-muted small"><?= $p->no_telepon ?></div>
                                    </td>
                                    <td><?= number_format($p->jumlah_penawaran, 2) . ' ' . $permintaan->satuan ?></td>
                                    <td>Rp <?= number_format($p->harga_penawaran, 0, ',', '.') ?></td>
                                    <td><?= format_tanggal_indonesia($p->dibuat_pada) ?></td>
                                    <td>
                                        <?php 
                                        $badge_class = '';
                                        if ($p->status == 'pending') {
                                            $badge_class = 'badge-pending';
                                        } elseif ($p->status == 'accepted') {
                                            $badge_class = 'badge-accepted';
                                        } elseif ($p->status == 'rejected') {
                                            $badge_class = 'badge-rejected';
                                        }
                                        ?>
                                        <span class="status-badge <?= $badge_class ?>">
                                            <i class="fas fa-circle me-1"></i>
                                            <?= ucfirst($p->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if ($p->status == 'pending' && $permintaan->status == 'open'): ?>
                                                <a href="<?= site_url('distributor/penawaran/terima/' . $p->id_penawaran) ?>" class="action-btn btn-accept">
                                                    <i class="fas fa-check"></i> Terima
                                                </a>
                                                <a href="<?= site_url('distributor/penawaran/tolak/' . $p->id_penawaran) ?>" class="action-btn btn-reject">
                                                    <i class="fas fa-times"></i> Tolak
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= site_url('distributor/penawaran/detail/' . $p->id_penawaran) ?>" class="action-btn btn-view">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>