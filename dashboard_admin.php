<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$query_mentor = "SELECT u.email, m.*, k.nama_kampus, sv.nama_status_verif 
FROM users u
JOIN mentor_profiles m ON u.id_user = m.id_user
LEFT JOIN kampus k ON m.id_kampus = k.id_kampus
LEFT JOIN master_status_verifikasi sv ON m.id_status_verif = sv.id_status_verif";
$result_mentor = mysqli_query($conn, $query_mentor);

$query_student = "SELECT u.email, s.*, k.nama_kampus
FROM users u
JOIN student_profiles s ON u.id_user = s.id_user
LEFT JOIN kampus k ON s.id_kampus = k.id_kampus";
$result_student = mysqli_query($conn, $query_student);
?>

<!DOCTYPE html>
<html lang="en">
