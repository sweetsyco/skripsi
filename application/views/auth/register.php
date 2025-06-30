<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        .register-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 340px;
        }
        .register-container h2 {
            margin-top: 0;
            text-align: center;
        }
        .register-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="tel"],
        .register-container input[type="number"],
        .register-container select,
        .register-container textarea {
            width: 90%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .register-container input[type="submit"] {
            width: 97%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin: 20px 0 15px;
        }
        .register-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
        .role-details {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .form-toggle {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .form-toggle a {
            color: #007bff;
            text-decoration: none;
        }
        .form-toggle a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <?php if ($this->session->flashdata('error')): ?>
            <div class="error-message"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <h2>Register</h2>
        <form action="<?php echo site_url('auth/register'); ?>" method="post">
            <!-- User Information -->
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" required />
            
            <label for="email">Email :</label>
            <input type="text" id="email" name="email" required />
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />
            
            <!-- Role Selection -->
            <label for="peran">Role</label>
            <select id="peran" name="peran" required onchange="showRoleDetails()">
                <option value="">Pilih Role</option>
                <option value="distributor">Distributor</option>
                <option value="petani">Petani</option>
                <option value="kurir">Kurir</option>
            </select>
            
            <!-- Distributor Details -->
            <div id="distributor-details" class="role-details">
                <h3>Data Distributor</h3>
                <label for="nama_perusahaan">Nama Perusahaan:</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" />
                
                <label for="alamat_distributor">Alamat:</label>
                <textarea id="alamat_distributor" name="alamat_distributor" rows="2"></textarea>
                
                <label for="no_telepon_distributor">No. Telepon:</label>
                <input type="tel" id="no_telepon_distributor" name="no_telepon_distributor" />
            </div>
            
            <!-- Petani Details -->
            <div id="petani-details" class="role-details">
                <h3>Data Petani</h3>
                <label for="alamat_petani">Alamat:</label>
                <textarea id="alamat_petani" name="alamat_petani" rows="2"></textarea>
                
                <label for="no_telepon_petani">No. Telepon:</label>
                <input type="tel" id="no_telepon_petani" name="no_telepon_petani" />
                
                <label for="luas_lahan">Luas Lahan (hektar):</label>
                <input type="number" step="0.01" id="luas_lahan" name="luas_lahan" />
            </div>
            
            <!-- Kurir Details -->
            <div id="kurir-details" class="role-details">
                <h3>Data Kurir</h3>
                <label for="no_kendaraan">No. Kendaraan:</label>
                <input type="text" id="no_kendaraan" name="no_kendaraan" />
                <label for="id_distributor">Distributor:</label>
                <select id="id_distributor" name="id_distributor">
                    <option value="">Pilih Distributor</option>
                    <?php foreach ($distributors as $distributor): ?>
                        <option value="<?php echo $distributor->id; ?>">
                            <?php echo $distributor->nama_perusahaan . ' (' . $distributor->nama . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="cakupan_area">Cakupan Area:</label>
                <input type="text" id="cakupan_area" name="cakupan_area" />
            </div>
            
            <input type="submit" value="Register" />
        </form>
        
        <div class="form-toggle">
            Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>">Login disini</a>
        </div>
    </div>

    <script>
        function showRoleDetails() {
            // Hide all role details
            document.querySelectorAll('.role-details').forEach(el => {
                el.style.display = 'none';
            });
            
            // Show selected role details
            const role = document.getElementById('peran').value;
            if (role) {
                document.getElementById(`${role}-details`).style.display = 'block';
            }
        }
        
        // Initialize the form based on selected role
        document.addEventListener('DOMContentLoaded', function() {
            showRoleDetails();
        });
    </script>
</body>
</html>