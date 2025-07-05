<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

mysqli_query($conn, "INSERT INTO user (username, password) VALUES ('$username', '$password')");
header("Location: index.php");
?>