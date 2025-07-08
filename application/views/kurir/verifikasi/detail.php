<div class="main-content">
    <div class="header">
        <h1>Detail Penugasan</h1>
    </div>

    <div class="detail-card">
        <div class="detail-item">
            <span class="detail-label">ID Penugasan</span>
            <span class="detail-value">#<?= $penugasan['id_penugasan']; ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Komoditas</span>
            <span class="detail-value"><?= $penugasan['nama_komoditas']; ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Harga Yang Ditawarkan</span>
            <span class="detail-value">Rp<?= number_format($penugasan['harga'], 0); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Jumlah</span>
            <span class="detail-value"><?= number_format($penugasan['jumlah'], 0); ?> kg</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Total</span>
            <span class="detail-value">Rp<?= number_format($penugasan['jumlah']*$penugasan['harga'], 0); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                <?php if ($penugasan['status'] == 'pending') : ?>
                    <span class="badge badge-pending">Menunggu</span>
                <?php elseif ($penugasan['status'] == 'pick up') : ?>
                    <span class="badge badge-in-progress">Dalam Proses</span>
                <?php elseif ($penugasan['status'] == 'approved') : ?>
                    <span class="badge badge-completed">Selesai</span>
                <?php else :?>
                    <span class="badge badge-danger">Ditolak</span>
                <?php endif; ?>
            </span>
        </div>
        <?php if ($penugasan['foto_bukti']) : ?>
            <div class="detail-item">
                <span class="detail-label">Bukti Pengiriman</span>
                <span class="detail-value">
                    <img src="<?= base_url('uploads/bukti/') . $penugasan['foto_bukti']; ?>" alt="Bukti Pengiriman" width="200">
                </span>
            </div>
        <?php endif; ?>
        <?php if ($penugasan['catatan']) : ?>
            <div class="detail-item">
                <span class="detail-label">Catatan</span>
                <span class="detail-value"><?= $penugasan['catatan']; ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-4">
        <?php if ($penugasan['status'] == 'pick up') : ?>
        <a href="<?= base_url('kurir/verifikasi/upload_bukti/') . $penugasan['id_penugasan']; ?>" class="btn btn-upload">
            <i class="fas fa-upload"></i> Upload Bukti
        </a>
        <?php endif;?>
        <br>
        <a href="<?= base_url('kurir/verifikasi'); ?>" class="btn btn-action">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>