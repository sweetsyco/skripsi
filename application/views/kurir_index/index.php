<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #5B913B; 
            --secondary: #FF9800;
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
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary) 0%, #4a7a30 100%);
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
            background-color: rgba(91, 145, 59, 0.1);
            color: var(--primary);
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
            background-color: rgba(91, 145, 59, 0.1);
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
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        /* Perbaiki style tombol */
        .btn-upload {
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

        .btn-upload:hover {
            background-color: #4a7a30;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(91, 145, 59, 0.3);
        }

        .btn-batal {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .btn-batal:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
            color: white;
        }
        
        .btn-action:hover {
            background-color: #4a7a30;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(91, 145, 59, 0.3);
        }
        
        .btn-action.secondary {
            background-color: var(--secondary);
        }
        
        .btn-action.secondary:hover {
            background-color: #e68a00;
            box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
        }
        
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }
        
        .badge-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #e0a800;
        }
        
        .badge-in-progress {
            background-color: rgba(23, 162, 184, 0.15);
            color: #138496;
        }
        
        .badge-completed {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        .badge-danger {
            background-color: rgba(40, 167, 69, 0.15);
            color:rgb(240, 63, 63);
        }
        
        .action-buttons {
            display: flex;
            gap: 2px;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            display: inline-flex;
            font-size: 14px;
            align-items: center;
            gap: 5px;
            margin-right: 2px;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
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
        
        .btn-start {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: none;
        }

        .btn-start:hover {
            background-color: rgba(40, 167, 69, 0.25);
            text-decoration: none;
        }
        
        .btn-verify {
            background-color: rgba(255, 152, 0, 0.15);
            color: #e68a00;
            border: none;
        }

        .btn-verify:hover {
            background-color: rgba(255, 152, 0, 0.25);
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
        
        .task-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .task-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(91, 145, 59, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .task-content {
            flex-grow: 1;
        }
        
        .task-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .task-details {
            color: #6c757d;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .task-details span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .verification-form {
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        
        .verification-form h4 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .verification-image {
            width: 100%;
            height: 200px;
            background-color: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-bottom: 20px;
            cursor: pointer;
            border: 2px dashed #ced4da;
        }
        
        .verification-image i {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .verification-image:hover {
            border-color: var(--primary);
        }
        
        .detail-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        
        .detail-value {
            color: #6c757d;
            text-align: right;
        }
        
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
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
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .dashboard-section {
            animation: fadeIn 0.6s ease-out;
        }
        .verification-form {
    background-color: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-top: 20px;
}

.verification-form h4 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.verification-image {
    width: 100%;
    height: 200px;
    background-color: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin-bottom: 20px;
    cursor: pointer;
    border: 2px dashed #ced4da;
}

.verification-image i {
    font-size: 48px;
    color: #6c757d;
    margin-bottom: 10px;
}

.verification-image:hover {
    border-color: var(--primary);
}
.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 32px;
    margin-right: 20px;
}

.profile-info {
    display: flex;
    flex-direction: column;
}

.profile-name {
    font-weight: 700;
    font-size: 24px;
    margin-bottom: 5px;
}

.profile-role {
    color: var(--secondary);
    font-weight: 600;
    background-color: rgba(255, 152, 0, 0.15);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
    display: inline-block;
    width: fit-content;
}

.btn-edit {
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
    cursor: pointer;
}

.btn-edit:hover {
    background-color: #4a7a30;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(91, 145, 59, 0.3);
}

.profile-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.stat-item {
    flex: 1;
    background-color: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    text-align: center;
    transition: transform 0.3s;
}

.stat-item:hover {
    transform: translateY(-5px);
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 10px;
}

.stat-label {
    color: #6c757d;
    font-size: 16px;
}

.detail-card {
    background-color: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.detail-card h4 {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 10px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #495057;
}

.detail-value {
    color: #6c757d;
}

.edit-form {
    background-color: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.form-label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}

.btn-cancel {
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    cursor: pointer;
    margin-right: 10px;
}

.btn-cancel:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

.btn-save {
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
    cursor: pointer;
}

.btn-save:hover {
    background-color: #4a7a30;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(91, 145, 59, 0.3);
}

.text-muted {
    color: #6c757d !important;
    font-size: 0.875em;
}

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>