<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 340px;
        }
        .form-container h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
            font-size: 14px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 95%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin: 20px 0 15px;
            transition: background-color 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
        .form-toggle {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }
        .form-toggle a {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }
        .form-toggle a:hover {
            text-decoration: underline;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Login Form -->
        <div id="loginForm">
            <h2>Login</h2>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="error-message"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            
            <form action="<?php echo site_url('auth/login')?>" method="post" id="loginFormElement">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required />
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
                
                <input type="submit" value="Login" />
            </form>
            
            <div class="form-toggle">
                Don't have an account? <a href="<?php echo site_url('auth/register');?>" id="showRegister" >Register</a>
            </div>
        </div>
    </div>
</body>
</html>
