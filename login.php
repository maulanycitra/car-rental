<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $_SESSION['username'] = $username;
    header("location:homepage.php");
} else {
    echo "Login gagal. <a href='index.php'>Coba lagi</a>";
}
?>