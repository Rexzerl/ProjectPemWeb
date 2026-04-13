<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// ambil statistik sederhana
$totalUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$totalMentor = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mentor_profiles"))['total'];
$totalBooking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM booking"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-[#F5F7FA] pt-24">

<?php include 'navbar-admin.php'; ?>

<!-- HERO -->
<section class="relative h-[260px] flex items-center justify-center text-center overflow-hidden">

    <img src="image/anakbelajar.jpg" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/80"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Admin Dashboard</h1>
        <p class="text-sm opacity-90">
            Monitor platform activity and manage users
        </p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-6 py-12">

<div class="max-w-6xl mx-auto">

    <!-- STAT CARDS -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <!-- USERS -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500 mb-1">Total Users</p>
            <h2 class="text-3xl font-bold text-[#175BAF]"><?= $totalUser; ?></h2>
        </div>

        <!-- MENTORS -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500 mb-1">Total Mentors</p>
            <h2 class="text-3xl font-bold text-[#175BAF]"><?= $totalMentor; ?></h2>
        </div>

        <!-- BOOKINGS -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
            <h2 class="text-3xl font-bold text-[#175BAF]"><?= $totalBooking; ?></h2>
        </div>

    </div>

    <!-- QUICK ACTION -->
    <div class="grid md:grid-cols-3 gap-6">

        <!-- MANAGE USER -->
        <a href="admin-users.php" 
        class="bg-white p-6 rounded-2xl shadow hover:shadow-lg hover:-translate-y-1 transition block">

            <h3 class="font-semibold text-[#175BAF] mb-2">
                Manage Users
            </h3>

            <p class="text-sm text-gray-500">
                View and manage all registered users
            </p>

        </a>

        <!-- MANAGE MENTOR -->
        <a href="admin-mentor.php" 
        class="bg-white p-6 rounded-2xl shadow hover:shadow-lg hover:-translate-y-1 transition block">

            <h3 class="font-semibold text-[#175BAF] mb-2">
                Manage Mentors
            </h3>

            <p class="text-sm text-gray-500">
                Control mentor profiles and approvals
            </p>

        </a>

        <!-- MANAGE BOOKING -->
        <a href="admin-booking.php" 
        class="bg-white p-6 rounded-2xl shadow hover:shadow-lg hover:-translate-y-1 transition block">

            <h3 class="font-semibold text-[#175BAF] mb-2">
                Manage Bookings
            </h3>

            <p class="text-sm text-gray-500">
                Monitor all booking transactions
            </p>

        </a>

        <!-- MANAGE KAMPUS -->
<a href="admin-kampus.php" 
class="bg-white p-6 rounded-2xl shadow hover:shadow-lg hover:-translate-y-1 transition block">

    <h3 class="font-semibold text-[#175BAF] mb-2">
        Manage Kampus
    </h3>

    <p class="text-sm text-gray-500">
        Add, edit, and manage campus data
    </p>

</a>

    </div>

</div>

</section>

</body>
</html>