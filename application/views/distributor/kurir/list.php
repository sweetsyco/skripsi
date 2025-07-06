<div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Manajemen Kurir</h1>
            <div class="user-profile">
                <div class="user-avatar">A</div>
                <div>
                    <div class="fw-bold">Arif Rahman</div>
                    <div class="text-muted small"></div>
                </div>
            </div>
        </div>

        <!-- Konten Manajemen Kurir -->
        <div class="page-header">
            <h2>Daftar Kurir</h2>
            <button class="btn-action" data-bs-toggle="modal" data-bs-target="#tambahKurirModal">
                <i class="fas fa-plus"></i> Tambah Kurir
            </button>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <?php if (empty($kurir)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon text-muted">
                            <i class="fas fa-user-friends fa-3x"></i>
                        </div>
                        <h5 class="mt-3">Belum ada kurir</h5>
                        <p>Anda belum memiliki kurir yang terdaftar.</p>
                        <button class="btn-action mt-3" data-bs-toggle="modal" data-bs-target="#tambahKurirModal">
                            <i class="fas fa-plus"></i> Tambah Kurir Pertama
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Kendaraan</th>
                                    <th>Cakupan Area</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kurir as $k): ?>
                                    <tr>
                                        <td><?= $k->nama ?></td>
                                        <td><?= $k->email ?></td>
                                        <td><?= $k->no_kendaraan ?></td>
                                        <td><?= $k->cakupan_area ?></td>
                                        <td>
                                            <button class="action-btn btn-edit" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editKurirModal"
                                                    data-id="<?= $k->id_kurir ?>"
                                                    data-nama="<?= $k->nama ?>"
                                                    data-email="<?= $k->email ?>"
                                                    data-no_kendaraan="<?= $k->no_kendaraan ?>"
                                                    data-cakupan_area="<?= $k->cakupan_area ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <a href="#" class="action-btn btn-close ms-2">
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
        
        <!-- Modal Tambah Kurir -->
        <div class="modal fade" id="tambahKurirModal" tabindex="-1" aria-labelledby="tambahKurirModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKurirModalLabel">Tambah Kurir Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= site_url('distributor/kurir/proses_tambah_kurir') ?>" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Kendaraan</label>
                                <input type="text" name="no_kendaraan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cakupan Area</label>
                                <input type="text" name="cakupan_area" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Modal Edit Kurir -->
        <div class="modal fade" id="editKurirModal" tabindex="-1" aria-labelledby="editKurirModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKurirModalLabel">Edit Data Kurir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   <form id="formEditKurir" action="<?php echo site_url('distributor/kurir/update')?>" method="post">
                        <input type="hidden" name="id_kurir" id="editIdKurir">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="editNama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="editEmail" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Kendaraan</label>
                                <input type="text" name="no_kendaraan" id="editNoKendaraan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cakupan Area</label>
                                <input type="text" name="cakupan_area" id="editCakupanArea" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>