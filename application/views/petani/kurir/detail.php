<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="header">
        <div>
            <h1>Detail Penugasan Kurir</h1>
            <p class="text-muted">Detail lengkap penugasan kurir untuk pengiriman hasil tani Anda</p>
        </div>
        <a href="<?= site_url('petani/kurir') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if ($penugasan): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h4 class="mb-3">Informasi Pengiriman</h4>
                            <div class="mb-3">
                                <label class="form-label text-muted">Komoditas</label>
                                <p class="form-control-static"><?= $penugasan['nama_komoditas'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Jumlah</label>
                                <p class="form-control-static"><?= number_format($penugasan['jumlah_penawaran'], 2) ?> <?= $penugasan['satuan'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Harga</label>
                                <p class="form-control-static">Rp <?= number_format($penugasan['harga_penawaran'], 0, ',', '.') ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Distributor</label>
                                <p class="form-control-static"><?= $penugasan['nama_perusahaan'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h4 class="mb-3">Status Penugasan</h4>
                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <?php
                                $status = $penugasan['status'];
                                $badge_class = '';
                                if ($status == 'pending') {
                                    $badge_class = 'bg-warning';
                                } elseif ($status == 'approved') {
                                    $badge_class = 'bg-success';
                                } elseif ($status == 'rejected') {
                                    $badge_class = 'bg-danger';
                                } elseif ($status == 'pick up') {
                                    $badge_class = 'bg-info';
                                }
                                ?>
                                <p><span class="badge <?= $badge_class ?>"><?= ucfirst($status) ?></span></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Tanggal Penugasan</label>
                                <p class="form-control-static"><?= date('d M Y H:i', strtotime($penugasan['ditugaskan_pada'])) ?></p>
                            </div>
                            <?php if ($penugasan['waktu_bukti']): ?>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Pengambilan Bukti</label>
                                    <p class="form-control-static"><?= date('d M Y H:i', strtotime($penugasan['waktu_bukti'])) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($penugasan['diverifikasi_pada']): ?>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Diverifikasi Pada</label>
                                    <p class="form-control-static"><?= date('d M Y H:i', strtotime($penugasan['diverifikasi_pada'])) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h4 class="mb-3">Informasi Kurir</h4>
                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Kurir</label>
                                <p class="form-control-static"><?= $penugasan['nama_kurir'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">No. Kendaraan</label>
                                <p class="form-control-static"><?= $penugasan['no_kendaraan'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Cakupan Area</label>
                                <p class="form-control-static"><?= $penugasan['cakupan_area'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h4 class="mb-3">Informasi Distributor</h4>
                            <div class="mb-3">
                                <label class="form-label text-muted">Perusahaan</label>
                                <p class="form-control-static"><?= $penugasan['nama_perusahaan'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Alamat</label>
                                <p class="form-control-static"><?= $penugasan['alamat_distributor'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Telepon</label>
                                <p class="form-control-static"><?= $penugasan['telp_distributor'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($penugasan['catatan']): ?>
                    <div class="mt-4">
                        <h4>Catatan</h4>
                        <div class="border rounded p-3 bg-light">
                            <?= nl2br($penugasan['catatan']) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($penugasan['foto_bukti']): ?>
                    <div class="mt-4">
                        <h4>Foto Bukti Pengiriman</h4>
                        <img src="<?= base_url('uploads/bukti/'.$penugasan['foto_bukti']) ?>" 
                             alt="Foto Bukti" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 300px;">
                    </div>
                <?php endif; ?>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="<?= site_url('petani/kurir') ?>" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">Data penugasan tidak ditemukan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .form-label.text-muted {
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    .form-control-static {
        font-weight: 500;
        color: #343a40;
        font-size: 16px;
        padding: 0.375rem 0;
    }
    .card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
    }
    .card-body {
        padding: 2rem;
    }
    h4 {
        color: #28a745;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(40, 167, 69, 0.2);
        margin-bottom: 1.5rem;
    }
</style>