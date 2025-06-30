<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="header">
        <div>
            <h1>Buat Penawaran Baru</h1>
            <p class="text-muted">Isi form untuk membuat penawaran baru</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="h5">Penawaran untuk: <?= $permintaan['nama_komoditas'] ?></h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= site_url('petani/penawaran/create/'.$permintaan['id_permintaan']) ?>" id="penawaranForm">
                <div class="mb-3">
                    <label class="form-label">Komoditas</label>
                    <input type="text" class="form-control" value="<?= $permintaan['nama_komoditas'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Distributor</label>
                    <input type="text" class="form-control" value="<?= $permintaan['nama_distributor'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah yang Diminta (kg)</label>
                    <input type="text" class="form-control" value="<?= $permintaan['jumlah'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Maksimal yang Diterima (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" class="form-control" value="<?= number_format($permintaan['harga_maks'], 0, ',', '.') ?>" readonly>
                    </div>
                    <small class="text-muted">Harga maksimal yang bersedia dibayar distributor</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah yang Dapat Anda Berikan (kg)</label>
                    <input type="number" class="form-control" name="jumlah" min="0.1" step="0.1" max="<?= $permintaan['jumlah'] ?>" required>
                    <small class="text-muted">Maksimal: <?= $permintaan['jumlah'] ?> kg</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga per kg (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" name="harga" id="hargaInput" min="1" max="<?= $permintaan['harga_maks'] ?>" required>
                    </div>
                    <small class="text-muted">Maksimal: Rp <?= number_format($permintaan['harga_maks'], 0, ',', '.') ?> per kg</small>
                    <div class="invalid-feedback" id="hargaFeedback">
                        Harga tidak boleh melebihi Rp <?= number_format($permintaan['harga_maks'], 0, ',', '.') ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Buat Penawaran</button>
                <a href="<?= site_url('petani/penawaran') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
