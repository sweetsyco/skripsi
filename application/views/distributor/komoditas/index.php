<div class="main-content">
<div class="page-header">
    <h1>Manajemen Komoditas</h1>
    <a href="<?= site_url('distributor/komoditas/tambah') ?>" class="btn btn-new">
        <i class="fas fa-plus"></i> Tambah Komoditas
    </a>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>Daftar Komoditas</h3>
    </div>
    <div class="card-body">
        <?php if (empty($komoditas)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-seedling fa-3x"></i>
                </div>
                <h2>Tidak Ada Data Komoditas</h2>
                <p>Silahkan tambahkan komoditas terlebih dahulu.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Komoditas</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($komoditas as $k): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($k->nama_komoditas) ?></td>
                            <td><?= htmlspecialchars($k->satuan) ?></td>
                            <td class="action-buttons">
                                <a href="<?= site_url('distributor/komoditas/edit/'.$k->id_komoditas) ?>" class="btn btn-sm btn-view">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= site_url('distributor/komoditas/hapus/'.$k->id_komoditas) ?>" class="btn btn-sm btn-keluar" onclick="return confirm('Apakah Anda yakin ingin menghapus komoditas ini?')">
                                    <i class="fas fa-trash"></i> Hapus
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