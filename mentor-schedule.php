<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

// cek login + role mentor
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'mentor') {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// ambil id_mentor
$qMentor = mysqli_query($conn, "SELECT id_mentor FROM mentor_profiles WHERE id_user = $id_user");
$mentor = mysqli_fetch_assoc($qMentor);

if (!$mentor) {
    die("Data mentor tidak ditemukan");
}

$id_mentor = $mentor['id_mentor'];

// ================= TAMBAH JADWAL =================
if (isset($_POST['tambah'])) {

    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];

    mysqli_query($conn, "
        INSERT INTO mentor_schedule (id_mentor, tanggal, jam, status)
        VALUES ('$id_mentor', '$tanggal', '$jam', 'available')
    ");

    header("Location: mentor-schedule.php");
    exit;
}

// ================= HAPUS =================
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query($conn, "
        DELETE FROM mentor_schedule 
        WHERE id_schedule = $id AND id_mentor = $id_mentor
    ");

    header("Location: mentor-schedule.php");
    exit;
}

// ================= AMBIL DATA =================
$data = mysqli_query($conn, "
    SELECT * FROM mentor_schedule 
    WHERE id_mentor = $id_mentor 
    ORDER BY tanggal ASC, jam ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Schedule - MentorCampus</title>

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
<section class="relative h-[260px] overflow-hidden flex items-center justify-center text-center">

    <img src="image/wanita-belajar.jpg" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/70"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Manage Your Schedule</h1>
        <p class="text-sm">Set your availability so students can book you 📅</p>
    </div>

</section>

<!-- MAIN -->
<section class="px-6 py-12">

<div class="max-w-4xl mx-auto space-y-8">

    <!-- FORM TAMBAH -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-lg font-semibold text-[#175BAF] mb-4">
            Add New Schedule
        </h2>

        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

            <div>
                <label class="text-sm text-gray-600">Date</label>
                <input type="date" name="tanggal" required
                class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">
            </div>

            <div>
                <label class="text-sm text-gray-600">Time</label>
                <input type="time" name="jam" required
                class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">
            </div>

            <button type="submit" name="tambah"
            class="bg-[#175BAF] text-white py-2 rounded-lg hover:scale-105 transition">
            Add
            </button>

        </form>
    </div>

    <!-- LIST JADWAL -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-lg font-semibold mb-4">
            Your Schedule
        </h2>

        <?php if (mysqli_num_rows($data) > 0): ?>

            <div class="space-y-4">

            <?php while ($row = mysqli_fetch_assoc($data)): ?>

                <div class="flex justify-between items-center border p-4 rounded-xl hover:shadow transition">

                    <div>
                        <p class="font-medium">
                            <?= date('d M Y', strtotime($row['tanggal'])) ?>
                        </p>
                        <p class="text-sm text-gray-500">
                            <?= date('H:i', strtotime($row['jam'])) ?> WIB
                        </p>
                    </div>

                    <div class="flex items-center gap-3">

                        <span class="text-xs px-3 py-1 rounded-full
                        <?= ($row['status'] == 'available') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>

                        <?php if ($row['status'] == 'available'): ?>
                        <a href="?hapus=<?= $row['id_schedule'] ?>"
                        onclick="return confirm('Hapus jadwal ini?')"
                        class="text-sm bg-red-500 text-white px-3 py-1 rounded-lg hover:scale-105 transition">
                            Delete
                        </a>
                        <?php endif; ?>

                    </div>

                </div>

            <?php endwhile; ?>

            </div>

        <?php else: ?>

            <p class="text-center text-gray-500 py-6">
                Belum ada jadwal 😢
            </p>

        <?php endif; ?>

    </div>

</div>

</section>

</body>
</html>