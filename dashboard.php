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

<body class="bg-white overflow-x-hidden">

<!-- HERO -->
<section class="relative bg-[#B6DCFF] overflow-hidden pb-32">

    <!-- NAVBAR -->
    <div class="flex justify-between items-center px-12 py-6 relative z-20">
        <div class="flex items-center gap-2">
            <img src="image/logo.png" class="w-[200px]">
        </div>

        <a href="logout.php" class="bg-[#175BAF] text-white px-5 py-2 rounded-full text-sm shadow">
            Logout
        </a>
    </div>

    <!-- DECOR -->
    <img src="image/garislingkaran.png" class="absolute top-20 right-10 w-[300px] opacity-70">
    <img src="image/bintiklingkaran.png" class="absolute top-40 right-[500px] w-[200px] opacity-70">

    <!-- CONTENT -->
    <div class="flex items-center justify-between px-12 pt-10">

        <!-- LEFT -->
        <div class="max-w-xl z-10">

            <p class="text-[#2F5789] text-sm mb-4">
                Welcome back, <?php echo $_SESSION['nama']; ?> 👋
            </p>

            <h1 class="text-[52px] font-bold text-white leading-tight">
                FIND THE RIGHT <br> MENTOR FROM YOUR <br> CAMPUS
            </h1>

            <button class="mt-8 bg-[#175BAF] text-white px-8 py-3 rounded-full shadow-md hover:scale-105 transition">
                Masuk
            </button>
        </div>

        <!-- RIGHT -->
        <div class="relative w-[480px] h-[520px] flex items-end justify-center overflow-hidden">
            <div class="absolute top-10 left-0 bg-white px-4 py-2 rounded-xl shadow flex items-center gap-2 z-20">
    <img src="image/mahasiswa.png" class="w-10">
    <span class="text-sm text-[#2F5789]">Dari mahasiswa<br>untuk mahasiswa</span>
</div>
            <div class="absolute top-40 right-0 bg-white px-4 py-2 rounded-xl shadow flex items-center gap-2 z-20">
    <img src="image/kalender.png" class="w-8">
    <span class="text-sm text-[#2F5789]">Fleksibilitas waktu<br>dan lokasi</span>
</div>

         <div class="absolute bottom-20 left-10 bg-white px-5 py-3 rounded-xl shadow z-20">
    <p class="text-sm text-[#2F5789]">Harga fleksibel dan<br>terjangkau</p>
</div>


            <!-- GAMBAR UTAMA -->
            <img src="image/dashboardcewe.png" 
                 class="w-[420px] relative z-10 object-cover">


        </div>
    </div>

    <!-- CURVE PUTIH -->
    <div class="absolute bottom-0 left-0 w-full h-40 bg-white rounded-t-[100px]"></div>

</section>

<!-- ABOUT -->
<section class="text-center px-10 py-20">

    <h2 class="text-4xl font-bold mb-6">
        What is Mentor Kampus?
    </h2>

    <p class="text-[#2F5789] max-w-3xl mx-auto text-lg leading-relaxed">
        MentorKampus is a peer-to-peer learning platform where students can find affordable mentors from fellow students. 
        This creates a more accessible, flexible, and collaborative learning environment.
    </p>

</section>

<!-- FEATURES -->
<section class="flex justify-center gap-12 px-10 pb-24 flex-wrap">

    <!-- CARD 1 -->
<div class="bg-white shadow-lg rounded-2xl p-8 w-72 text-center relative">

    <!-- BULAT BIRU -->
    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 
                w-16 h-16 bg-[#B6DCFF] rounded-full flex items-center justify-center shadow">
        <img src="image/iconmurah.png" class="w-8">
    </div>

    <h3 class="font-semibold text-lg mt-10 mb-2">Affordable Learning</h3>
    <p class="text-[#717378] text-sm leading-relaxed">
        MentorKampus menyediakan akses belajar dengan harga terjangkau dari sesama mahasiswa.
    </p>
</div>

    <!-- CARD 2 -->
<div class="bg-white shadow-lg rounded-2xl p-8 w-72 text-center relative">

    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 
                w-16 h-16 bg-[#B6DCFF] rounded-full flex items-center justify-center shadow">
        <img src="image/iconpeer.png" class="w-8">
    </div>

    <h3 class="font-semibold text-lg mt-10 mb-2">Peer-to-Peer Experience</h3>
    <p class="text-[#717378] text-sm leading-relaxed">
        Belajar bersama sesama mahasiswa membuat proses belajar lebih mudah dipahami.
    </p>
</div>

  <!-- CARD 3 -->
<div class="bg-white shadow-lg rounded-2xl p-8 w-72 text-center relative">

    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 
                w-16 h-16 bg-[#B6DCFF] rounded-full flex items-center justify-center shadow">
        <img src="image/iconfleksibilitas.png" class="w-8">
    </div>

    <h3 class="font-semibold text-lg mt-10 mb-2">Flexible & Accessible</h3>
    <p class="text-[#717378] text-sm leading-relaxed">
        Belajar kapan saja sesuai kebutuhan dengan pilihan mentor yang beragam.
    </p>
</div>

</section>

</body>
</html>