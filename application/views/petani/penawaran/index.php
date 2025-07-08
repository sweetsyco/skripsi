<div class="main-content">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Penawaran Saya</h1>
                <p class="text-muted">Kelola penawaran yang Anda buat untuk permintaan distributor</p>
            </div>
            <div class="user-profile">
                <div class="user-avatar">R</div>
                <div>
                    <div class="fw-bold"><?= $petani['nama'] ?? 'Petani' ?></div>
                    <div class="text-muted small">Petani - <?= $petani['alamat'] ?? 'Alamat' ?></div>
                </div>
            </div>
        </div>

        <!-- Buat Penawaran Baru -->
        <div class="create-penawaran-container">
            <div class="create-content">
                <h3><i class="fas fa-rocket"></i> Buat Penawaran Baru</h3>
                <p>Manfaatkan platform AgriConnect untuk menjangkau lebih banyak distributor. Buat penawaran menarik untuk produk pertanian Anda dan tingkatkan potensi penjualan.</p>
                
                <a href="http://localhost/skripsi/petani/penawaran/buat" class="btn btn-create">
                    <i class="fas fa-file-contract me-2"></i> Buat Penawaran Sekarang
                </a>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i> Jangkau distributor terverifikasi
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i> Proses transaksi aman
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i> Dukungan logistik terintegrasi
                    </div>
                </div>
            </div>
            <div class="create-image">
                <div class="create-image-inner">
                    <i class="fas fa-chart-line"></i>
                    <p>Tingkatkan Penjualan Produk Anda</p>
                </div>
            </div>
        </div>

        <!-- Daftar Penawaran -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="h5 mb-1">Daftar Penawaran Saya</h3>
                    <p class="text-muted mb-0">Total <?= count($penawaran) ?> penawaran yang telah dibuat</p>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Komoditas</th>
                                <th>Distributor</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Sisa Permintaan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penawaran as $p): ?>
                            <tr>
                                <td data-id="<?= $p['id_penawaran'] ?>">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-seedling me-2 text-success"></i>
                                        <span><?= $p['nama_komoditas'] ?></span>
                                    </div>
                                </td>
                                <td><?= $p['nama_perusahaan'] ?></td>
                                <td><?= $p['jumlah'] ?> kg</td>
                                <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format(($p['jumlah'] * $p['harga']) ?? 0) ?></td>
                                <td>
                                    <?= number_format($p['sisa_permintaan'] ?? 0, 0) ?> kg
                                    <?php if(isset($p['jumlah_permintaan'])): ?>
                                        <small class="text-muted d-block">
                                            dari <?= number_format($p['jumlah_permintaan'], 0) ?> kg
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($p['status'] == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($p['status'] == 'accepted'): ?>
                                        <span class="badge bg-success">Diterima</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M Y', strtotime($p['dibuat_pada'])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                    <button class="btn-action btn-action-view btn-detail" data-id="<?= $p['id_penawaran'] ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <?php if ($p['status'] == 'pending'): ?>
                                        <button class="btn-action btn-action-edit btn-edit" 
                                            data-id="<?= $p['id_penawaran'] ?>"
                                            data-komoditas="<?= htmlspecialchars($p['nama_komoditas']) ?>"
                                            data-distributor="<?= htmlspecialchars($p['nama_perusahaan']) ?>"
                                            data-jumlah="<?= $p['jumlah'] ?>"
                                            data-harga="<?= $p['harga'] ?>"
                                            data-harga_max="<?= $p['harga_maks'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-action-delete btn-delete" data-id="<?= $p['id_penawaran'] ?>" data-komoditas="<?= htmlspecialchars($p['nama_komoditas']) ?>" data-distributor="<?= htmlspecialchars($p['nama_perusahaan']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php elseif ($p['status'] == 'accepted'): ?>
                                        
                                        <a href="<?= site_url('petani/penawaran/buat_surat_perjanjian/'.$p['id_penawaran']) ?>" 
                                        class="btn btn-sm btn-success">
                                            <i class="fas fa-file-download"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="action-btn btn btn-sm btn-danger btn-delete" data-id="<?= $p['id_penawaran'] ?>" data-komoditas="<?= htmlspecialchars($p['nama_komoditas']) ?>" data-distributor="<?= htmlspecialchars($p['nama_perusahaan']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if(!empty($pagination)): ?>
                <nav class="mt-4">
                    <?= $pagination ?>
                </nav>
            <?php endif; ?>
            </div>
        </div>
        
        <!-- Statistik -->
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary bg-opacity-10 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary p-3 rounded-circle me-3">
                                <i class="fas fa-handshake text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Total Penawaran</h5>
                                <p class="card-text fs-3 fw-bold"><?= count($penawaran) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success bg-opacity-10 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success p-3 rounded-circle me-3">
                                <i class="fas fa-check-circle text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Diterima</h5>
                                <p class="card-text fs-3 fw-bold"><?= $count_diterima ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning bg-opacity-10 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning p-3 rounded-circle me-3">
                                <i class="fas fa-clock text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Pending</h5>
                                <p class="card-text fs-3 fw-bold"><?= $count_pending ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Modal Detail Penawaran -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penawaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h6 class="fw-bold mb-3">Informasi Penawaran</h6>
                            <div class="detail-item">
                                <span>Komoditas:</span>
                                <span id="detail-komoditas"></span>
                            </div>
                            <div class="detail-item">
                                <span>Distributor:</span>
                                <span id="detail-distributor"></span>
                            </div>
                            <div class="detail-item">
                                <span>Jumlah:</span>
                                <span id="detail-jumlah"></span>
                            </div>
                            <div class="detail-item">
                                <span>Harga:</span>
                                <span id="detail-harga"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h6 class="fw-bold mb-3">Status & Tanggal</h6>
                            <div class="detail-item">
                                <span>Status:</span>
                                <span id="detail-status" class="badge"></span>
                            </div>
                            <div class="detail-item">
                                <span>Tanggal Dibuat:</span>
                                <span id="detail-tanggal"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Edit Penawaran -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penawaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" action="<?= site_url('petani/penawaran/update') ?>">
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id_penawaran">
                        <div class="mb-3">
                            <label class="form-label">Komoditas</label>
                            <input type="text" class="form-control" id="edit-komoditas" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Distributor</label>
                            <input type="text" class="form-control" id="edit-distributor" readonly>
                        </div><div class="mb-3">
                            <label class="form-label">Harga Maks</label>
                            <input type="text" class="form-control" id="edit-hargamaks" readonly>
                        </div>
                        <small class="text-muted">Harga maksimal yang bersedia dibayar distributor</small>
                        <div class="mb-3">
                            <label class="form-label">Jumlah (kg)</label>
                            <input type="number" class="form-control" id="edit-jumlah" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga per kg (Rp)</label>
                            <input type="number" class="form-control" id="edit-harga" name="harga" required>
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

    <!-- Modal Hapus Penawaran -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Penawaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus penawaran ini?</p>
                    <p><strong id="delete-komoditas"></strong> untuk <strong id="delete-distributor"></strong></p>
                    <p class="text-danger">Penawaran yang sudah dihapus tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirm-delete" class="btn btn-danger">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
    <style>
.action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
            align-items: center;
        }

        /* Base style untuk semua tombol aksi */
        .btn-action {
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.2s;
            text-decoration: none;
            min-width: 36px;
            height: 36px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.1);
            cursor: pointer;
        }

        /* Tombol View */
        .btn-action-view {
            background-color: rgba(23, 162, 184, 0.15);
            color: #17a2b8;
            border-color: rgba(23, 162, 184, 0.3);
        }

        .btn-action-view:hover {
            background-color: rgba(23, 162, 184, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* Tombol Download */
        .btn-action-download {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border-color: rgba(40, 167, 69, 0.3);
        }

        .btn-action-download:hover {
            background-color: rgba(40, 167, 69, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* Tombol Delete */
        .btn-action-delete {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border-color: rgba(220, 53, 69, 0.3);
        }

        .btn-action-delete:hover {
            background-color: rgba(220, 53, 69, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .btn-action-edit {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border-color: rgba(255, 193, 7, 0.3);
        }

        .btn-action-edit:hover {
            background-color: rgba(255, 193, 7, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* Penyesuaian ikon */
        .btn-action i {
            font-size: 16px;
        }

        /* Untuk tombol yang hanya berisi ikon */
        .btn-action.icon-only i {
            margin: 0;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .action-buttons {
                gap: 5px;
            }
            
            .btn-action {
                padding: 6px 10px;
                font-size: 13px;
                min-width: 32px;
                height: 32px;
            }
            
            .btn-action i {
                font-size: 14px;
            }
        }
        
        /* Animasi untuk efek lebih halus */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .btn-action {
            animation: fadeIn 0.3s ease-out;
        }
</style>