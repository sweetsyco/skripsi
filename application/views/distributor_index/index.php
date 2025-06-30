<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - AgriConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
:root {
            --primary: #2c786c;
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
            background: linear-gradient(180deg, var(--primary) 0%, #1a5c53 100%);
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
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
            background-color: rgba(44, 120, 108, 0.1);
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
            background-color: #235c53;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(44, 120, 108, 0.3);
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
        .badge-pending {
            background-color: #ffc107; /* Warna kuning untuk menunggu */
            color: #000;
        }
        .badge-accepted {
            background-color: #28a745; /* Warna hijau untuk diterima */
            color: #fff;
        }
        .badge-rejected {
            background-color: #dc3545; /* Warna merah untuk ditolak */
            color: #fff;
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
            background-color: rgba(44, 120, 108, 0.05);
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
            background-color: #235c53;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(44, 120, 108, 0.3);
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
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
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
        
        .btn-close {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: none;
        }
        
        .btn-close:hover {
            background-color: rgba(220, 53, 69, 0.25);
            text-decoration: none;
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
        }
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .modal-header {
            background-color: var(--primary);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }
        
        /* Penyesuaian khusus untuk halaman laporan */
        .filter-container {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .chart-container {
            height: 300px;
            position: relative;
            margin: 20px 0;
        }
        
        .stat-card.vertical {
            flex-direction: column;
            text-align: center;
            padding: 25px 15px;
        }
        
        .stat-card.vertical .stat-icon {
            margin: 0 auto 15px;
            color: var(--primary);
            background-color: rgba(44, 120, 108, 0.1);
            font-size: 24px;
        }
        
        .stat-card.vertical .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card.vertical .stat-label {
            color: #6c757d;
        }
        
        .commodity-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        
        .commodity-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .commodity-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }
        
        .card-footer {
            background-color: white;
            border-top: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
        }
                .modal-content {
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .modal-header {
            background-color: var(--primary);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }
        .logout-item {
            margin-top: auto; /* Dorong ke bawah */
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>