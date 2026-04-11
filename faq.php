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
<title>FAQ - MentorCampus</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-gray-50 pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="px-12 py-12 text-center">
    <h1 class="text-3xl font-bold text-[#2F5789] mb-3">
        Frequently Asked Questions
    </h1>
    <p class="text-gray-500">
        Find answers to common questions about MentorCampus.
    </p>
</section>

<!-- CONTENT -->
<section class="px-12 py-10 flex flex-wrap gap-10 justify-center">

    <!-- FAQ LIST -->
    <div class="w-full md:w-[500px] space-y-4">

        <?php 
        $faqs = [
            ["Apa itu MentorCampus?", "MentorCampus adalah platform pembelajaran peer-to-peer yang menghubungkan mahasiswa dengan mentor dari sesama mahasiswa."],
            ["Bagaimana cara mendaftar?", "Anda dapat mendaftar melalui halaman Sign Up dengan mengisi data diri yang diperlukan."],
            ["Apakah mentor berbayar?", "Beberapa mentor gratis, namun sebagian lainnya memiliki biaya yang tetap terjangkau."],
            ["Apakah bisa memilih mentor?", "Ya, Anda dapat memilih mentor sesuai kebutuhan dan preferensi Anda."],
            ["Bagaimana sistem pembelajarannya?", "Pembelajaran dilakukan secara fleksibel, baik online maupun offline sesuai kesepakatan."]
        ];

        foreach ($faqs as $faq): ?>
        
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <!-- QUESTION -->
            <button onclick="toggleFAQ(this)" 
                class="w-full text-left p-4 font-medium text-[#2F5789] flex justify-between items-center">
                <?= $faq[0]; ?>
                <span class="text-xl">+</span>
            </button>

            <!-- ANSWER -->
            <div class="hidden px-4 pb-4 text-sm text-gray-500">
                <?= $faq[1]; ?>
            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <!-- IMAGE SIDE -->
    <div class="hidden md:block w-[350px]">
        <img src="image/anakbelajar.jpg" class="rounded-xl shadow">
    </div>

</section>

<script>
function toggleFAQ(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector("span");

    if (content.classList.contains("hidden")) {
        content.classList.remove("hidden");
        icon.innerText = "-";
    } else {
        content.classList.add("hidden");
        icon.innerText = "+";
    }
}
</script>

</body>
</html>