<div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Dashboard Distributor</h1>
            <div class="user-profile">
                <div class="user-avatar"><?= substr($nama, 0, 1) ?></div>
                <div>
                    <div class="fw-bold"><?= $nama ?></div>
                    <div class="text-muted small"><?= $nama_distributor?></div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <h3><?= count($permintaan_aktif) ?></h3>
                    <p>Permintaan Aktif</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-comments-dollar"></i>
                </div>
                <div class="stat-content">
                    <h3><?= count($penawaran_baru) ?></h3>
                    <p>Penawaran Baru</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3><?= count($penugasan_kurir) ?></h3>
                    <p>Penugasan Kurir</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="stat-content">
                    <h3><?= count($butuh_verifikasi) ?></h3>
                    <p>Butuh Verifikasi</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4">Aksi Cepat</h2>
        </div>
        <div class="actions-container">
            <a href="<?= site_url('distributor/permintaan/create') ?>" class="action-card">
                <i class="fas fa-plus-circle"></i>
                <h4>Buat Permintaan</h4>
            </a>
            <a href="<?= site_url('distributor/penawaran') ?>" class="action-card">
                <i class="fas fa-handshake"></i>
                <h4>Kelola Penawaran</h4>
            </a>
            <a href="<?= site_url('distributor/kurir/tambah') ?>" class="action-card">
                <i class="fas fa-user-plus"></i>
                <h4>Tambah Kurir</h4>
            </a>
            <a href="<?= site_url('distributor/laporan') ?>" class="action-card">
                <i class="fas fa-file-export"></i>
                <h4>Buat Laporan</h4>
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-7">
                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h3>Aktivitas Terbaru</h3>
                    </div>
                    <div class="card-body">
						 <?php if(!empty($aktivitas_terbaru)) : ?>
                            <?php foreach($aktivitas_terbaru as $a): ?>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title"><?= $a['message'] ?></div>
                                    <div class="activity-time"><?= date('d M Y, H:i', strtotime($a['time'])) ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p>Tidak ada aktivitas terbaru</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <!-- Progress Permintaan -->
                <div class="card">
                    <div class="card-header">
                        <h3>Progress Permintaan</h3>
                    </div>
                    <div class="card-body">
						<?php foreach ($permintaan as $index => $p): ?>
							<div class="progress-container">
								<div class="progress-label">
									<span><?= $p->nama_komoditas ?> - <?= number_format($p->jumlah, 2) . ' ' . $p->satuan ?></span>
									<span><?= $p->progres ?>%</span>
								</div>
								<div class="progress">
									<div class="progress-bar bg-success" role="progressbar" style="width: <?= $p->progres ?>%" aria-valuenow="<?= $p->progres ?>" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						<?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Buttons Section -->
                <div class="d-grid gap-3 mt-4">
                    <button class="btn btn-action">
                        <i class="fas fa-download"></i> Unduh Laporan Bulanan
                    </button>
                    <button class="btn btn-action secondary">
                        <i class="fas fa-question-circle"></i> Pusat Bantuan
                    </button>
                </div>
            </div>
        </div>
    </div>
