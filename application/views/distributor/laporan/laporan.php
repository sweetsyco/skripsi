<div class="main-content">
        <div class="container py-4">
            <div class="page-header">
                <h1><i class="fas fa-file-alt me-2"></i> Laporan Distributor</h1>
                <div>
                        <a href="<?= base_url('distributor/laporan/export_pdf?start_date='.$filter['start_date'].'&end_date='.$filter['end_date'].'&status='.$filter['status'].'&id_komoditas='.$filter['id_komoditas']) ?>" class="btn btn-new">
                        <i class="fas fa-file-pdf me-1"></i> Ekspor PDF
                        </a>
                    <br>
                         <a href="<?= site_url('distributor/laporan/export_excel?start_date='.$filter['start_date'].'&end_date='.$filter['end_date'].'&status='.$filter['status'].'&id_komoditas='.$filter['id_komoditas']) ?>" class="btn btn-new" style="background-color: var(--secondary);">
                        <i class="fas fa-file-excel me-1"></i> Ekspor Excel
                    </a>
                    
                </div>
            </div>
            <form method="GET" action="<?= site_url('distributor/laporan') ?>">
            <div class="filter-container">
                <div class="row">
                    <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="<?= $filter['start_date'] ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" value="<?= $filter['end_date'] ?>">
                            </div>
                        </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                    <option value="all" <?= ($filter['status'] == 'all') ? 'selected' : '' ?>>Semua Status</option>
                                    <option value="aktif" <?= ($filter['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="selesai" <?= ($filter['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                </select>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Komoditas</label>
                            <select class="form-select" name="id_komoditas">
                                <option value="all" <?= ($filter['id_komoditas'] == 'all') ? 'selected' : '' ?>>Semua Komoditas</option>
                                    <?php foreach($komoditas_list as $komoditas): ?>
                                        <option value="<?= $komoditas->id_komoditas ?>" <?= ($filter['id_komoditas'] == $komoditas->id_komoditas) ? 'selected' : '' ?>>
                                            <?= $komoditas->nama_komoditas ?>
                                            </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-new me-2">
                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-sync me-1"></i> Reset
                    </button>
                </div>
            </div>
            
            <div class="stats-container">
                <div class="stat-card vertical">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-value"><?= $total_permintaan ?></div>
                    <div class="stat-label">Total Permintaan</div>
                </div>
                <div class="stat-card vertical">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value"><?= $permintaan_selesai ?></div>
                    <div class="stat-label">Permintaan Selesai</div>
                </div>
                <div class="stat-card vertical">
                    <div class="stat-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="stat-value"><?= $total_penawaran ?></div>
                    <div class="stat-label">Total Penawaran</div>
                </div>
                <div class="stat-card vertical">
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-value"><?= $pengiriman_selesai ?></div>
                    <div class="stat-label">Pengiriman Selesai</div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Statistik Permintaan</h3>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: auto;">
                            <option>Bulanan</option>
                            <option>Mingguan</option>
                            <option>Tahunan</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="permintaanChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Detail Laporan Permintaan</h3>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" placeholder="Cari laporan...">
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
                                    <th width="15%">Tanggal</th>
                                    <th width="12%">Jumlah</th>
                                    <th width="15%">Harga Maks</th>
                                    <th width="10%">Penawaran</th>
                                    <th width="10%">Diterima</th>
                                    <th width="10%">Pengiriman</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach($laporan_permintaan as $laporan): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-bold"><?= $laporan->nama_komoditas ?></div>
                                        <div class="text-muted small">ID: <?= $laporan->id_permintaan ?></div>
                                    </td>
                                    <td><?= date('d M Y', strtotime($laporan->dibuat_pada)) ?></td>
                                    <td><?= number_format($laporan->jumlah, 2) ?> kg</td>
                                    <td>Rp <?= number_format($laporan->harga_maks, 0, ',', '.') ?>/kg</td>
                                    <td><?= $laporan->jumlah_penawaran ?></td>
                                    <td><?= number_format($laporan->jumlah_diterima, 2) ?> kg</td>
                                    <td><?= $laporan->jumlah_pengiriman ?></td>
                                    <td>
                                        <span class="status-badge <?= ($laporan->status == 'selesai') ? 'badge-closed' : 'badge-open' ?>">
                                            <i class="fas <?= ($laporan->status == 'selesai') ? 'fa-check-circle' : 'fa-sync-alt' ?> me-1"></i>
                                            <?= ($laporan->status == 'selesai') ? 'Selesai' : 'Proses' ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= count($laporan_permintaan) ?> dari <?= $total_permintaan ?> permintaan
                        </div>
                        <div>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="mb-0">Distribusi Komoditas</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="komoditasChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php foreach($distribusi_komoditas as $index => $dist): ?>
                            <div class="commodity-item">
                                <div class="commodity-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0"><?= $dist->nama_komoditas ?></h4>
                                    <p class="mb-0"><?= $dist->jumlah ?> permintaan (<?= number_format(($dist->jumlah / $total_permintaan) * 100, 1); ?>%)</p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>