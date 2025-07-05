<?php
session_start(); // Pastikan session dimulai di awal
include 'koneksi.php'; // Sertakan file koneksi database Anda

// Jika sudah login, redirect ke homepage
if (isset($_SESSION['username'])) {
    header("Location: homepage.php");
    exit;
}

// Inisialisasi variabel untuk pesan error
$username_err = $password_err = $login_err = "";
$username = $password = ""; // Inisialisasi untuk menjaga nilai input

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil nilai dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input username
    if (empty($username)) {
        $username_err = "Mohon masukkan username Anda.";
    }

    // Validasi input password
    if (empty($password)) {
        $password_err = "Mohon masukkan password Anda.";
    }

    // Jika tidak ada error input, coba login
    if (empty($username_err) && empty($password_err)) {
        // PERHATIAN PENTING:
        // Kode ini SANGAT RENTAN terhadap SQL INJECTION dan menyimpan password dalam plain text.
        // UNTUK PRODUKSI, SANGAT DISARANKAN UNTUK MENGGUNAKAN PREPARED STATEMENTS DAN HASHING PASSWORD (password_hash(), password_verify()).

        $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");
        $cek = mysqli_num_rows($query);

        if ($cek > 0) {
            // Login berhasil
            $_SESSION['username'] = $username;
            header("location: homepage.php"); // Arahkan ke homepage.php sesuai kode Anda
            exit;
        } else {
            // Login gagal
            $login_err = "Username atau password salah.";
            // Kosongkan password di form setelah gagal login
            $password = "";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Drivewise</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS dari desain pertama, disesuaikan */
        body {
            font-family: 'Inter', sans-serif; /* Menggunakan font Inter dari kode kedua */
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f3f4f6; /* Warna latar belakang dari kode kedua */
        }
        .left-panel {
            background-color: #F89B2B; /* Warna oranye dari desain pertama */
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
            text-align: left; /* Ganti ini */
            color: white;
            z-index: 1;
            position: relative;
            width: 100%;
            max-width: 400px;
            /* Tambahkan properti flexbox berikut */
            display: flex; /* Aktifkan flexbox */
            flex-direction: column; /* Tata item secara vertikal */
            align-items: center; /* Tengahkan item secara horizontal di dalam kolom */
            justify-content: center; /* Tengahkan item secara vertikal (opsional, tergantung tinggi panel) */
        }
        .left-panel h1 {
            font-size: clamp(1.8rem, 2.5vw + 1rem, 3.5rem); /* responsive font size */
            line-height: 1.2;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .left-panel h1 strong {
            font-weight: normal;
            font-size: 1em;
        }
        .left-panel img {
            max-width: 300%;
            height: auto;
            display: block;
            margin-top: 20px;
            z-index: 1;
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
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05); /* Sedikit bayangan dari desain pertama */
            width: 100%;
            max-width: 400px; /* Lebar max dari kode kedua */
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 1.8em;
            color: #2E709E; /* Warna biru dari kode kedua */
        }
        .form-group { /* Dipertahankan untuk struktur label/input */
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            /* form-label dari Bootstrap 5 sudah cukup, tapi ini untuk override jika perlu */
        }
        /* Menggunakan styling input Bootstrap, tapi tambahkan fokus color */
        .form-control:focus {
            border-color: #F89B2B; /* Warna oranye dari desain pertama untuk fokus */
            box-shadow: 0 0 0 0.25rem rgba(248, 155, 43, 0.25); /* Shadow fokus */
            outline: none;
        }
        .btn-login { /* Menggunakan kelas Bootstrap dengan override */
            background-color: #2E709E; /* Warna biru kustom dari kode kedua */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #2E709E; /* Hover dari kode kedua */
        }
        .signup-link {
            margin-top: 25px;
            font-size: 0.9em;
            color: #777;
        }
        .signup-link a {
            color: #4A8CAF; /* Warna biru dari desain pertama */
            text-decoration: none;
            font-weight: bold;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
            text-align: left;
        }
        .car-image {
          width: 250px;
          height: auto;
           margin-top: 20px;
        }
        /* Kalau layar lebih dari 1024px (desktop), perbesar gambarnya */
        @media (min-width: 1024px) {
          .car-image {
            width: 400px;
          }
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
        <div class="login-container">
            <h2>Login ke Drivewise</h2> <form action="login.php" method="post">
                <div class="mb-3"> <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" placeholder="Masukkan username" required>
                    <?php if (!empty($username_err)) { echo '<div class="error-message">' . $username_err . '</div>'; } ?>
                </div>
                <div class="mb-3"> <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    <?php if (!empty($password_err)) { echo '<div class="error-message">' . $password_err . '</div>'; } ?>
                </div>
                <?php
                // Tampilkan pesan error login jika ada
                if (!empty($login_err)) {
                    echo '<div class="error-message" style="margin-bottom: 20px;">' . $login_err . '</div>';
                }
                ?>
                <button type="submit" class="btn btn-login">Login</button> </form>
            <p class="mt-3 text-center signup-link">Belum punya akun? <a href="register.php">Daftar sekarang</a></p> </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>