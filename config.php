<?php
$host = "localhost"; // Hapus :3308 di sini
$user = "root";
$pass = ""; 
$db   = "mentor_kampus"; 

// Hapus angka 3308 di akhir mysqli_connect
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>