<div class="main-content" style="margin-left: 250px; padding: 20px;">
        <div class="header">
            <div>
                <h1>Pilih Permintaan</h1>
                <p class="text-muted">Pilih permintaan distributor yang ingin Anda ajukan penawaran</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="h5">Daftar Permintaan Tersedia</h3>
            </div>
            <div class="card-body">
                <?php if(empty($permintaan)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        Saat ini tidak ada permintaan yang tersedia.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Komoditas</th>
                                    <th>Distributor</th>
                                    <th>Jumlah Dibutuhkan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($permintaan as $p): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-seedling me-2 text-success"></i>
                                            <span><?= $p['nama_komoditas'] ?></span>
                                        </div>
                                    </td>
                                    <td><?= $p['nama_distributor'] ?></td>
                                    <td><?= $p['jumlah'] ?> kg</td>
                                    <td>
                                        <a href="<?= site_url('petani/penawaran/create/'.$p['id_permintaan']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i> Buat Penawaran
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