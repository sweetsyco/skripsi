<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Aplikasi Distribusi Komoditas' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }
        .sidebar .nav-link:hover {
            color: white;
        }
        .main-content {
            padding: 20px;
        }
        .card-dashboard {
            transition: transform 0.3s;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4>Aplikasi Distribusi</h4>
                        <small class="text-muted">Komoditas Pertanian</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('dashboard') ?>">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <?php if($this->session->userdata('peran') === 'distributor'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('distributor/toko') ?>">
                                <i class="bi bi-shop me-2"></i>
                                Kelola Toko
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('distributor/permintaan') ?>">
                                <i class="bi bi-card-checklist me-2"></i>
                                Permintaan Komoditas
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if($this->session->userdata('peran') === 'petani'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('petani/penawaran') ?>">
                                <i class="bi bi-cart-plus me-2"></i>
                                Penawaran Komoditas
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if($this->session->userdata('peran') === 'kurir'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('kurir/penjemputan') ?>">
                                <i class="bi bi-truck me-2"></i>
                                Penjemputan
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if($this->session->userdata('peran') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('admin/laporan') ?>">
                                <i class="bi bi-bar-chart me-2"></i>
                                Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('admin/manajemen') ?>">
                                <i class="bi bi-people me-2"></i>
                                Manajemen Pengguna
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('profile') ?>">
                                <i class="bi bi-person me-2"></i>
                                Profil Saya
                            </a>
                        </li>
                    </ul>
                    
                    <hr class="border-light mt-4">
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('auth/logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <span class="nav-link"><?= $this->session->userdata('nama') ?></span>
                                </li>
                                <li class="nav-item">
                                    <span class="nav-link badge bg-primary"><?= $this->session->userdata('peran') ?></span>
                                </li>
                            </ul>
                            <span class="navbar-text">
                                <?= date('d F Y') ?>
                            </span>
                        </div>
                    </div>
                </nav>
                
                <?php $this->load->view($content); ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>