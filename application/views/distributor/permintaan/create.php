<div class="main-content">
<div class="container py-4">
                <div class="page-header">
                    <h2><i class="fas fa-plus-circle me-2"></i> Buat Permintaan Baru</h2>
                </div>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mb-4">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i> Mohon perbaiki kesalahan berikut
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Form Permintaan Komoditas</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('distributor/permintaan/store') ?>" method="POST">
                            <div class="mb-4">
                                <label for="id_komoditas" class="form-label required">Komoditas</label>
                                <select class="form-select <?= form_error('id_komoditas') ? 'is-invalid' : '' ?>" id="id_komoditas" name="id_komoditas" required>
                                    <option value="">Pilih Komoditas</option>
                                    <?php foreach ($komoditas as $k): ?>
                                        <option value="<?= $k->id_komoditas ?>" <?= set_select('id_komoditas', $k->id_komoditas) ?>>
                                            <?= $k->nama_komoditas ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_komoditas', '<div class="invalid-feedback">', '</div>') ?>
                                <div class="form-text">Pilih komoditas yang ingin Anda minta</div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jumlah" class="form-label required">Jumlah</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="1" class="form-control <?= form_error('jumlah') ? 'is-invalid' : '' ?>" id="jumlah" name="jumlah" placeholder="Masukkan jumlah" value="<?= set_value('jumlah') ?>" required>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                    <?= form_error('jumlah', '<div class="invalid-feedback">', '</div>') ?>
                                    <div class="form-text">Jumlah komoditas yang dibutuhkan</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="harga_maks" class="form-label required">Harga Maksimum</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="1" class="form-control <?= form_error('harga_maks') ? 'is-invalid' : '' ?>" id="harga_maks" name="harga_maks" placeholder="Masukkan harga maksimum" value="<?= set_value('harga_maks') ?>" required>
                                        <span class="input-group-text">/kg</span>
                                    </div>
                                    <?= form_error('harga_maks', '<div class="invalid-feedback">', '</div>') ?>
                                    <div class="form-text">Harga maksimal yang bersedia Anda bayar</div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Detail Komoditas</label>
                                <div class="card border p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <span class="text-muted">Jenis Komoditas:</span>
                                                <span id="detail-nama">-</span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="text-muted">Satuan:</span>
                                                <span id="detail-satuan">-</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <span class="text-muted">Total Nilai Permintaan:</span>
                                                <h5 id="detail-total">Rp 0</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <i class="fas fa-paper-plane me-2"></i> Buat Permintaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-info-circle me-2"></i> Informasi Penting</h5>
                    <ul class="mt-3">
                        <li>Permintaan yang dibuat akan langsung terlihat oleh petani</li>
                        <li>Petani dapat mengajukan penawaran sesuai dengan harga maksimum yang Anda tentukan</li>
                        <li>Anda dapat menutup permintaan kapan saja melalui menu permintaan</li>
                        <li>Pastikan jumlah dan harga yang Anda masukkan sudah sesuai</li>
                    </ul>
                </div>
            </div>
        </div>