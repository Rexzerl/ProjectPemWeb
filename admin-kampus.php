<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// TAMBAH KAMPUS
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kampus']);

    mysqli_query($conn, "
        INSERT INTO kampus (nama_kampus)
        VALUES ('$nama')
    ");

    header("Location: admin-kampus.php");
    exit;
}

// HAPUS
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    mysqli_query($conn, "
        DELETE FROM kampus WHERE id_kampus = $id
    ");

    header("Location: admin-kampus.php");
    exit;
}

// AMBIL DATA
$data = mysqli_query($conn, "
    SELECT * FROM kampus ORDER BY id_kampus DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Kampus</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-gray-100 pt-24">

<?php include 'navbar-admin.php'; ?>

<!-- HERO -->
<section class="relative h-[240px] flex items-center justify-center text-center">

    <div class="absolute inset-0 bg-[#175BAF]"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold">Manage Kampus</h1>
        <p class="text-sm opacity-90">Master data for campus</p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-6 py-12">

<div class="max-w-4xl mx-auto space-y-8">

    <!-- FORM TAMBAH -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="text-lg font-semibold text-[#175BAF] mb-4">
            Add New Campus
        </h2>

        <form method="POST" class="flex gap-3">

            <input type="text" name="nama_kampus" required
            placeholder="Nama kampus..."
            class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">

            <button type="submit" name="tambah"
            class="bg-[#175BAF] text-white px-5 py-2 rounded-lg hover:scale-105 transition">
                Tambah
            </button>

        </form>

    </div>

    <!-- LIST KAMPUS -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="text-lg font-semibold mb-4">
            Campus List
        </h2>

        <?php if (mysqli_num_rows($data) > 0): ?>

            <div class="space-y-4">

            <?php while($row = mysqli_fetch_assoc($data)): ?>

                <div class="flex justify-between items-center border p-4 rounded-xl hover:shadow transition">

                    <p class="font-medium">
                        <?= $row['nama_kampus']; ?>
                    </p>

                    <div class="flex gap-2">

                        <!-- EDIT BUTTON -->
                        <a href="admin-kampus-edit.php?id=<?= $row['id_kampus']; ?>"
                        class="bg-yellow-400 text-white px-3 py-1 rounded-lg text-sm hover:scale-105 transition">
                            Edit
                        </a>

                        <!-- DELETE -->
                        <a href="?hapus=<?= $row['id_kampus']; ?>"
                        onclick="return confirm('Hapus kampus ini?')"
                        class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:scale-105 transition">
                            Hapus
                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

            </div>

        <?php else: ?>

            <p class="text-center text-gray-500 py-6">
                Belum ada data kampus 😢
            </p>

        <?php endif; ?>

    </div>

</div>

</section>

</body>
</html>