<div class="main-content">
    <div class="header">
        <h1>Verifikasi Penugasan</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Daftar Penugasan</h3>
        </div>
        <div class="card-body">
            <?php if (empty($penugasan)) : ?>
                <div class="alert alert-info">Belum ada penugasan yang perlu diverifikasi.</div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Komoditas</th>
                                <th>Jumlah</th>
                                <th>Petani</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($penugasan as $p) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $p['nama_komoditas']; ?></td>
                                    <td><?= $p['jumlah']; ?> kg</td>
                                    <td><?= $p['nama_petani']; ?></td>
                                    <td>
                                        <?php if ($p['status'] == 'pending') : ?>
                                            <span class="badge badge-pending">Menunggu</span>
                                        <?php elseif ($p['status'] == 'pick up') : ?>
                                            <span class="badge badge-in-progress">Dalam Proses</span>
                                        <?php elseif ($p['status'] == 'approved') : ?>
                                            <span class="badge badge-completed">Selesai</span>
                                        <?php else :?>
                                            <span class="badge badge-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('kurir/verifikasi/detail/') . $p['id_penugasan']; ?>" class="btn btn-sm btn-view">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>