<div class="main-content">
        <div class="container py-4">
            <div class="page-header">
                <h1><i class="fas fa-tasks me-2"></i> Manajemen Penugasan Kurir</h1>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Buat Penugasan Baru</h4>
                </div>
                <div class="card-body">
                    <?php if(empty($penawaran)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> 
                            Tidak ada penawaran yang tersedia untuk ditugaskan. 
                            Semua penawaran yang diterima sudah ditugaskan ke kurir.
                        </div>
                    <?php else: ?>
                    <form action="<?= site_url('distributor/penugasan/create') ?>" method="post">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Pilih Penawaran</label>
                                    <select name="id_penawaran" class="form-control" required>
                                        <option value="">-- Pilih Penawaran --</option>
                                        <?php foreach($penawaran as $p): ?>
                                            <option value="<?= $p['id_penawaran'] ?>">
                                                <?= $p['nama_komoditas'] ?> - 
                                                <?= $p['nama_petani'] ?> - 
                                                <?= number_format($p['jumlah'], 0) ?> kg
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Pilih Kurir</label>
                                    <select name="id_kurir" class="form-control" required>
                                        <option value="">-- Pilih Kurir --</option>
                                        <?php foreach($kurir as $k): ?>
                                            <option value="<?= $k['id_kurir'] ?>">
                                                <?= $k['nama'] ?> (<?= $k['no_kendaraan'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-plus-circle me-1"></i> Tugaskan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                     <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Daftar Penugasan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tanggal</th>
                                    <th width="20%">Kurir</th>
                                    <th>Komoditas</th>
                                    <th>Petani</th>
                                    <th width="20%">Jumlah</th>
                                    <th>Catatan</th>
                                    <th>Bukti Foto</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($penugasan)): ?>
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="empty-state py-5">
                                    <div class="empty-state-icon bg-light rounded-circle d-flex mx-auto mb-4" style="width: 80px; height: 80px;">
                                        <i class="fas fa-truck text-info fs-1"></i>
                                    </div>
                                    <h5 class="mb-1">Belum ada penugasan</h5>
                                    <p class="text-muted">Mulai dengan membuat penugasan baru</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($penugasan as $t): ?>
                            <tr>
                                <td><?= $t['id_penugasan'] ?></td>
                                <td><?= date('d M Y H:i', strtotime($t['ditugaskan_pada'])) ?></td>
                                <td>
                                    <?= $t['nama_kurir'] ?><br>
                                    <small class="text-muted"><?= $t['no_kendaraan'] ?></small>
                                </td>
                                <td><?= $t['nama_komoditas'] ?></td>
                                <td><?= $t['nama_petani'] ?></td>
                                <td><?= number_format($t['jumlah'], 0) ?> kg</td>
                                <td><?= $t['catatan'] ?: '-' ?></td>
                                <td>
                                    <?php if ($t['foto_bukti']): ?>
                                        <a href="<?= site_url('distributor/penugasan/view_bukti/'.$t['id_penugasan']) ?>" 
                                        class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> Lihat Bukti
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge 
                                        <?= $t['status'] == 'pending' ? 'bg-warning' : 
                                           ($t['status'] == 'approved' ? 'bg-success' : 'bg-danger') ?>">
                                        <i class="fas fa-circle me-1 small"></i> 
                                        <?= ucfirst($t['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('distributor/penugasan/detail/'.$t['id_penugasan']) ?>" 
                                   class="btn btn-sm btn-info mb-2 w-100">
                                    <i class="fas fa-info-circle me-1"></i> Detail
                                    </a>
                                            <?php if($t['status'] == 'approved' && $t['foto_bukti']): ?>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    <i class="fas fa-info-circle me-1"></i> Selesai
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= count($penugasan) ?> dari <?= count($penugasan) ?> penugasan
                        </div>
                        <!-- Pagination bisa ditambahkan jika diperlukan -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    /* Tambahan styling untuk tombol */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .action-btn {
        min-width: 60px;
        white-space: nowrap;
    }
    
    /* Agar tombol responsif di kolom aksi */
    td {
        vertical-align: middle !important;
    }
    
    .flex-grow-1 {
        flex-grow: 1;
    }
    
    .gap-1 {
        gap: 0.25rem;
    }
    
    .w-100 {
        width: 100%;
    }
    
    .mb-2 {
        margin-bottom: 0.5rem;
    }
</style>
