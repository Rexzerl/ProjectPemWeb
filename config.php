<?php
$host = "localhost:3308";
$user = "root";
$pass = ""; 
$db   = "mentor_kampus"; 
$conn = mysqli_connect($host, $user, $pass, $db, 3308);
$db   = "mentor_kampus"; 
$conn = mysqli_connect($host, $user, $pass, $db, 3306);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>