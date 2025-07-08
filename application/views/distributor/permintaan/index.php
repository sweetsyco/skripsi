<div class="main-content">
        <div class="container py-4">
                <div class="page-header">
                        <h1><i class="fas fa-clipboard-list me-2"></i> Manajemen Permintaan</h1>
                        <a href="http://localhost/skripsi/distributor/permintaan/create" class="btn btn-new">
                            <i class="fas fa-plus-circle"></i> Buat Permintaan Baru
                        </a>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Daftar Permintaan Aktif</h3>
                            <div class="d-flex gap-2">
                                <div class="input-group" style="max-width: 300px;">
                                    <input type="text" class="form-control" placeholder="Cari permintaan..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Komoditas</th>
                                            <th width="15%">Jumlah</th>
                                            <th width="15%">Harga Maks</th>
                                            <th width="15%">Sisa Kebutuhan</th>
                                            <th width="15%">Status</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        <?php foreach ($permintaan as $index => $p): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <div class="fw-bold"><?= $p->nama_komoditas ?></div>
                                                <div class="text-muted small"><?= format_tanggal_indonesia($p->dibuat_pada) ?></div>
                                            </td>
                                            <td><?= number_format($p->jumlah, 0) . ' ' . $p->satuan ?></td>
                                            <td>Rp <?= number_format($p->harga_maks, 0, ',', '.') ?>/<?= $p->satuan ?></td>
                                            <td>
                                                <div class="progress-container">
                                                    <div class="progress-label">
                                                        <span><?= number_format($p->sisa_permintaan, 0) . ' ' . $p->satuan ?></span>
                                                        <span><?= round($p->progres) ?>%</span>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" 
                                                            role="progressbar" 
                                                            style="width: <?= $p->progres ?>%" 
                                                            aria-valuenow="<?= $p->progres ?>" 
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge <?= ($p->status == 'open') ? 'badge-open' : 'badge-closed' ?>">
                                                    <i class="fas fa-circle me-1"></i>
                                                    <?= ($p->status == 'open') ? 'Aktif' : 'Selesai' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="#" class="action-btn btn-view" data-id="<?= $p->id_permintaan ?>">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                    <?php if ($p->status == 'open'): ?>
                                                    <a href="<?= site_url('distributor/permintaan/tutup/' . $p->id_permintaan) ?>" class="action-btn btn-keluar"  data-id="close-<?= $p->id_permintaan ?>">
                                                        <i class="fas fa-times"></i> Tutup
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    </table>
                            </div>
                        </div>
                                                  
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Menampilkan 
                                    <?php 
                                        $start = ($current_page + 1); 
                                        $end = min($current_page + $per_page, $total_rows);
                                        echo ($total_rows > 0) ? $start . ' - ' . $end : '0';
                                    ?> 
                                    dari <?php echo $total_rows; ?> permintaan
                                </div>
                                <div>
                                    <?php echo $pagination_links; ?>
                                </div>
                            </div>
                        </div>
                    
                    <div class="card mt-4">
    <div class="card-header">
        <h3 class="mb-0">Statistik Permintaan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 border rounded-3 mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?= $total_permintaan ?></h4>
                        <p class="mb-0 text-muted">Total Permintaan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 border rounded-3 mb-3">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?= $permintaan_selesai ?></h4>
                        <p class="mb-0 text-muted">Permintaan Selesai</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5>Distribusi Komoditas</h5>
            <div class="row">
                <?php foreach ($komoditas_stats as $stat): ?>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><?= $stat->nama_komoditas ?></span>
                            <span><?= $stat->jumlah_permintaan ?> permintaan</span>
                        </div>
                        <div class="progress">
                            <?php 
                            $percentage = ($total_permintaan > 0) 
                                ? ($stat->jumlah_permintaan / $total_permintaan) * 100 
                                : 0;
                            ?>
                            <div class="progress-bar" 
                                role="progressbar" 
                                style="width: <?= $percentage ?>%; background-color: <?= generate_color($stat->nama_komoditas) ?>"
                                aria-valuenow="<?= $percentage ?>" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Permintaan</h5>
                <button type="button" class="btn-close combat" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Konten akan diisi via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
