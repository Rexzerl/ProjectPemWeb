<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$query = mysqli_query($conn, "
    SELECT cm.*, u.nama, k.nama_kampus 
    FROM calon_mentor cm
    JOIN users u ON cm.id_user = u.id_user
    JOIN kampus k ON cm.id_kampus = k.id_kampus
    ORDER BY cm.status ASC
") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Approval Mentor</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Lexend', sans-serif; }
</style>
</head>

<body class="bg-[#F5F7FA] pt-24">

<?php include 'navbar-admin.php'; ?>

<section class="px-10 py-8">

<h1 class="text-2xl font-semibold mb-6">Mentor Applications</h1>

<div class="space-y-6">

<?php while ($row = mysqli_fetch_assoc($query)): ?>

<div class="bg-white rounded-xl shadow p-5 flex justify-between items-center hover:shadow-lg transition">

    <div>
        <p class="text-sm text-gray-500">
            <?= $row['nama_kampus']; ?>
        </p>

        <h3 class="font-semibold text-lg">
            <?= $row['nama']; ?>
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            <?= $row['spesialisasi']; ?>
        </p>

        <p class="mt-2 text-sm font-medium
        <?= $row['status'] == 'pending' ? 'text-yellow-500' : 
           ($row['status'] == 'accepted' ? 'text-green-500' : 'text-red-500'); ?>">
            <?= ucfirst($row['status']); ?>
        </p>
    </div>

    <!-- BUTTON DETAIL -->
    <a href="admin-mentor-details.php?id=<?= $row['id_calon']; ?>"
       class="bg-[#175BAF] text-white px-4 py-2 rounded-lg text-sm hover:scale-105 transition">
        Detail
    </a>

</div>

<?php endwhile; ?>

</div>

</section>

</body>
</html>