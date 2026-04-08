<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MentorKampus Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-[#F5F7FA] overflow-x-hidden pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="relative overflow-hidden pt-20 pb-20">

    <!-- BACKGROUND IMAGE -->
    <img src="image/pena.jpg" 
         class="absolute inset-0 w-full h-full object-cover">

    <!-- CONTENT -->
    <div class="relative z-10 flex justify-center px-6">

        <div class="max-w-2xl text-center">

            <p class="text-[#2F5789] text-sm mb-3">
                Welcome back, <?= $_SESSION['nama']; ?> 👋
            </p>

            <h1 class="text-[44px] font-bold text-white leading-tight mb-4">
                Find the Right Mentor for You
            </h1>

            <p class="text-[#2F5789] text-sm mb-6">
                Learn with peers, grow faster, and achieve your academic goals in a flexible way.
            </p>

            <button class="bg-[#175BAF] text-white px-7 py-3 rounded-full shadow hover:shadow-lg hover:scale-105 transition">
                Explore Mentor
            </button>

        </div>

    </div>

</section>

<!-- ABOUT -->
<section class="text-center px-6 py-16 bg-[#F5F7FA]">

    <h2 class="text-3xl font-bold mb-4 text-[#2F5789]">
        What is MentorKampus?
    </h2>

    <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
        MentorKampus is a peer-to-peer learning platform where students connect 
        with fellow students to gain knowledge in a more accessible, affordable, 
        and flexible way.
    </p>

</section>

<!-- FEATURES -->
<section class="px-6 pb-20 bg-[#F5F7FA]">

    <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">

        <!-- CARD 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-2 transition text-center">

            <div class="w-14 h-14 bg-[#B6DCFF] rounded-full flex items-center justify-center mx-auto mb-4">
                <img src="image/iconmurah.png" class="w-6">
            </div>

            <h3 class="font-semibold text-[#2F5789] mb-2">
                Affordable Learning
            </h3>

            <p class="text-gray-500 text-sm">
                Access quality mentoring at a student-friendly price.
            </p>

        </div>

        <!-- CARD 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-2 transition text-center">

            <div class="w-14 h-14 bg-[#B6DCFF] rounded-full flex items-center justify-center mx-auto mb-4">
                <img src="image/iconpeer.png" class="w-6">
            </div>

            <h3 class="font-semibold text-[#2F5789] mb-2">
                Peer Learning
            </h3>

            <p class="text-gray-500 text-sm">
                Learn from fellow students who understand your needs.
            </p>

        </div>

        <!-- CARD 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-2 transition text-center">

            <div class="w-14 h-14 bg-[#B6DCFF] rounded-full flex items-center justify-center mx-auto mb-4">
                <img src="image/iconfleksibilitas.png" class="w-6">
            </div>

            <h3 class="font-semibold text-[#2F5789] mb-2">
                Flexible Access
            </h3>

            <p class="text-gray-500 text-sm">
                Study anytime with flexible schedules that fit you.
            </p>

        </div>

    </div>

</section>

</body>
</html>