<?php
session_start();
include 'koneksi.php'; // Sertakan file koneksi database Anda

// Jika sudah login, redirect ke homepage
if (isset($_SESSION['username'])) {
    header("Location: homepage.php");
    exit;
}

// Inisialisasi variabel untuk pesan error
$username_err = $password_err = $confirm_password_err = $register_success = $register_err = "";
$username = $password = $confirm_password = "";

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil nilai dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']); // Untuk konfirmasi password

    // Validasi input username
    if (empty($username)) {
        $username_err = "Mohon masukkan username Anda.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $username_err = "Username hanya boleh berisi huruf, angka, dan underscore.";
    } else {
        // Cek apakah username sudah terdaftar
        $sql = "SELECT id FROM user WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Username ini sudah terdaftar.";
                }
            } else {
                echo "Terjadi kesalahan. Silakan coba lagi nanti.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validasi input password
    if (empty($password)) {
        $password_err = "Mohon masukkan password Anda.";
    } elseif (strlen($password) < 6) {
        $password_err = "Password harus memiliki minimal 6 karakter.";
    }

    // Validasi konfirmasi password
    if (empty($confirm_password)) {
        $confirm_password_err = "Mohon konfirmasi password Anda.";
    } else {
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Konfirmasi password tidak cocok.";
        }
    }

    // Jika tidak ada error validasi, coba daftarkan pengguna
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // PERHATIAN PENTING:
        // Kode ini masih menyimpan password dalam plain text.
        // UNTUK PRODUKSI, SANGAT DISARANKAN UNTUK MENGGUNAKAN password_hash() UNTUK KEAMANAN.
        // Contoh: $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (username, password) VALUES (?, ?)"; // Asumsi tabel Anda 'user' dengan kolom 'username' dan 'password'

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = $password; // Jika Anda menggunakan hashing, ganti dengan $hashed_password

            if (mysqli_stmt_execute($stmt)) {
                $register_success = "Pendaftaran berhasil! Silakan login.";
                // Clear the form fields after successful registration
                $username = $password = $confirm_password = "";
                // Atau langsung redirect ke halaman login
                header("location: index.php?registration_success=true");
                exit;
            } else {
                $register_err = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Drivewise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS dari desain login, disesuaikan untuk register */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f3f4f6;
        }
        .left-panel {
            background-color: #F89B2B; /* Warna oranye */
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px 30px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }
        .left-panel-content {
            color: white;
            z-index: 1;
            position: relative;
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .left-panel h1 {
            font-size: clamp(1.8rem, 2.5vw + 1rem, 3.5rem);
            line-height: 1.2;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .left-panel h1 strong {
            font-weight: normal;
            font-size: 1em;
        }
        .car-image {
            width: 250px;
            height: auto;
            margin-top: 20px;
            display: block; /* Pastikan gambar adalah block untuk margin auto */
        }
        @media (min-width: 1024px) {
            .car-image {
                width: 400px;
            }
        }
        .left-panel .footer-text {
            font-size: 0.8em;
            color: rgba(255, 255, 255, 0.7);
            position: absolute;
            bottom: 20px;
            left: 30px;
            z-index: 1;
        }
        .right-panel {
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
        }
        .register-container { /* Menggunakan kelas baru untuk kontainer register */
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-container h2 {
            margin-bottom: 30px;
            color: #2E709E; /* Warna biru konsisten */
            font-size: 1.8em;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        .form-control:focus {
            border-color: #F89B2B; /* Warna oranye fokus */
            box-shadow: 0 0 0 0.25rem rgba(248, 155, 43, 0.25);
            outline: none;
        }
        .btn-register { /* Menggunakan kelas baru untuk tombol register */
            background-color: #2E709E; /* Warna biru konsisten */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-register:hover {
            background-color: #245A7E; /* Hover yang sedikit lebih gelap */
        }
        .login-link { /* Kelas baru untuk link ke login */
            margin-top: 25px;
            font-size: 0.9em;
            color: #777;
        }
        .login-link a {
            color: #4A8CAF; /* Warna biru untuk link */
            text-decoration: none;
            font-weight: bold;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
            text-align: left;
        }
        .success-message {
            color: green;
            font-size: 0.9em;
            margin-bottom: 20px;
            text-align: center;
        }
        /* Styling untuk gelombang/garis di panel kiri */
        .wave-line {
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 20%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0.3) 80%, rgba(255,255,255,0) 100%);
            z-index: 0;
        }
        .wave-line:nth-child(1) { top: 30%; width: 120%; left: -10%; opacity: 0.2; transform: rotate(-3deg); }
        .wave-line:nth-child(2) { top: 45%; width: 110%; left: -5%; opacity: 0.4; transform: rotate(2deg); }
        .wave-line:nth-child(3) { top: 60%; width: 105%; left: 0%; opacity: 0.6; transform: rotate(-1deg); }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="wave-line"></div>
        <div class="wave-line"></div>
        <div class="wave-line"></div>

        <div class="left-panel-content">
            <h1>Sewa Mobil Jadi Lebih Mudah Bersama Drivewise.<br><strong>Mulai perjalanan nyamanmu.</strong></h1>
            <img src="assets/login-car.png" alt="Car Image" class="car-image">
        </div>
    </div>

    <div class="right-panel">
        <div class="register-container"> <h2>Daftar Akun Drivewise</h2> <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <?php if (!empty($register_success)) { echo '<div class="success-message">' . $register_success . '</div>'; } ?>
                <?php if (!empty($register_err)) { echo '<div class="error-message" style="margin-bottom: 20px;">' . $register_err . '</div>'; } ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" placeholder="Masukkan username" required>
                    <?php if (!empty($username_err)) { echo '<div class="error-message">' . $username_err . '</div>'; } ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    <?php if (!empty($password_err)) { echo '<div class="error-message">' . $password_err . '</div>'; } ?>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Konfirmasi password" required>
                    <?php if (!empty($confirm_password_err)) { echo '<div class="error-message">' . $confirm_password_err . '</div>'; } ?>
                </div>
                
                <button type="submit" class="btn btn-register">Daftar</button> </form>
            <p class="mt-3 text-center login-link">Sudah punya akun? <a href="index.php">Login sekarang</a></p> </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>