
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <h3>Agri<span>Connect</span></h3>
        </div>
        <div class="sidebar-menu">
            <a href="<?= site_url('distributor/dashboard') ?>" class="active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?= site_url('distributor/permintaan') ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>Permintaan</span>
            </a>
            <a href="<?= site_url('distributor/penawaran') ?>">
                <i class="fas fa-handshake"></i>
                <span>Penawaran</span>
            </a>
            <a href="<?= site_url('distributor/penugasan') ?>">
                <i class="fas fa-truck"></i>
                <span>Kurir</span>
            </a>
            <a href="<?= base_url('distributor/komoditas') ?>">
                <i class="fas fa-seedling"></i>
                <span>Komoditas</span>
            </a>
            <a href="<?= site_url('distributor/laporan') ?>">
                <i class="fas fa-file-alt"></i>
                <span>Laporan</span>
            </a>
            <div class="logout-item">
                <a href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>

        