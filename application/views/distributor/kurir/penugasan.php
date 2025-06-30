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
                    <form action="<?= site_url('penugasan/create') ?>" method="post">
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
                                                <?= number_format($p['jumlah'], 2) ?> kg
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
                                    <th>Komoditas</th>
                                    <th>Petani</th>
                                    <th>Kurir</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Waktu Penugasan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($penugasan)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">
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
                                            <td><?= $t['nama_komoditas'] ?></td>
                                            <td><?= $t['nama_petani'] ?></td>
                                            <td><?= $t['nama_kurir'] ?></td>
                                            <td><?= number_format($t['jumlah'], 2) ?> kg</td>
                                            <td>
                                                <span class="status-badge 
                                                    <?= $t['status'] == 'pending' ? 'badge-warning' : 
                                                       ($t['status'] == 'approved' ? 'badge-success' : 'badge-danger') ?>">
                                                    <i class="fas fa-circle me-1 small"></i> 
                                                    <?= ucfirst($t['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('d M Y H:i', strtotime($t['ditugaskan_pada'])) ?></td>
                                            <td>
                                                <?php if($t['status'] == 'pending'): ?>
                                                    <div class="d-flex gap-2">
                                                        <a href="<?= site_url('penugasan/update_status/'.$t['id_penugasan'].'/approved') ?>" 
                                                           class="btn btn-sm btn-success action-btn">
                                                            <i class="fas fa-check me-1"></i> Setujui
                                                        </a>
                                                        <a href="<?= site_url('penugasan/update_status/'.$t['id_penugasan'].'/rejected') ?>" 
                                                           class="btn btn-sm btn-danger action-btn">
                                                            <i class="fas fa-times me-1"></i> Tolak
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada aksi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
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
