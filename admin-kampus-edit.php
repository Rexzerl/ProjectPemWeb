<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// ambil data lama
$q = mysqli_query($conn, "SELECT * FROM kampus WHERE id_kampus = $id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data tidak ditemukan");
}

// update
if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_kampus']);

    mysqli_query($conn, "
        UPDATE kampus 
        SET nama_kampus = '$nama'
        WHERE id_kampus = $id
    ");

    header("Location: admin-kampus.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Kampus</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow w-full max-w-md">

    <h2 class="text-xl font-bold text-[#175BAF] mb-4 text-center">
        Edit Kampus
    </h2>

    <form method="POST" class="space-y-4">

        <input type="text" name="nama_kampus"
        value="<?= $data['nama_kampus']; ?>"
        class="w-full px-4 py-2 border rounded-lg">

        <button type="submit" name="update"
        class="w-full bg-[#175BAF] text-white py-2 rounded-lg">
            Update
        </button>

        <a href="admin-kampus.php"
        class="block text-center text-sm text-gray-500">
            ← Kembali
        </a>

    </form>

</div>

</body>
</html>