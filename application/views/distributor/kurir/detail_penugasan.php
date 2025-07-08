<div class="main-content">
    <div class="page-header">
        <h1>Detail Penugasan Kurir</h1>
        <a href="<?= site_url('distributor/penugasan') ?>" class="btn-action secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Penugasan
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Informasi Penugasan #PT-<?=$penugasan['id_penugasan']?>AC</h3>
            <div class="status-badge">
                <?php if($penugasan['status'] == 'pending'): ?>
                    <span class="badge badge-warning">Pending</span>
                <?php elseif($penugasan['status'] == 'approved'): ?>
                    <span class="badge badge-success">Disetujui</span>
                <?php else: ?>
                    <span class="badge badge-danger">Ditolak</span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-8">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="fas fa-calendar-day text-primary me-2"></i> Tanggal Penugasan</h5>
                                <p><?= date('d M Y H:i', strtotime($penugasan['ditugaskan_pada'])) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="fas fa-check-circle text-success me-2"></i> Tanggal Verifikasi</h5>
                                <p><?= $penugasan['diverifikasi_pada'] ? date('d M Y H:i', strtotime($penugasan['diverifikasi_pada'])) : '-' ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section mb-4">
                        <h4 class="section-title"><i class="fas fa-boxes me-2"></i> Detail Produk</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Komoditas</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $penugasan['nama_komoditas'] ?></td>
                                        <td><?= number_format($penugasan['jumlah'], 0) ?> kg</td>
                                        <td>Rp <?= number_format($penugasan['harga'], 0) ?></td>
                                        <td>Rp <?= number_format($penugasan['jumlah'] * $penugasan['harga'], 0) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <h4 class="section-title"><i class="fas fa-user me-2"></i> Informasi Kurir</h4>
                                <ul class="info-list">
                                    <li>
                                        <span class="info-label">Nama:</span>
                                        <span class="info-value"><?= $penugasan['nama_kurir'] ?></span>
                                    </li>
                                    <li>
                                        <span class="info-label">Email:</span>
                                        <span class="info-value"><?= $penugasan['email_kurir'] ?></span>
                                    </li>
                                    <li>
                                        <span class="info-label">No. Kendaraan:</span>
                                        <span class="info-value"><?= $penugasan['no_kendaraan'] ?></span>
                                    </li>
                                    <li>
                                        <span class="info-label">Area:</span>
                                        <span class="info-value"><?= $penugasan['cakupan_area'] ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-section">
                                <h4 class="section-title"><i class="fas fa-tractor me-2"></i> Informasi Petani</h4>
                                <ul class="info-list">
                                    <li>
                                        <span class="info-label">Nama:</span>
                                        <span class="info-value"><?= $penugasan['nama_petani'] ?></span>
                                    </li>
                                    <li>
                                        <span class="info-label">Email:</span>
                                        <span class="info-value"><?= $penugasan['email_petani'] ?></span>
                                    </li>
                                    <li>
                                        <span class="info-label">Telepon:</span>
                                        <span class="info-value"><?= $penugasan['telepon_petani'] ?></span>
                                    </li>
                                    <li>
                                        <span class="info-label">Alamat:</span>
                                        <span class="info-value"><?= $penugasan['alamat_petani'] ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4 class="section-title"><i class="fas fa-clipboard-list me-2"></i> Catatan Penugasan</h4>
                        <div class="notes-box">
                            <?= $penugasan['catatan'] ? nl2br($penugasan['catatan']) : '<p class="text-muted">Tidak ada catatan</p>' ?>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-md-4">
                    <div class="info-section mb-4">
                        <h4 class="section-title"><i class="fas fa-history me-2"></i> Timeline</h4>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6>Penugasan Dibuat</h6>
                                    <p class="text-muted small"><?= date('d M Y H:i', strtotime($penugasan['ditugaskan_pada'])) ?></p>
                                    <p class="small">Oleh: Distributor</p>
                                </div>
                            </div>
                            <?php if($penugasan['foto_bukti']): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6>Bukti Dikirim</h6>
                                    <p class="text-muted small"><?= date('d M Y H:i', strtotime($penugasan['waktu_bukti'])) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if($penugasan['diverifikasi_pada']): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6>Penugasan Diverifikasi</h6>
                                    <p class="text-muted small"><?= date('d M Y H:i', strtotime($penugasan['diverifikasi_pada'])) ?></p>
                                    <p class="small">Status: 
                                        <?php if($penugasan['status'] == 'approved'): ?>
                                            <span class="text-success">Disetujui</span>
                                        <?php else: ?>
                                            <span class="text-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="info-section mb-4">
                        <h4 class="section-title"><i class="fas fa-camera me-2"></i> Bukti Foto</h4>
                        <div class="text-center">
                            <?php if(!empty($penugasan['foto_bukti'])): ?>
                                <a href="<?= $penugasan['foto_bukti_url'] ?>" target="_blank">
                                    <img src="<?= $penugasan['foto_bukti_url'] ?>" class="img-fluid rounded mb-3" alt="Bukti Foto">
                                </a>
                                <div>
                                    <a href="<?= $penugasan['foto_bukti_url'] ?>" class="btn btn-sm btn-primary mr-2" target="_blank">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </a>
                                    <a href="<?= $penugasan['foto_bukti_url'] ?>" class="btn btn-sm btn-success" download>
                                        <i class="fas fa-download me-1"></i> Unduh
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="empty-state py-4">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada bukti foto</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4 class="section-title"><i class="fas fa-map-marker-alt me-2"></i> Lokasi</h4>
                        <div class="location-box">
                            <p><strong>Lokasi Pengambilan:</strong></p>
                            <p><?= $penugasan['alamat_petani'] ?></p>
                            
                            <p class="mt-3"><strong>Lokasi Pengiriman:</strong></p>
                            <p>Gudang Distributor, <?= $distributor['alamat'] ?></p>

                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="action-section mt-4 pt-4 border-top">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4>Aksi Penugasan</h4>
            <p class="text-muted">Kelola status penugasan</p>
        </div>
        
        <div class="d-flex">
            <?php if($penugasan['status'] == 'pending'): ?>
                <!-- Button trigger modal untuk Approve -->
                <button type="button" class="btn btn-success btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="fas fa-check me-1"></i> Setujui
                </button>
                
                <!-- Button trigger modal untuk Reject -->
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-1"></i> Tolak
                </button>
                
            <?php elseif($penugasan['status'] == 'approved'): ?>
                <button class="btn btn-outline-secondary mr-2" disabled>
                    <i class="fas fa-info-circle me-1"></i> Penugasan Selesai
                </button>
            <?php elseif($penugasan['status'] == 'rejected'):?>
                <button class="btn btn-outline-secondary mr-2" disabled>
                    <i class="fas fa-info-circle me-1"></i> Penawaran Ditolak
                </button>
            <?php else :?>
                <button class="btn btn-outline-secondary mr-2" disabled>
                    <i class="fas fa-info-circle me-1"></i>Belum Diverifikasi
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('distributor/penugasan/approve/'.$penugasan['id_penugasan']) ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Konfirmasi Persetujuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menyetujui penugasan ini?</p>
                    <div class="mb-3">
                        <label for="approveNotes" class="form-label">Tambahkan Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan" id="approveNotes" rows="3" placeholder="Masukkan catatan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui Penugasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('distributor/penugasan/reject/'.$penugasan['id_penugasan']) ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menolak penugasan ini?</p>
                    <div class="mb-3">
                        <label for="rejectNotes" class="form-label">Alasan Penolakan*</label>
                        <textarea class="form-control" name="catatan" id="rejectNotes" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Penugasan</button>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<style>
    /* Styling konsisten dengan tema */
    .info-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #eaeaea;
    }
    
    .section-title {
        font-size: 1.1rem;
        border-bottom: 2px solid #eaeaea;
        padding-bottom: 10px;
        margin-bottom: 15px;
        color: #2c3e50;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .info-list li {
        padding: 8px 0;
        border-bottom: 1px dashed #eaeaea;
    }
    
    .info-list li:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
        display: inline-block;
    }
    
    .info-value {
        color: #212529;
    }
    
    .notes-box {
        background: white;
        border-radius: 6px;
        padding: 15px;
        border: 1px solid #eaeaea;
        min-height: 100px;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 5px;
        height: calc(100% - 10px);
        width: 2px;
        background-color: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -25px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #3498db;
        border: 2px solid white;
        z-index: 2;
    }
    
    .timeline-content {
        background: white;
        border-radius: 6px;
        padding: 10px 15px;
        border: 1px solid #eaeaea;
    }
    
    .empty-state {
        text-align: center;
        color: #6c757d;
    }
    
    .location-box {
        background: white;
        border-radius: 6px;
        padding: 15px;
        border: 1px solid #eaeaea;
    }
    
    .action-section {
        padding-top: 20px;
    }
    
    @media (max-width: 768px) {
        .action-section .d-flex {
            flex-direction: column;
        }
        
        .action-section .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>