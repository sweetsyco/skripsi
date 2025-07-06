<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="header">
        <div>
            <h1>Penugasan Kurir</h1>
            <p class="text-muted">Daftar penugasan kurir untuk pengiriman hasil tani Anda</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if(empty($penugasan)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> 
                    Belum ada penugasan kurir untuk Anda.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Komoditas</th>
                                <th>Distributor</th>
                                <th>Kurir</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal Penugasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penugasan as $t): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-seedling me-2 text-success"></i>
                                        <span><?= $t['nama_komoditas'] ?></span>
                                    </div>
                                </td>
                                <td><?= $t['nama_perusahaan'] ?></td>
                                <td><?= $t['nama_kurir'] ?></td>
                                <td><?= $t['jumlah'] ?> kg</td>
                                <td>
                                    <?php 
                                    $status = $t['status'];
                                    $badge_class = '';
                                    if ($status == 'pending') {
                                        $badge_class = 'bg-warning';
                                    } elseif ($status == 'approved') {
                                        $badge_class = 'bg-success';
                                    } elseif ($status == 'rejected') {
                                        $badge_class = 'bg-danger';
                                    } elseif ($status == 'pick up') {
                                        $badge_class = 'bg-warning';
                                    }
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= ucfirst($status) ?></span>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($t['ditugaskan_pada'])) ?></td>
                                <td>
                                    <a href="<?= site_url('petani/kurir/detail/'.$t['id_penugasan']) ?>" class="btn btn-sm btn-info">
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
<div class="modal fade" id="detailPenugasanModal" tabindex="-1" aria-labelledby="detailPenugasanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPenugasanModalLabel">Detail Penugasan Kurir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-content">
                <!-- Data akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>