<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

// proteksi admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// cek id
if (!isset($_GET['id'])) {
    header("Location: admin-approval.php");
    exit;
}

$id_calon = (int) $_GET['id'];

// ambil data calon mentor
$query = mysqli_query($conn, "
    SELECT cm.*, u.nama, u.email, k.nama_kampus 
    FROM calon_mentor cm
    JOIN users u ON cm.id_user = u.id_user
    JOIN kampus k ON cm.id_kampus = k.id_kampus
    WHERE cm.id_calon = $id_calon
") or die(mysqli_error($conn));

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

// ACTION 
if (isset($_GET['action'])) {

    $action = $_GET['action'];

    if ($action == 'accept') {

        // biar ga double insert
        $cek = mysqli_query($conn, "SELECT * FROM mentor_profiles WHERE id_user = {$data['id_user']}");

        if (mysqli_num_rows($cek) == 0) {
            mysqli_query($conn, "
                INSERT INTO mentor_profiles 
                (id_user, id_kampus, spesialisasi, biografi)
                VALUES 
                ('{$data['id_user']}', '{$data['id_kampus']}', '{$data['spesialisasi']}', '{$data['biografi']}')
            ") or die(mysqli_error($conn));
        }

        mysqli_query($conn, "
            UPDATE calon_mentor 
            SET status='accepted' 
            WHERE id_calon = $id_calon
        ") or die(mysqli_error($conn));

        mysqli_query($conn, "
            UPDATE users 
            SET id_role =2, role='mentor' 
            WHERE id_user = {$data['id_user']}
        ") or die(mysqli_error($conn));

        header("Location: admin-mentor-details.php?id=$id_calon");
        exit;
    }

    if ($action == 'reject') {

        mysqli_query($conn, "
            UPDATE calon_mentor 
            SET status='rejected' 
            WHERE id_calon = $id_calon
        ") or die(mysqli_error($conn));

        header("Location: admin-mentor-details.php?id=$id_calon");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentor Detail - MentorCampus</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-[#F5F7FA] pt-24">

<?php include 'navbar-admin.php'; ?>

<section class="px-10 py-10">

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-8">

    <h2 class="text-xl font-semibold mb-6 text-[#175BAF]">
        Mentor Application Detail
    </h2>

    <!-- INFORMASI -->
    <div class="space-y-3 text-sm">

        <p><span class="text-gray-500">Name:</span> <?= $data['nama']; ?></p>
        <p><span class="text-gray-500">Email:</span> <?= $data['email']; ?></p>
        <p><span class="text-gray-500">Campus:</span> <?= $data['nama_kampus']; ?></p>
        <p><span class="text-gray-500">Faculty:</span> <?= $data['fakultas']; ?></p>
        <p><span class="text-gray-500">Major:</span> <?= $data['jurusan']; ?></p>
        <p><span class="text-gray-500">Age:</span> <?= $data['usia']; ?></p>
        <p><span class="text-gray-500">Specialization:</span> <?= $data['spesialisasi']; ?></p>

    </div>

    <!-- BIO -->
    <div class="mt-6">
        <p class="text-sm text-gray-500 mb-1">Biography</p>
        <p class="text-sm text-gray-700 leading-relaxed">
            <?= $data['biografi']; ?>
        </p>
    </div>

    <!-- TRANSKRIP -->
    <div class="mt-6">
        <p class="text-sm text-gray-500 mb-1">Transcript</p>

        <a href="<?= $data['file_transkrip']; ?>" target="_blank"
           class="text-[#175BAF] text-sm underline hover:text-blue-700">
           View / Download Transcript
        </a>
    </div>

    <!-- STATUS -->
    <div class="mt-6">
        <p class="text-sm font-medium
        <?= $data['status'] == 'pending' ? 'text-yellow-500' : 
           ($data['status'] == 'accepted' ? 'text-green-500' : 'text-red-500'); ?>">
            Status: <?= ucfirst($data['status']); ?>
        </p>
    </div>

    <!-- BUTTON ACTION -->
    <?php if ($data['status'] == 'pending'): ?>
    <div class="mt-6 flex gap-3">

        <a href="?id=<?= $id_calon ?>&action=accept"
           class="bg-green-500 text-white px-5 py-2 rounded-lg text-sm hover:scale-105 transition">
           Accept
        </a>

        <a href="?id=<?= $id_calon ?>&action=reject"
           class="bg-red-500 text-white px-5 py-2 rounded-lg text-sm hover:scale-105 transition">
           Reject
        </a>

    </div>
    <?php endif; ?>

    <!-- BACK -->
    <div class="mt-8">
        <a href="admin-approval.php"
           class="text-sm text-[#175BAF] hover:underline">
           ← Back to list
        </a>
    </div>

</div>

</section>

</body>
</html>