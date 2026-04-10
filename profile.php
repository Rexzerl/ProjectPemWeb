<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT email FROM users WHERE id_user = $id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile - MentorCampus</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-gray-100 pt-24">

<?php include 'navbar.php'; ?>

<section class="relative h-[220px]">

    <img src="image/priabelajar.jpg" 
         class="w-full h-full object-cover">

    <div class="absolute bottom-6 left-12 text-white">
        <h1 class="text-2xl font-bold">
            Welcome, <?= $_SESSION['nama']; ?> 👋
        </h1>
        <p class="text-sm">
            Manage your learning journey here
        </p>
    </div>

</section>

<section class="px-12 mb-6">
    <h1 class="text-2xl font-bold text-[#2F5789]">
        My Profile
    </h1>
</section>

<!-- CONTENT -->
<section class="px-12 grid md:grid-cols-3 gap-8">

    <!-- LEFT CARD -->
    <div class="bg-white rounded-2xl shadow p-6 text-center">

        <!-- AVATAR -->
        <div class="w-24 h-24 mx-auto rounded-full bg-[#B6DCFF] flex items-center justify-center text-2xl font-bold text-[#175BAF]">
            <?= strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
        </div>

        <h2 class="mt-4 font-semibold text-lg">
            <?= $_SESSION['nama']; ?>
        </h2>

        <p class="text-gray-500 text-sm">
    <?= $user['email']; ?>
</p>

        <button class="mt-4 bg-[#175BAF] text-white px-5 py-2 rounded-full text-sm">
            Edit Profile
        </button>

    </div>

    <!-- RIGHT SIDE -->
    <div class="md:col-span-2 space-y-6">

        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="font-semibold text-[#2F5789] mb-4">
                Account Information
            </h3>

            <div class="grid grid-cols-2 gap-4 text-sm">

                <div>
                    <p class="text-gray-400">Full Name</p>
                    <p><?= $_SESSION['nama']; ?></p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">
                        <?= $user['email']; ?>
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Role</p>
                    <p>Student</p>
                </div>

                <div>
                    <p class="text-gray-400">Status</p>
                    <p class="text-green-500">Active</p>
                </div>

            </div>

        </div>

        <!-- STATS -->
        <div class="grid grid-cols-3 gap-4">

            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-400">Courses</p>
                <p class="text-xl font-bold text-[#2F5789]">5</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-400">Completed</p>
                <p class="text-xl font-bold text-[#2F5789]">3</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-400">Ongoing</p>
                <p class="text-xl font-bold text-[#2F5789]">2</p>
            </div>

        </div>

    </div>

</section>

</body>
</html>