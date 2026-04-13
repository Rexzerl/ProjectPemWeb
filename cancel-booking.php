<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id_booking = $_GET['id'] ?? null;

if (!$id_booking) {
    die("ID booking tidak valid");
}

// ambil data booking dulu (buat dapet id_schedule)
$q = mysqli_query($conn, "
    SELECT * FROM booking 
    WHERE id_booking = $id_booking
");

$booking = mysqli_fetch_assoc($q);

if (!$booking) {
    die("Booking tidak ditemukan");
}

// 1. update status booking jadi cancelled
mysqli_query($conn, "
    UPDATE booking 
    SET status = 'cancelled'
    WHERE id_booking = $id_booking
");

// 2. balikin schedule jadi available
mysqli_query($conn, "
    UPDATE mentor_schedule 
    SET status = 'available'
    WHERE id_schedule = {$booking['id_schedule']}
");

header("Location: profile.php");
exit;
?>