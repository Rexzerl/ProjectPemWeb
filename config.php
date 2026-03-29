<?php
$host = "localhost:3306";
$user = "root";
$pass = ""; 
$db   = "mentor_campus"; 
$conn = mysqli_connect($host, $user, $pass, $db, 3306);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>