<div class="main-content">
    <!-- Alert Container -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert-container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="header">
        <h1>Dashboard Kurir</h1>
        <div class="user-profile">
            <div class="user-avatar"><?= substr($kurir->nama, 0, 1) ?></div>
            <div>
                <strong><?= $kurir->nama ?></strong>
                <div class="text-muted" style="font-size: 0.9rem;">Kurir Distribusi</div>
            </div>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $total_penugasan ?></h3>
                    <p>Total Penugasan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $dalam_proses ?></h3>
                    <p>Dalam Proses</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $selesai ?></h3>
                    <p>Selesai</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $menunggu ?></h3>
                    <p>Menunggu</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h3>Penugasan Aktif</h3>
                        <a href="<?= site_url('kurir/verifikasi/')?>" class="btn btn-sm btn-action">
                            <i class="fas fa-list"></i> Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($penugasan_aktif)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-truck-loading fa-3x mb-3" style="color: #5B913B;"></i>
                                <p>Tidak ada penugasan aktif</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($penugasan_aktif as $tugas): ?>
                                <div class="task-item">
                                    <div class="task-icon">
                                        <?php if ($tugas->status == 'pending'): ?>
                                            <i class="fas fa-clock"></i>
                                        <?php else: ?>
                                            <i class="fas fa-truck-moving"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="task-content">
                                        <div class="task-title">
                                            <?= ($tugas->status == 'pending' ? 'Pengambilan' : 'Pengiriman') ?>
                                            <?= $tugas->nama_komoditas ?> - <?= $tugas->nama_perusahaan ?>
                                        </div>
                                        <div class="task-details">
                                            <span><i class="fas fa-box"></i> <?= $tugas->nama_komoditas ?> - <?= $tugas->jumlah ?> kg</span>
                                            <span><i class="fas fa-map-marker-alt"></i> <?= $tugas->alamat_pengambilan ?></span>
                                            <span><i class="fas fa-user"></i> Petani: <?= $tugas->nama_petani ?></span>
                                        </div>
                                    </div>
                                    <div class="action-buttons">
                                        <?php if ($tugas->status == 'pending'): ?>
                                            <a href="<?= base_url('kurir/mulai_penugasan/'.$tugas->id_penugasan) ?>" class="action-btn btn-start">
                                                <i class="fas fa-play"></i> Mulai
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url('kurir/verifikasi/'.$tugas->id_penugasan) ?>" class="action-btn btn-verify">
                                                <i class="fas fa-check-circle"></i> Verifikasi
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Form verifikasi hanya ditampilkan jika ada tugas dalam proses pengiriman -->
                <?php 
                    $tugas_verifikasi = array_filter($penugasan_aktif, function($tugas) {
                        return $tugas->status == 'pick up';
                    });
                ?>
                
                <?php if (!empty($tugas_verifikasi)): ?>
                    <?php $tugas_verif = reset($tugas_verifikasi); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3>Verifikasi Pengiriman</h3>
                        </div>
                        <div class="card-body">
                            <div class="verification-form">
                                <h4>Verifikasi Pengiriman - <?= $tugas_verif->nama_perusahaan ?></h4>
                                <div class="form-group">
                                    <label class="form-label">Nama Komoditas</label>
                                    <input type="text" class="form-control" value="<?= $tugas_verif->nama_komoditas ?> - <?= $tugas_verif->jumlah ?> kg" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Distributor</label>
                                    <input type="text" class="form-control" value="<?= $tugas_verif->nama_perusahaan ?>" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Lokasi Pengiriman</label>
                                    <input type="text" class="form-control" value="<?= $tugas_verif->alamat_distributor ?>" readonly>
                                </div>
                                
                                <a href="<?= base_url('kurir/verifikasi/upload_bukti/'.$tugas_verif->id_penugasan) ?>" class="btn-action w-100 mt-3">
                                    <i class="fas fa-check-circle"></i> Upload Bukti
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-5">
                <!-- Detail penugasan -->
                <?php if (!empty($penugasan_aktif)): ?>
                    <?php $tugas_pertama = $penugasan_aktif[0]; ?>
                    <div class="card">
                        <div class="card-header">
                            <h3>Detail Penugasan</h3>
                        </div>
                        <div class="card-body">
                            <div class="detail-card">
                                <div class="detail-item">
                                    <span class="detail-label">Nama Petani</span>
                                    <span class="detail-value"><?= $tugas_pertama->nama_petani ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Alamat Pengambilan</span>
                                    <span class="detail-value"><?= $tugas_pertama->alamat_pengambilan ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Kontak Petani</span>
                                    <span class="detail-value"><?= $tugas_pertama->telepon_petani ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Komoditas</span>
                                    <span class="detail-value"><?= $tugas_pertama->nama_komoditas ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Jumlah</span>
                                    <span class="detail-value"><?= $tugas_pertama->jumlah ?> kg</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Status</span>
                                    <span class="detail-value">
                                        <?php if ($tugas_pertama->status == 'pending'): ?>
                                            <span class="badge badge-pending">Belum Diambil</span>
                                        <?php else: ?>
                                            <span class="badge badge-in-progress">Dalam Proses</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Distributor</span>
                                    <span class="detail-value"><?= $tugas_pertama->nama_perusahaan ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Tanggal Penugasan</span>
                                    <span class="detail-value"><?= date('d M Y H:i', strtotime($tugas_pertama->ditugaskan_pada)) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                    
                
                <!-- Aktivitas Terbaru -->
                <div class="card">
    <div class="card-header">
        <h5>Aktivitas Terkini</h5>
    </div>
    <div class="card-body">
        <?php if(empty($aktivitas)): ?>
            <p class="text-muted">Tidak ada aktivitas</p>
        <?php else: ?>
            <div class="list-group">
                <?php foreach($aktivitas as $akt): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?= $akt['jenis'] ?></h6>
                            <small><?= time_elapsed_string(strtotime($akt['waktu']), time()) ?> lalu</small>
                        </div>
                        <p class="mb-1"><?= $akt['pesan'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

