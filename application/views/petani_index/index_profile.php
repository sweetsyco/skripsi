<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Petani - AgriConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS dari file index.php - tidak diubah */
        :root {
            --primary: #28a745;
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
        
        /* Profile specific styles */
        .profile-container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 36px;
            margin-right: 20px;
        }
        
        .profile-info {
            flex-grow: 1;
        }
        
        .profile-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .profile-role {
            color: var(--primary);
            font-weight: 600;
            background-color: rgba(40, 167, 69, 0.1);
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
        }
        
        .profile-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
            background-color: rgba(40, 167, 69, 0.05);
            border-radius: 12px;
            flex: 1;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 14px;
        }
        
        .profile-details {
            margin-top: 30px;
        }
        
        .detail-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .detail-card h4 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .detail-label {
            width: 150px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .detail-value {
            flex-grow: 1;
        }
        
        .btn-edit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-edit:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        .edit-form {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ced4da;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        
        .btn-save {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            margin-right: 10px;
        }
        
        .btn-cancel:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin: 0 auto 20px;
            }
            
            .profile-stats {
                flex-direction: column;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
            
            .detail-label {
                width: 100%;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .profile-container {
            animation: fadeIn 0.6s ease-out;
        }
        
        /* Error messages */
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .success-message {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>