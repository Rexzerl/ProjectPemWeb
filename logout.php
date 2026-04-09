<?php
session_start();

// Menghapus semua data session
session_unset();
session_destroy();

// Menghapus cookie login (jika ada)
setcookie('user_id', '', time() - 3600, "/");
setcookie('user_key', '', time() - 3600, "/");

// Lempar kembali ke halaman login utama
header("Location: index.php"); 
exit;
?>