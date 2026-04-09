<?php
require 'config.php';

$password_baru = "admin123";
$hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);
$email_admin = "admin@mentorcampus.com";

// Update langsung ke database
$query = "UPDATE users SET password = '$hash_baru' WHERE email = '$email_admin'";

if (mysqli_query($conn, $query)) {
    echo "<h3>Sukses! Password admin berhasil di-reset.</h3>";
    echo "Password kamu sekarang adalah: <b>$password_baru</b><br>";
    echo "Hash yang tersimpan: <code>$hash_baru</code><br><br>";
    echo "<a href='index.php'>Kembali ke Login</a>";
} else {
    echo "Gagal update: " . mysqli_error($conn);
}
?>