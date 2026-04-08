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
<title>About Us - MentorKampus</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-[#B6DCFF] pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="relative h-[450px] flex items-center justify-between px-12 overflow-hidden">

    <!-- BACKGROUND -->
    <img src="image/mejabelajar.jpg" 
         class="absolute inset-0 w-full h-full object-cover">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-[#1D62B7]/20"></div>

    <!-- LEFT TEXT -->
    <div class="relative z-10 max-w-xl text-[#FFFFFF]">

        <h1 class="text-5xl font-bold leading-tight mb-6">
            Learn Better <br> With People Who <br> Understand You
        </h1>

        <p class="text-lg leading-relaxed mb-6">
            MentorKampus connects students with peers who can guide, support, 
            and mentor them in a more relatable and flexible way.
        </p>

        <button class="bg-[#003980] text-white px-6 py-3 rounded-full shadow hover:scale-105 transition">
            Explore Courses
        </button>

    </div>

</section>

<!-- FOUNDER -->
<section class="px-12 py-16 text-center bg-white">

    <h2 class="text-2xl font-bold mb-10 text-[#2F5789]">
        Meet Our Team
    </h2>

    <!-- INI YANG PENTING -->
    <div class="flex justify-center gap-10 flex-wrap">

        <?php for ($i = 0; $i < 3; $i++): ?>
        <div class="bg-white w-64 rounded-2xl shadow hover:shadow-xl hover:-translate-y-2 transition duration-300 overflow-hidden">

            <!-- TOP DECOR -->
            <div class="h-20 bg-gradient-to-r from-[#B6DCFF] to-[#6FAFF7]"></div>

            <!-- FOTO -->
            <div class="flex justify-center -mt-12">
                <img src="image/dashboardcewe.png" 
                     class="w-24 h-24 object-cover rounded-full border-4 border-white shadow">
            </div>

            <!-- CONTENT -->
            <div class="p-5 text-center">
                <h3 class="font-semibold text-[#2F5789]">Mentor Kampus Team</h3>
                <p class="text-sm text-gray-500 mb-3">Founder</p>
            </div>

        </div>
        <?php endfor; ?>

    </div>

</section>
<!-- VALUE / KEUNGGULAN -->
<section class="px-10 py-10 space-y-6">

    <div class="bg-white rounded-xl p-6 shadow text-[#2F5789]">
        <h3 class="font-semibold text-lg mb-2">Accessible Learning</h3>
        <p class="text-sm">
            We aim to make learning accessible to all students by connecting them 
            with peers who understand their struggles and learning styles.
        </p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow text-[#2F5789]">
        <h3 class="font-semibold text-lg mb-2">Affordable Mentorship</h3>
        <p class="text-sm">
            MentorKampus provides a cost-effective alternative to traditional tutoring, 
            ensuring that quality education does not come at a high price.
        </p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow text-[#2F5789]">
        <h3 class="font-semibold text-lg mb-2">Collaborative Environment</h3>
        <p class="text-sm">
            We foster a collaborative learning culture where students support and grow 
            together through shared experiences and knowledge.
        </p>
    </div>

</section>

<!-- CLOSING -->
<section class="text-center px-10 py-16 text-[#2F5789]">

    <h2 class="text-2xl font-bold mb-3">
        Empowering Students Through Connection
    </h2>

    <p class="max-w-2xl mx-auto text-sm">
        MentorKampus is more than just a platform — it is a community built by students, 
        for students. Together, we create opportunities to learn, grow, and succeed.
    </p>

</section>

</body>
</html>