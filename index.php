<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "uas");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi variabel error
$err = '';

// Periksa apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inisialisasi variabel error
    $err = '';
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Memastikan input tidak kosong
    if (empty($username) || empty($password)) {
        $err .= "<p>Silakan masukkan username dan juga password.</p>";
    } else {
        // Query untuk mencari pengguna berdasarkan username
        $sql1 = "SELECT * FROM pengguna WHERE username = '$username'";
        $q1 = $conn->query($sql1);
        // Jika query menghasilkan baris (row)
        if ($q1 && $q1->num_rows > 0) {
            $r1 = $q1->fetch_assoc();
            // Validasi password
            if ($r1['password'] != md5($password)) {
                $err .= "<p>Username atau password salah.</p>";
            }
        } else {
            // Jika tidak ada baris yang ditemukan
            $err .= "<p>Username atau password salah.</p>";
        }
        // Mengecek apakah ada error, jika tidak ada error login akan berhasil
        if (empty($err)) {
            // Simpan username dan password dalam sesi
            $_SESSION['session_username'] = $username;
            $_SESSION['session_password'] = md5($password);
            // Redirect ke halaman dashboard
            header("Location: dashboard.php");
            exit();
        }
    }
}


// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        p{
            margin: 0;
        }
        body {
            background-color: #4158D0;
            background-image: -webkit-linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            background-image: -moz-linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            background-image: -o-linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            background-image: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            padding: 20px;
            height: 100vh;
        }
        .login-container{
            width: 40%;
            margin: auto;
            background: black;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
            opacity: 0.7;
            align-self: center;
        }
        .alert-danger p{
            text-align: center;
        }
        .container{
            height: 100vh;
            display: flex;
        }
        form, .card, .card-body{
            background: black;
            color: white;
        }
        .card {
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container justify-content-center align-items-center">
        <h1 class="text-center" data-aos="fade-up" style="color: white; font-weight:bold; padding:20px;">Login Admin Dashboard</h1>
        <div class="login-container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Login</h2>
                    <!-- Menampilkan error jika ada -->
                    <?php if (!empty($err)): ?>
                        <div class="alert alert-danger">
                            <?php echo $err; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form login -->
                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" id="remember_me" name="remember_me" class="form-check-input">
                            <label for="remember_me" class="form-check-label">Remember Me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="login.js"></script>
</body>
</html>
