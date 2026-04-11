<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

// cek login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// ambil id mentor dari URL
if (!isset($_GET['id_mentor'])) {
    die("Mentor tidak ditemukan");
}

$id_mentor = $_GET['id_mentor'];

// ambil data mentor
$qMentor = mysqli_query($conn, "
    SELECT u.nama, mp.spesialisasi 
    FROM mentor_profiles mp
    JOIN users u ON mp.id_user = u.id_user
    WHERE mp.id_mentor = $id_mentor
");

$mentor = mysqli_fetch_assoc($qMentor);

// ================= BOOKING =================
if (isset($_GET['book'])) {

    $id_schedule = $_GET['book'];

    // ubah status jadi booked
    mysqli_query($conn, "
        UPDATE mentor_schedule 
        SET status = 'booked'
        WHERE id_schedule = $id_schedule
    ");

    header("Location: booking.php?id_mentor=$id_mentor&success=1");
    exit;
}

// ================= AMBIL JADWAL =================
$schedule = mysqli_query($conn, "
    SELECT * FROM mentor_schedule 
    WHERE id_mentor = $id_mentor AND status = 'available'
    ORDER BY tanggal ASC, jam ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Mentor</title>

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
<section class="relative h-[260px] flex items-center justify-center text-center">

    <img src="image/wanita-belajar.jpg" class="absolute w-full h-full object-cover">
    <div class="absolute inset-0 bg-[#175BAF]/70"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold">Book Your Mentor</h1>
        <p class="text-sm mt-2"><?= $mentor['nama']; ?> • <?= $mentor['spesialisasi']; ?></p>
    </div>

</section>

<!-- MAIN -->
<section class="px-6 py-12">

<div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow">

<h2 class="text-lg font-semibold mb-6 text-[#175BAF]">
Available Schedule
</h2>

<?php if (isset($_GET['success'])): ?>
<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
    Booking berhasil 🎉
</div>
<?php endif; ?>

<?php if (mysqli_num_rows($schedule) > 0): ?>

<div class="space-y-4">

<?php while ($row = mysqli_fetch_assoc($schedule)): ?>

<div class="flex justify-between items-center border p-4 rounded-xl hover:shadow transition">

    <div>
        <p class="font-medium">
            <?= date('d M Y', strtotime($row['tanggal'])) ?>
        </p>
        <p class="text-sm text-gray-500">
            <?= date('H:i', strtotime($row['jam'])) ?> WIB
        </p>
    </div>

    <a href="?id_mentor=<?= $id_mentor ?>&book=<?= $row['id_schedule'] ?>"
       onclick="return confirm('Yakin mau booking jadwal ini?')"
       class="bg-[#175BAF] text-white px-4 py-2 rounded-lg text-sm hover:scale-105 transition">
       Book
    </a>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<p class="text-center text-gray-500 py-6">
   Anda telah terjadwal!
   Silahkan hubungi mentor Anda untuk berkomunikasi lebih lanjut
</p>

<?php endif; ?>

</div>

</section>

</body>
</html>