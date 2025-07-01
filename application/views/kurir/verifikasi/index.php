<div class="main-content">
        <div class="header">
            <h1>Verifikasi Pengiriman</h1>
            <div class="user-profile">
                <div class="user-avatar"><?= substr($kurir->nama, 0, 1) ?></div>
                <div>
                    <strong><?= $kurir->nama ?></strong>
                    <div class="text-muted" style="font-size: 0.9rem;">Kurir Distribusi</div>
                </div>
            </div>
        </div>

        <div class="verification-container">
            <div class="verification-header">
                <h2><i class="fas fa-check-circle me-2"></i>Verifikasi Pengiriman</h2>
                <p>Selesaikan penugasan dengan mengunggah bukti penerimaan</p>
            </div>
            
            <div class="verification-body">
                <div class="info-card">
                    <div class="info-item">
                        <span class="info-label">Komoditas</span>
                        <span class="info-value"><?= $tugas->nama_komoditas ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jumlah</span>
                        <span class="info-value"><?= $tugas->jumlah ?> kg</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Petani</span>
                        <span class="info-value"><?= $tugas->nama_petani ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Distributor</span>
                        <span class="info-value"><?= $tugas->nama_perusahaan ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Alamat Distributor</span>
                        <span class="info-value"><?= $tugas->alamat_distributor ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Penugasan</span>
                        <span class="info-value"><?= date('d M Y H:i', strtotime($tugas->ditugaskan_pada)) ?></span>
                    </div>
                </div>
                
                <form action="<?= base_url('kurir/proses_verifikasi/'.$tugas->id_penugasan) ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-3">Unggah Bukti Penerimaan</label>
                        <div class="verification-image-container">
                            <div class="mb-3">
                                <input type="file" class="form-control" id="foto_bukti" name="foto_bukti" accept="image/*" required>
                            </div>
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview" src="#" alt="Preview Bukti" class="preview-image">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-bold mb-3">Catatan Tambahan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Tambahkan catatan tentang pengiriman ini..."></textarea>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-verify">
                            <i class="fas fa-check-circle"></i> Verifikasi Pengiriman
                        </button>
                        <a href="<?= base_url('kurir') ?>" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>