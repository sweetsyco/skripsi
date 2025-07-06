<div class="main-content">
    <div class="header">
        <h1>Profil Saya</h1>
        <div class="user-profile">
            <div class="user-avatar"><?= substr($kurir['nama'], 0, 2) ?></div>
            <span><?= $kurir['nama'] ?></span>
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
                <div class="profile-avatar"><?= substr($kurir['nama'], 0, 2) ?></div>
                <div class="profile-info">
                    <div class="profile-name"><?= $kurir['nama'] ?></div>
                    <div class="profile-role">Kurir</div>
                </div>
            </div>
            <button class="btn-edit" id="toggleEdit">
                <i class="fas fa-edit"></i> Edit Profil
            </button>
        </div>
        
        <!-- Profile Stats -->
        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-value"><?= $penugasan_aktif ?></div>
                <div class="stat-label">Penugasan Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?= $total_penugasan ?></div>
                <div class="stat-label">Total Penugasan</div>
            </div>
        </div>
        
        <!-- View Profile Details -->
        <div class="profile-details" id="viewProfile">
            <div class="detail-card">
                <h4><i class="fas fa-user"></i> Informasi Pribadi</h4>
                <div class="detail-row">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value"><?= $kurir['nama'] ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value"><?= $kurir['email'] ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">No. Kendaraan</div>
                    <div class="detail-value"><?= $kurir['no_kendaraan'] ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Cakupan Area</div>
                    <div class="detail-value"><?= $kurir['cakupan_area'] ?></div>
                </div>
            </div>
            
            <div class="detail-card">
                <h4><i class="fas fa-truck"></i> Informasi Kurir</h4>
                <div class="detail-row">
                    <div class="detail-label">Distributor</div>
                    <div class="detail-value"><?= $kurir['nama_perusahaan'] ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">No. Kendaraan</div>
                    <div class="detail-value"><?= $kurir['no_kendaraan'] ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Cakupan Area</div>
                    <div class="detail-value"><?= $kurir['cakupan_area'] ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Bergabung Sejak</div>
                    <div class="detail-value"><?= date('d M Y', strtotime($kurir['dibuat_pada'])) ?></div>
                </div>
            </div>
        </div>
        
        <!-- Edit Profile Form (Hidden by default) -->
        <div class="edit-form" id="editProfile" style="display: none;">
            <h3 style="margin-bottom: 25px;"><i class="fas fa-user-edit"></i> Edit Profil</h3>
            
            <?php echo form_open('kurir/profile/edit_profil'); ?>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="<?= $kurir['nama'] ?>" readonly>
                    <small class="text-muted">Nama tidak dapat diubah</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?= $kurir['email'] ?>" readonly>
                    <small class="text-muted">Email tidak dapat diubah</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">No. Kendaraan</label>
                    <input type="text" class="form-control" name="no_kendaraan" value="<?= $kurir['no_kendaraan'] ?>">
                    <?php if(form_error('no_kendaraan')): ?>
                        <div class="error-message"><?= form_error('no_kendaraan') ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Cakupan Area</label>
                    <input type="text" class="form-control" name="cakupan_area" value="<?= $kurir['cakupan_area'] ?>">
                    <?php if(form_error('cakupan_area')): ?>
                        <div class="error-message"><?= form_error('cakupan_area') ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label">No. Kendaraan</label>
                    <input type="text" class="form-control" name="no_kendaraan" value="<?= $kurir['no_kendaraan'] ?>">
                    <?php if(form_error('no_kendaraan')): ?>
                        <div class="error-message"><?= form_error('no_kendaraan') ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Cakupan Area</label>
                    <input type="text" class="form-control" name="cakupan_area" value="<?= $kurir['cakupan_area'] ?>">
                    <?php if(form_error('cakupan_area')): ?>
                        <div class="error-message"><?= form_error('cakupan_area') ?></div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleEditBtn = document.getElementById('toggleEdit');
        const cancelEditBtn = document.getElementById('cancelEdit');
        const viewProfile = document.getElementById('viewProfile');
        const editProfile = document.getElementById('editProfile');
        
        toggleEditBtn.addEventListener('click', function() {
            viewProfile.style.display = 'none';
            editProfile.style.display = 'block';
        });
        
        cancelEditBtn.addEventListener('click', function() {
            viewProfile.style.display = 'block';
            editProfile.style.display = 'none';
        });
    });
</script>