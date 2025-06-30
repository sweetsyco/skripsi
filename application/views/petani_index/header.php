<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <h3>Agri<span>Connect</span></h3>
        </div>
        <div class="sidebar-menu">
            <a href="<?= base_url('petani/dashboard') ?>" class="active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?= site_url('petani/penawaran/buat') ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>Permintaan</span>
            </a>
            <a href="<?= base_url('petani/penawaran') ?>">
                <i class="fas fa-handshake"></i>
                <span>Penawaran Saya</span>
            </a>
            <a href="<?= base_url('petani/kurir') ?>">
                <i class="fas fa-truck"></i>
                <span>Penugasan Kurir</span>
            </a>
            <a href="<?= base_url('petani/komoditas') ?>">
                <i class="fas fa-seedling"></i>
                <span>Komoditas Saya</span>
            </a>
            <a href="<?= base_url('petani/profil') ?>">
                <i class="fas fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>
            <div class="logout-item">
                <a href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>