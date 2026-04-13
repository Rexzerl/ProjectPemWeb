<?php
session_start();
require 'config.php';

// cek role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// ambil data mentor
$data = mysqli_query($conn, "
SELECT mp.*, u.nama, u.email, u.foto_profil
FROM mentor_profiles mp
JOIN users u ON mp.id_user = u.id_user
ORDER BY mp.id_mentor DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Mentor</title>

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

<!-- HERO -->
<section class="relative h-[260px] flex items-center justify-center text-center overflow-hidden">

    <img src="image/wanita-belajar.jpg" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/80"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Mentor Management</h1>
        <p class="text-sm opacity-90">Manage all mentors in the platform</p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-6 py-12">

<div class="max-w-6xl mx-auto">

    <h2 class="text-xl font-semibold text-[#175BAF] mb-6">
        Mentor List
    </h2>

    <?php if ($data && mysqli_num_rows($data) > 0): ?>

        <div class="grid md:grid-cols-2 gap-6">

        <?php while($row = mysqli_fetch_assoc($data)): ?>

            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">

                <div class="flex items-center gap-4">

                    <!-- FOTO -->
                    <?php if (!empty($row['foto_profil']) && file_exists($row['foto_profil'])): ?>
                        <img src="<?= $row['foto_profil']; ?>" 
                             class="w-16 h-16 rounded-full object-cover">
                    <?php else: ?>
                        <div class="w-16 h-16 rounded-full bg-[#B6DCFF] flex items-center justify-center text-lg font-bold text-[#175BAF]">
                            <?= strtoupper(substr($row['nama'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>

                    <!-- INFO -->
                    <div>
                        <p class="font-semibold text-lg text-[#2F5789]">
                            <?= $row['nama']; ?>
                        </p>
                        <p class="text-sm text-gray-500">
                            <?= $row['email']; ?>
                        </p>
                    </div>

                </div>

                <!-- DETAIL -->
                <div class="mt-4 space-y-1 text-sm text-gray-600">

                    <p><span class="font-medium">Spesialisasi:</span> 
                        <?= $row['spesialisasi'] ?? '-' ?>
                    </p>

                    <p><span class="font-medium">Pengalaman:</span> 
                        <?= $row['pengalaman'] ?? '-' ?>
                    </p>

                    <p><span class="font-medium">Tarif:</span> 
                        Rp <?= number_format($row['harga'] ?? 0, 0, ',', '.') ?>
                    </p>

                </div>

                <!-- ACTION -->
                <div class="mt-5 flex gap-2">

                    <button class="flex-1 bg-[#175BAF] text-white py-2 rounded-lg text-sm hover:scale-105 transition">
                        Detail
                    </button>

                    <button class="flex-1 bg-red-500 text-white py-2 rounded-lg text-sm hover:scale-105 transition">
                        Hapus
                    </button>

                </div>

            </div>

        <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="bg-white p-10 rounded-2xl shadow text-center">
            <p class="text-gray-500">Belum ada mentor 😢</p>
        </div>

    <?php endif; ?>

</div>

</section>

</body>
</html>