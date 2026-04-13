<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'mentor') {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];

$qMentor = mysqli_query($conn, "SELECT id_mentor FROM mentor_profiles WHERE id_user = $id_user");
$mentor = mysqli_fetch_assoc($qMentor);

if (!$mentor) {
    die("Data mentor tidak ditemukan");
}

$id_mentor = $mentor['id_mentor'];

// ambil semua review
$reviews = mysqli_query($conn, "
SELECT tr.rating, tr.komentar, tr.tgl_review
FROM transaksi_review tr
JOIN booking b ON tr.id_booking = b.id_booking
JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
WHERE ms.id_mentor = $id_mentor
ORDER BY tr.id_review DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentor History</title>

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
<section class="relative h-[260px] flex items-center justify-center text-center overflow-hidden">

    <img src="image/priabelajar.jpg" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/80"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Student Reviews</h1>
        <p class="text-sm opacity-90">What your students say about you</p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-6 py-12">

<div class="max-w-4xl mx-auto">

    <?php if ($reviews && mysqli_num_rows($reviews) > 0): ?>

        <div class="space-y-6">

        <?php while($row = mysqli_fetch_assoc($reviews)): ?>

            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-3">

                    <!-- RATING -->
                    <div class="flex items-center gap-3">

                        <div class="text-yellow-400 text-lg">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= $row['rating'] ? '★' : '☆' ?>
                            <?php endfor; ?>
                        </div>

                        <span class="text-sm text-gray-500">
                            <?= $row['rating']; ?>/5
                        </span>

                    </div>

                    <!-- TANGGAL -->
                    <p class="text-xs text-gray-400">
                        <?= date('d M Y', strtotime($row['tgl_review'])) ?>
                    </p>

                </div>

                <!-- KOMENTAR -->
                <p class="text-gray-700 text-sm leading-relaxed">
                    <?= !empty($row['komentar']) ? $row['komentar'] : 'Tidak ada komentar.' ?>
                </p>

            </div>

        <?php endwhile; ?>

        </div>

    <?php else: ?>

        <!-- EMPTY -->
        <div class="bg-white p-10 rounded-2xl shadow text-center">

            <div class="text-5xl mb-3">💬</div>

            <p class="text-gray-500 font-medium">
                Belum ada review
            </p>

            <p class="text-gray-400 text-sm mt-1">
                Nanti komentar dari student akan muncul di sini
            </p>

        </div>

    <?php endif; ?>

</div>

</section>

</body>
</html>