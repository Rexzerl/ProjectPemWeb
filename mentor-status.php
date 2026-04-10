<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];
$nama = $_SESSION['nama'];

// ambil data pengajuan
$q = mysqli_query($conn, "SELECT * FROM calon_mentor WHERE id_user = $id_user");
$data = mysqli_fetch_assoc($q);

$status = $data['status'] ?? 'none';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentor Status - MentorCampus</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Lexend', sans-serif; }
</style>
</head>

<body class="bg-[#F5F7FA] pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="text-center py-10">
    <h1 class="text-3xl font-bold text-[#175BAF]">
        Mentor Application Status
    </h1>
    <p class="text-gray-500 mt-2">
        Track your journey to become a mentor 🚀
    </p>
</section>

<!-- CARD -->
<section class="flex justify-center px-6">

<div class="bg-white w-full max-w-xl p-8 rounded-2xl shadow text-center">

<?php if (isset($_GET['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            🎉 Pengajuan berhasil dikirim! Tunggu verifikasi admin.
        </div>
    <?php endif; ?>

    <h2 class="text-xl font-semibold mb-4">
        Hello, <?= $nama; ?> 👋
    </h2>
<?php if ($status == 'pending'): ?>

    <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl">
        ⏳ Your application is being reviewed
    </div>

<?php elseif ($status == 'accepted'): ?>

    <div class="bg-green-100 text-green-700 p-4 rounded-xl">
        🎉 Congratulations! You are now a mentor
    </div>

<?php elseif ($status == 'rejected'): ?>

    <div class="bg-red-100 text-red-700 p-4 rounded-xl">
        ❌ Sorry, your application was rejected
    </div>

<?php else: ?>

    <div class="bg-gray-100 text-gray-600 p-4 rounded-xl">
        You haven't applied yet
    </div>

<?php endif; ?>

<!-- DETAIL -->
<div class="mt-6 text-left text-sm text-gray-600 space-y-2">

    <div class="flex justify-between">
        <span>Status</span>
        <span class="font-semibold capitalize"><?= $status; ?></span>
    </div>

    <div class="flex justify-between">
        <span>Submitted At</span>
        <span><?= $data['created_at'] ?? '-' ?></span>
    </div>

</div>

<!-- ACTION -->
<div class="mt-6">

<?php if ($status == 'accepted'): ?>
    <a href="dashboard.php" 
       class="inline-block bg-green-500 text-white px-5 py-2 rounded-full text-sm hover:scale-105 transition">
        Go to Mentor Dashboard
    </a>

<?php else: ?>
    <a href="courses.php" 
       class="inline-block bg-[#175BAF] text-white px-5 py-2 rounded-full text-sm hover:scale-105 transition">
        Back to Explore
    </a>
<?php endif; ?>

</div>

</div>

</section>

</body>
</html>