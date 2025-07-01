<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <h3>Agri<span>Connect</span></h3>
        </div>
        <div class="sidebar-menu">
            <a href="<?= base_url('kurir') ?>" class="active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="#">
                <i class="fas fa-tasks"></i>
                <span>Penugasan</span>
            </a>
            <a href="#">
                <i class="fas fa-truck"></i>
                <span>Perjalanan</span>
            </a>
            <a href="#">
                <i class="fas fa-check-circle"></i>
                <span>Verifikasi</span>
            </a>
            <a href="#">
                <i class="fas fa-history"></i>
                <span>Riwayat</span>
            </a>
            <a href="#">
                <i class="fas fa-user-circle"></i>
                <span>Profil</span>
            </a>
            <div class="logout-item">
                <a href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>