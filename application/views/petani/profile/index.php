 <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Profil Saya</h1>
            <div class="user-profile">
                <div class="user-avatar"><?= substr($petani['nama'], 0, 1) ?></div>
                <div>
                    <div class="fw-bold"><?= $petani['nama'] ?></div>
                    <div class="text-muted small">Petani - <?= $petani['alamat'] ?></div>
                </div>
            </div>
        </div>

        <!-- Profil Card -->
        <div class="card">
            <div class="profile-header">
                <div class="profile-avatar-lg"><?= substr($petani['nama'], 0, 1) ?></div>
                <h2><?= $petani['nama'] ?></h2>
                <p class="mb-0">Petani AgriConnect</p>
            </div>
            
            <div class="card-body">
                <div class="profile-info">
                    <div>
                        <div class="info-group">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value"><?= $petani['nama'] ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= $petani['email'] ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Alamat</div>
                            <div class="info-value"><?= $petani['alamat'] ?></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="info-group">
                            <div class="info-label">Nomor Telepon</div>
                            <div class="info-value"><?= $petani['no_telepon'] ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Luas Lahan</div>
                            <div class="info-value"><?= $petani['luas_lahan'] ?> hektar</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Bergabung Sejak</div>
                            <div class="info-value"><?= date('d M Y', strtotime($petani['dibuat_pada'])) ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="<?= site_url('petani/profil/edit') ?>" class="btn btn-edit">
                        <i class="fas fa-edit me-2"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>