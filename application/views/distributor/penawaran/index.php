 <div class="main-content">
        <div class="container py-4">
            <div class="header">
                <h1><i class="fas fa-handshake me-2"></i> Penawaran dari Petani</h1>
            </div>
            
           <!-- Statistik -->
<div class="stats-container">
    <!-- Hapus pemanggilan model langsung -->
    <div class="stat-card">
        <div class="stat-icon" style="background-color: rgba(255, 152, 0, 0.1); color: var(--secondary);">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-content">
            <h3><?= $statistik['total'] ?></h3>
            <p>Total Penawaran</p>
        </div>
    </div>
    <!-- ... (stat-card lainnya menggunakan $statistik) ... -->
</div>

<!-- Tabel Penawaran -->
<tbody>
    <?php 
    $counter = 1;
    foreach ($penawaran as $p): 
        $nonaktif = ($p['status'] != 'pending');
    ?>
    <!-- ... (baris tabel) ... -->
    <?php endforeach; ?>
</tbody>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $statistik['accepted'] ?></h3>
                        <p>Penawaran Diterima</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: var(--warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $statistik['pending'] ?></h3>
                        <p>Penawaran Menunggu</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.1); color: var(--danger);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $statistik['rejected'] ?></h3>
                        <p>Penawaran Ditolak</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Filter -->
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Daftar Penawaran</h3>
                    <form method="get" class="d-flex gap-2">
                        <div class="input-group" style="max-width: 300px;">
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Cari penawaran..." 
                                name="pencarian"
                                value="<?= $this->input->get('pencarian') ?>"
                            >
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <form method="get">
                        <div class="filter-container">
                            <select class="form-select filter-select" name="komoditas">
    <option value="all" <?= $this->input->get('komoditas') == 'all' ? 'selected' : '' ?>>Semua Komoditas</option>
    <?php foreach($komoditas_list as $kom): ?>
        <option value="<?= $kom['nama_komoditas'] ?>" 
            <?= $this->input->get('komoditas') == $kom['nama_komoditas'] ? 'selected' : '' ?>>
            <?= $kom['nama_komoditas'] ?>
        </option>
    <?php endforeach; ?>
</select>
                            <br>
                            <select class="form-select filter-select" name="komoditas">
                                <option value="all" <?= $this->input->get('komoditas') == 'all' ? 'selected' : '' ?>>Semua Komoditas</option>
                                <option value="Padi" <?= $this->input->get('komoditas') == 'Padi' ? 'selected' : '' ?>>Padi</option>
                                <option value="Jagung" <?= $this->input->get('komoditas') == 'Jagung' ? 'selected' : '' ?>>Jagung</option>
                                <option value="Kedelai" <?= $this->input->get('komoditas') == 'Kedelai' ? 'selected' : '' ?>>Kedelai</option>
                            </select>
                            <br>
                            <select class="form-select filter-select" name="urutan">
                                <option value="terbaru" <?= $this->input->get('urutan') == 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                                <option value="terlama" <?= $this->input->get('urutan') == 'terlama' ? 'selected' : '' ?>>Terlama</option>
                            </select>
                            <br>
                            <button type="submit" class="btn btn-primary">Filter</button>
        
                        </div>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Komoditas</th>
                                    <th>Petani</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                            $counter = 1;
                            foreach ($penawaran as $p): 
                                $nonaktif = ($p['status'] != 'pending');
                            ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= htmlspecialchars($p['nama_komoditas'] ?? '') ?></td>
                                <td><?= htmlspecialchars($p['nama_petani'] ?? '') ?></td>
                                <td><?= number_format($p['jumlah'] ?? 0, 0) ?> kg</td>
                                <td>Rp <?= number_format($p['harga_per_kg'] ?? 0) ?>/kg</td>
                                <td>Rp <?= number_format($p['total_harga'] ?? 0) ?></td>
                                <td><?= date('d M Y', strtotime($p['dibuat_pada'] ?? 'now')) ?></td>
                                <td>
                                    <?php if(($p['status'] ?? '') == 'pending'): ?>
                                        <span class="badge badge-pending"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                    <?php elseif(($p['status'] ?? '') == 'accepted'): ?>
                                        <span class="badge badge-accepted"><i class="fas fa-check-circle me-1"></i> Diterima</span>
                                    <?php else: ?>
                                        <span class="badge badge-rejected"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                            <div class="d-flex gap-2">
                                <button 
                                    class="btn-accept action-btn btn btn-success btn-sm <?= $nonaktif ? 'disabled' : '' ?>" 
                                    <?= $nonaktif ? 'disabled' : '' ?>
                                    data-id="<?= $p['id_penawaran'] ?? '' ?>"
                                >
                                    <i class="fas fa-check"></i> Terima
                                </button>
                                <button 
                                    class="btn-reject action-btn btn btn-danger btn-sm <?= $nonaktif ? 'disabled' : '' ?>" 
                                    <?= $nonaktif ? 'disabled' : '' ?>
                                    data-id="<?= $p['id_penawaran'] ?? '' ?>"
                                >
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= count($penawaran) ?> dari <?= $statistik['total'] ?> penawaran
                        </div>
                        <!-- Pagination bisa diimplementasikan sesuai kebutuhan -->
                    </div>
                </div>
            </div>
        </div>
    </div>