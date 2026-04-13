<?php
session_start();
require 'config.php';

// CEK LOGIN & ROLE
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'mentor') {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// AMBIL ID MENTOR
$qMentor = mysqli_query($conn, "SELECT id_mentor FROM mentor_profiles WHERE id_user = $id_user");
$mentor = mysqli_fetch_assoc($qMentor);

if (!$mentor) {
    die("Data mentor tidak ditemukan");
}

$id_mentor = $mentor['id_mentor'];

// AMBIL DATA BOOKING
$data = mysqli_query($conn, "
SELECT b.*, 
       u.nama,
       u.foto_profil,
       u.gender,
       u.semester,
       mp.jurusan,
       k.nama_kampus,
       ms.tanggal,
       ms.jam,
       ms.harga
FROM booking b
JOIN users u ON b.id_student = u.id_user
JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
JOIN mentor_profiles mp ON ms.id_mentor = mp.id_mentor
JOIN kampus k ON mp.id_kampus = k.id_kampus
WHERE ms.id_mentor = $id_mentor
AND b.status = 'ongoing'
ORDER BY ms.tanggal DESC, ms.jam DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentor Booking - MentorCampus</title>

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

    <img src="image/cowobelajar.jpg" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/70"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Your Bookings</h1>
        <p class="text-sm">Students who booked your sessions 🎓</p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-6 py-10">

<div class="max-w-5xl mx-auto">

    <h2 class="text-xl font-semibold text-[#175BAF] mb-6">
        Booking List
    </h2>

    <?php if (mysqli_num_rows($data) > 0): ?>

        <div class="space-y-5">

        <?php while($row = mysqli_fetch_assoc($data)): ?>

            <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition flex flex-col md:flex-row md:items-center gap-5">

    <!-- FOTO -->
    <?php if (!empty($row['foto_profil']) && file_exists($row['foto_profil'])): ?>
        <img src="<?= $row['foto_profil']; ?>" 
             class="w-20 h-20 rounded-full object-cover shadow">
    <?php else: ?>
        <div class="w-20 h-20 rounded-full bg-[#B6DCFF] flex items-center justify-center text-xl font-bold text-[#175BAF]">
            <?= strtoupper(substr($row['nama'], 0, 1)); ?>
        </div>
    <?php endif; ?>

    <!-- INFO -->
    <div class="flex-1">
        <p class="font-semibold text-lg"><?= $row['nama']; ?></p>

        <p class="text-sm text-gray-500">
            <?= $row['nama_kampus']; ?> • <?= $row['jurusan']; ?>
        </p>

        <p class="text-sm text-gray-500">
            Semester <?= !empty($row['semester']) ? $row['semester'] : '-' ?> • 
            <?= !empty($row['gender']) ? ucfirst($row['gender']) : '-' ?>
        </p>
    </div>

    <!-- JADWAL + HARGA -->
    <div class="text-right min-w-[140px]">
        
        <p class="text-sm text-gray-500">
            <?= date('d M Y', strtotime($row['tanggal'])) ?>
        </p>

        <p class="text-sm text-gray-500 mb-1">
            <?= date('H:i', strtotime($row['jam'])) ?> WIB
        </p>

        <p class="text-lg font-bold text-[#175BAF]">
            Rp <?= number_format($row['harga'], 0, ',', '.') ?>
        </p>

        <span class="text-xs px-3 py-1 rounded-full inline-block mt-1
        <?=
            ($row['status'] == 'completed') ? 'bg-green-100 text-green-600' :
            (($row['status'] == 'ongoing') ? 'bg-yellow-100 text-yellow-600' :
            'bg-gray-200 text-gray-600')
        ?>">
            <?= ucfirst($row['status']); ?>
        </span>
    </div>

    <!-- BUTTON -->
    <div>
        <button class="bg-[#175BAF] text-white px-4 py-2 rounded-lg text-sm hover:scale-105 transition">
            Hubungi Student
        </button>
    </div>

</div>

        <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="bg-white p-10 rounded-2xl shadow text-center">
            <p class="text-gray-500">Belum ada booking 😢</p>
        </div>

    <?php endif; ?>

</div>

</section>

</body>
</html>