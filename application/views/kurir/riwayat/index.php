<div class="main-content">
    <div class="header">
        <h1>Riwayat Penugasan</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Daftar Riwayat Penugasan</h3>
        </div>
        <div class="card-body">
            <?php if (empty($riwayat)): ?>
                <div class="alert alert-info">
                    Tidak ada riwayat penugasan.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Komoditas</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Petani</th>
                                <th>Distributor</th>
                                <th>Tanggal Penugasan</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $item->nama_komoditas ?></td>
                                    <td><?= number_format($item->jumlah, 2) ?> <?= $item->satuan ?></td>
                                    <td>Rp <?= number_format($item->harga, 0, ',', '.') ?></td>
                                    <td><?= $item->nama_petani ?></td>
                                    <td><?= $item->nama_perusahaan ?></td>
                                    <td><?= date('d M Y H:i', strtotime($item->ditugaskan_pada)) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($item->diverifikasi_pada)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>