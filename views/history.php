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
<title>History - MentorKampus</title>

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

<!-- HEADER -->
<section class="px-12 mb-6">
    <h1 class="text-2xl font-bold text-[#2F5789]">
        Your Learning History
    </h1>
    <p class="text-sm text-gray-500">
        Track all the courses and mentoring sessions you have taken.
    </p>
</section>

<!-- LIST -->
<section class="px-12 space-y-4">

    <?php for ($i = 0; $i < 5; $i++): ?>
    <div class="bg-white p-5 rounded-xl shadow flex items-center gap-5">

        <!-- IMAGE -->
        <img src="image/wanita-belajar.jpg" 
             class="w-32 h-20 object-cover rounded-lg">

        <!-- INFO -->
        <div class="flex-1">
            <h3 class="font-semibold text-[#2F5789]">
                UI/UX Design Mentoring
            </h3>

            <p class="text-sm text-gray-500">
                Mentor: John Doe • 2 Weeks
            </p>

            <p class="text-sm text-gray-400">
                Completed on: 12 March 2026
            </p>
        </div>

        <!-- STATUS -->
        <div class="text-sm">
            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full">
                Completed
            </span>
        </div>

        <!-- BUTTON -->
        <button class="text-blue-500 text-sm font-medium">
            View
        </button>

    </div>
    <?php endfor; ?>

</section>

</body>
</html>