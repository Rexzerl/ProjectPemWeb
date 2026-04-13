<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Ambil ID booking dari URL
$id_booking = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_user = $_SESSION['user_id'];

if ($id_booking > 0) {
    $query = "DELETE FROM booking 
              WHERE id_booking = $id_booking 
              AND id_student = $id_user 
              AND status = 'cancelled'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: profile.php?msg=history_deleted");
    } else {
        die("Gagal menghapus riwayat: " . mysqli_error($conn));
    }
} else {
    header("Location: profile.php");
}
exit;