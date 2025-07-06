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
            <span class="detail-label">Jumlah</span>
            <span class="detail-value"><?= $penugasan['jumlah']; ?> kg</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                <?php if ($penugasan['status'] == 'pending') : ?>
                    <span class="badge badge-pending">Menunggu</span>
                <?php elseif ($penugasan['status'] == 'pick up') : ?>
                    <span class="badge badge-in-progress">Dalam Proses</span>
                <?php elseif ($penugasan['status'] == 'completed') : ?>
                    <span class="badge badge-completed">Selesai</span>
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
        <a href="<?= base_url('kurir/verifikasi'); ?>" class="btn btn-action">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>