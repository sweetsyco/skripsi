<div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Dashboard Petani</h1>
            <div class="user-profile">
                <div class="user-avatar">R</div>
                <div>
                    <div class="fw-bold">Ripal</div>
                    <div class="text-muted small">Petani - Jalan BSD</div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['permintaan_aktif'] ?></h3>
                    <p>Permintaan Aktif</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['penawaran_saya'] ?></h3>
                    <p>Penawaran Saya</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['penugasan_kurir'] ?></h3>
                    <p>Penugasan Kurir</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['jenis_komoditas'] ?></h3>
                    <p>Jenis Komoditas</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4">Aksi Cepat</h2>
        </div>
        <div class="actions-container">
            <a href="<?php echo site_url('petani/penawaran/buat')?>" class="action-card">
                <i class="fas fa-plus-circle"></i>
                <h4>Buat Penawaran</h4>
            </a>
            <a href="<?php echo site_url('petani/kurir')?>" class="action-card">
                <i class="fas fa-truck"></i>
                <h4>Verifikasi Pengiriman</h4>
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-7">
                <!-- Daftar Permintaan -->
                <div class="card">
                    <div class="card-header">
                        <h3>Permintaan Terbaru</h3>
                        <a href="<?= site_url('/petani/penawaran')?>" class="small">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Komoditas</th>
                                        <th>Distributor</th>
                                        <th>Jumlah</th>
                                        <th>Harga Maks</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    <?php if(!empty($permintaan_terbaru)) : ?>
                                        <?php foreach($permintaan_terbaru as $p): ?>
                                        <tr>
                                            <td><?= $p['nama_komoditas'] ?></td>
                                            <td><?= $p['nama_perusahaan'] ?></td>
                                            <td><?= $p['jumlah'] ?> kg</td>
                                            <td>Rp <?= number_format($p['harga_maks'], 0, ',', '.') ?></td>
                                            <td>
                                                <a href="<?= site_url('petani/penawaran/create/'.$p['id_permintaan']) ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus me-1"></i> Penawaran
                                        </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada permintaan terbaru</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <!-- Aktivitas Terbaru -->
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
                                    <div class="activity-title"><?= $a['pesan'] ?></div>
                                    <div class="activity-time"><?= date('d M Y, H:i', strtotime($a['waktu'])) ?></div>
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
                
                <!-- Buttons Section -->
                <div class="d-grid gap-3 mt-4">
                    <a href="" class="btn btn-action">
                        <i class="fas fa-book"></i> Panduan Petani
                    </a>
                    <a href="http://wa.me/+6282268382866" class="btn btn-action secondary">
                        <i class="fas fa-headset"></i> Dukungan Teknis
                    </a>
                </div>
            </div>
        </div>
    </div>