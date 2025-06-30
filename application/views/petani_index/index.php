
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petani - AgriConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #28a745; /* Warna hijau untuk tema petani */
            --secondary: #ff9800;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            overflow-x: hidden;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary) 0%, #1e7e34 100%);
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
            gap : 15px;
        }
        
        .sidebar-logo {
            text-align: center;
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-logo h3 {
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-logo span {
            color: var(--secondary);
        }
        
        .sidebar-menu {
            padding: 0 15px;
        }
        
        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255,255,255,0.15);
            color: white;
        }
        
        .sidebar-menu i {
            width: 30px;
            font-size: 18px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-top: 15px;
        }
        
        .header h1 {
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            font-size: 28px;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }
        
        .stat-content h3 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        
        .stat-content p {
            margin: 5px 0 0;
            color: #6c757d;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .card-body {
            padding: 20px;
        }
        
        .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .activity-content {
            flex-grow: 1;
        }
        
        .activity-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .activity-time {
            color: #6c757d;
            font-size: 13px;
        }
        
        .progress-container {
            margin-bottom: 15px;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .btn-action {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-action:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        .btn-action.secondary {
            background-color: var(--secondary);
        }
        
        .btn-action.secondary:hover {
            background-color: #e68a00;
            box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
        }
        
        .actions-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .action-card i {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .action-card h4 {
            margin: 0;
            font-weight: 600;
            color: var(--dark);
        }
        
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }
        
        .empty-state {
            padding: 40px 0;
        }
        
        .empty-state-icon {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table th {
            font-weight: 600;
            color: var(--dark);
            background-color: var(--light);
            padding: 16px 20px;
        }
        
        .table td {
            padding: 16px 20px;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: background-color 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.05);
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .btn-new {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-new:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }
        
        .badge-open {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .badge-closed {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        
        .action-buttons {
			display: flex;
			/* flex-wrap: wrap; */
			gap: 2px;
		}

		.action-btn {
			padding: 6px 12px;
			border-radius: 6px;
			display: inline-flex;  /* Gunakan inline-flex agar tombol mengikuti konten */
			font-size: 14px;
			align-items: center;
			gap: 5px;
			margin-right: 2px;  /* Ganti gap dengan margin */
			transition: all 0.2s;
			text-decoration: none;  /* Hapus underline default link */
		}

		.btn-view {
			background-color: rgba(23, 162, 184, 0.15);
			color: #17a2b8;
			border: none;
		}

		.btn-view:hover {
			background-color: rgba(23, 162, 184, 0.25);
			text-decoration: none;
		}

		.btn-keluar {
			background-color: rgba(220, 53, 69, 0.15);
			color: #dc3545;
			border: none;
		}

		.btn-keluar:hover {
			background-color: rgba(220, 53, 69, 0.25);
			text-decoration: none;
		}
        
        .logout-item {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .logout-item a {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        .logout-item a:hover {
            color: #fff !important;
            background-color: rgba(255, 0, 0, 0.15) !important;
        }

        /* Enhanced styles for create-penawaran-container */
        .create-penawaran-container {
            display: flex;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(30, 126, 52, 0.15) 100%);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            border: 1px solid rgba(40, 167, 69, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .create-penawaran-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .create-content {
            flex: 1;
            padding-right: 20px;
            position: relative;
            z-index: 2;
        }
        
        .create-content h3 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .create-content h3 i {
            color: var(--primary);
            margin-right: 12px;
            font-size: 28px;
        }
        
        .create-content p {
            font-size: 16px;
            color: #5a6268;
            margin-bottom: 20px;
            line-height: 1.6;
            max-width: 600px;
        }
        
        .create-image {
            width: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }
        
        .create-image-inner {
            text-align: center;
            padding: 20px;
        }
        
        .create-image i {
            font-size: 64px;
            color: var(--primary);
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }
        
        .create-image:hover i {
            transform: scale(1.1);
        }
        
        .create-image p {
            font-weight: 600;
            color: var(--dark);
            font-size: 16px;
            margin: 0;
            background: rgba(255, 255, 255, 0.7);
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .btn-create {
            background: linear-gradient(135deg, var(--primary) 0%, #1e7e34 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
        }
        
        .btn-create:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.35);
        }
        
        .btn-create:active {
            transform: translateY(-1px);
        }
        
        .feature-badge {
            background: rgba(255, 152, 0, 0.15);
            color: #e68a00;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            margin-top: 15px;
        }
        
        .feature-list {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #495057;
            background: rgba(255, 255, 255, 0.7);
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        .feature-item i {
            color: var(--primary);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-logo h3, .sidebar-menu span {
                display: none;
            }
            
            .sidebar-menu a {
                justify-content: center;
                padding: 15px;
            }
            
            .sidebar-menu i {
                width: auto;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .actions-container {
                grid-template-columns: 1fr;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
            
            .create-penawaran-container {
                flex-direction: column;
                padding: 25px 20px;
            }
            
            .create-content {
                padding-right: 0;
                margin-bottom: 20px;
            }
            
            .create-image {
                width: 100%;
                height: auto;
                padding: 20px 0;
            }
            
            .create-image i {
                font-size: 48px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
