<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
<title>Courses - MentorKampus</title>

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


<!-- HERO -->
<section class="relative h-[400px] overflow-hidden">

    <!-- GAMBAR -->
    <img src="./image/wanita-belajar.jpg" 
         class="absolute w-full h-full object-cover z-0">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/30 z-10"></div>

    <!-- TEXT -->
    <div class="relative z-20 px-12 pt-28 text-white">

    <h1 class="text-3xl font-semibold mb-6">
        Online Courses on Design and Development
    </h1>

    <!-- SEARCH BAR -->
    <div class="max-w-xl">

        <div class="flex items-center bg-white rounded-full shadow-lg px-4 py-2">

            <!-- ICON -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5 text-gray-400 mr-2" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
            </svg>

            <!-- INPUT -->
            <input type="text" 
                   placeholder="Search courses..." 
                   class="w-full outline-none text-sm text-gray-600 bg-transparent">

            <!-- BUTTON -->
            <button class="bg-[#175BAF] text-white text-sm px-4 py-1.5 rounded-full hover:scale-105 transition">
                Search
            </button>

        </div>

    </div>

</div>

</section>

<!-- RECOMMENDATION -->
<section class="px-12 py-10">

    <h2 class="text-xl font-semibold mb-6">Recommendation</h2>

    <!-- CARD LIST -->
    <div class="space-y-6">

        <?php for ($i = 0; $i < 3; $i++): ?>
        <div class="bg-white rounded-xl shadow p-5 flex gap-5 items-center">

            <!-- IMAGE -->
            <img src="image/wanita-belajar.jpg" class="w-40 h-28 object-cover rounded-lg">

            <!-- CONTENT -->
            <div class="flex-1">
                <p class="text-sm text-gray-500">by MentorKampus</p>

                <h3 class="font-semibold text-lg">
                    Create an LMS Website With LearnPress
                </h3>

                <div class="text-sm text-gray-500 mt-1">
                    2 Weeks • 156 Students • All Levels • 20 Lessons
                </div>

                <p class="text-green-600 text-sm mt-2 font-semibold">
                    Free
                </p>
            </div>

            <!-- BUTTON -->
            <a href="#" class="text-blue-500 text-sm font-medium">
                View More
            </a>

        </div>
        <?php endfor; ?>

    </div>

    <!-- PAGINATION -->
    <div class="flex justify-center mt-10 gap-3 text-sm">
        <span class="px-3 py-1 bg-black text-white rounded-full">1</span>
        <span class="px-3 py-1 bg-gray-200 rounded-full">2</span>
        <span class="px-3 py-1 bg-gray-200 rounded-full">3</span>
    </div>

</section>

</body>
</html>