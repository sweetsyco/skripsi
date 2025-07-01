<div class="main-content">
        <div class="header">
            <h1>Profil Saya</h1>
            <div class="user-profile">
                <div class="user-avatar"><?= substr($petani['nama'], 0, 2) ?></div>
                <span><?= $petani['nama'] ?></span>
            </div>
        </div>
        
        <div class="profile-container">
            <!-- Tampilkan pesan sukses jika ada -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <!-- Tampilkan pesan error jika ada -->
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <!-- Profile Header -->
            <div class="profile-header">
                <div style="display: flex; align-items: center;">
                    <div class="profile-avatar"><?= substr($petani['nama'], 0, 2) ?></div>
                    <div class="profile-info">
                        <div class="profile-name"><?= $petani['nama'] ?></div>
                        <div class="profile-role">Petani</div>
                    </div>
                </div>
                <button class="btn-edit" id="toggleEdit">
                    <i class="fas fa-edit"></i> Edit Profil
                </button>
            </div>
            
            <!-- Profile Stats -->
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-value"><?= $penawaran_dikirim ?></div>
                    <div class="stat-label">Penawaran Dikirim</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $penawaran_diterima ?></div>
                    <div class="stat-label">Penawaran Diterima</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">Rp <?= number_format($total_transaksi, 0, ',', '.') ?></div>
                    <div class="stat-label">Total Transaksi</div>
                </div>
            </div>
            
            <!-- View Profile Details -->
            <div class="profile-details" id="viewProfile">
                <div class="detail-card">
                    <h4><i class="fas fa-info-circle"></i> Informasi Pribadi</h4>
                    <div class="detail-row">
                        <div class="detail-label">Nama Lengkap</div>
                        <div class="detail-value"><?= $petani['nama'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><?= $petani['email'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">No. Telepon</div>
                        <div class="detail-value"><?= $petani['no_telepon'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Alamat</div>
                        <div class="detail-value"><?= $petani['alamat'] ?></div>
                    </div>
                </div>
                
                <div class="detail-card">
                    <h4><i class="fas fa-tractor"></i> Informasi Pertanian</h4>
                    <div class="detail-row">
                        <div class="detail-label">Luas Lahan</div>
                        <div class="detail-value"><?= number_format($petani['luas_lahan'], 1, ',', '.') ?> hektar</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Bergabung Sejak</div>
                        <div class="detail-value"><?= date('d M Y', strtotime($petani['dibuat_pada'])) ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Profile Form (Hidden by default) -->
            <div class="edit-form" id="editProfile" style="display: none;">
                <h3 style="margin-bottom: 25px;"><i class="fas fa-user-edit"></i> Edit Profil</h3>
                
                <?php echo form_open('petani/profile/edit_profil'); ?>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="<?= $petani['nama'] ?>" readonly>
                        <small class="text-muted">Nama tidak dapat diubah</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= $petani['email'] ?>" readonly>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" name="no_telepon" value="<?= $petani['no_telepon'] ?>">
                        <?php if(form_error('no_telepon')): ?>
                            <div class="error-message"><?= form_error('no_telepon') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3"><?= $petani['alamat'] ?></textarea>
                        <?php if(form_error('alamat')): ?>
                            <div class="error-message"><?= form_error('alamat') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Luas Lahan (hektar)</label>
                        <input type="number" class="form-control" name="luas_lahan" value="<?= $petani['luas_lahan'] ?>" step="0.01">
                        <?php if(form_error('luas_lahan')): ?>
                            <div class="error-message"><?= form_error('luas_lahan') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Kata Sandi Baru</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi baru">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah kata sandi</small>
                        <?php if(form_error('password')): ?>
                            <div class="error-message"><?= form_error('password') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" name="password_confirm" placeholder="Konfirmasi kata sandi baru">
                        <?php if(form_error('password_confirm')): ?>
                            <div class="error-message"><?= form_error('password_confirm') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn-cancel" id="cancelEdit">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>