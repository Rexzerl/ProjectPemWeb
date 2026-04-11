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
<title>Become Mentor - MentorCampus</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-[#F5F7FA] pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="relative h-[300px] overflow-hidden flex items-center justify-center text-center">

    <img src="image/priabelajar.jpg" 
         class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#B6DCFF]/80"></div>

    <div class="relative z-10 text-[#2F5789]">
        <h1 class="text-3xl font-bold mb-2">
            Become a Mentor
        </h1>
        <p class="text-sm">
            Share your knowledge and help other students grow
        </p>
    </div>

</section>

<!-- FORM -->
<section class="px-6 py-16">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm">

        <h2 class="text-xl font-semibold text-[#2F5789] mb-6 text-center">
            Mentor Registration Form
        </h2>

        <form method="POST" action="" class="space-y-5">

            <!-- NAME -->
            <div>
                <label class="text-sm text-gray-600">Full Name</label>
                <input type="text" name="name" required
                       class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#B6DCFF]">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email" name="email" required
                       class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#B6DCFF]">
            </div>

            <!-- SKILL -->
            <div>
                <label class="text-sm text-gray-600">Field / Skill</label>
                <input type="text" name="skill" placeholder="e.g. Web Development, UI/UX"
                       class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#B6DCFF]">
            </div>

            <!-- EXPERIENCE -->
            <div>
                <label class="text-sm text-gray-600">Experience</label>
                <textarea name="experience" rows="3"
                          class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#B6DCFF]"></textarea>
            </div>

            <!-- PRICE -->
            <div>
                <label class="text-sm text-gray-600">Price per Session (Optional)</label>
                <input type="number" name="price"
                       class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#B6DCFF]">
            </div>

            <!-- BUTTON -->
            <button type="submit" 
                    class="w-full bg-[#175BAF] text-white py-3 rounded-full font-medium hover:scale-105 hover:shadow-lg transition">
                Register as Mentor
            </button>

        </form>

    </div>

</section>

</body>
</html>