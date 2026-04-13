<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$query = "
SELECT mp.*, u.nama, u.email, u.foto_profil, u.semester, k.nama_kampus
FROM mentor_profiles mp
JOIN users u ON mp.id_user = u.id_user
JOIN kampus k ON mp.id_kampus = k.id_kampus
WHERE mp.id_mentor = $id
";

$result = mysqli_query($conn, $query);
$mentor = mysqli_fetch_assoc($result);

if (!$mentor) {
    echo "Mentor tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentor Detail</title>

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
<section class="relative h-[280px]">

    <img src="image/priabelajar.jpg" 
         class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/40"></div>

    <div class="absolute bottom-6 left-12 text-white">
        <h1 class="text-3xl font-semibold">
            <?= $mentor['nama']; ?>
        </h1>
        <p class="text-sm">
            <?= $mentor['jurusan']; ?> • <?= $mentor['spesialisasi']; ?>
        </p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-12 py-10 grid md:grid-cols-3 gap-8">

    <!-- LEFT PROFILE -->
    <div class="bg-white rounded-2xl shadow p-6 text-center">

        <?php if (!empty($mentor['foto_profil']) && $mentor['foto_profil'] != 'default.jpg'): ?>
            <img src="<?= $mentor['foto_profil'] ?>" 
                 class="w-28 h-28 mx-auto rounded-full object-cover shadow">
        <?php else: ?>
            <div class="w-28 h-28 mx-auto rounded-full bg-[#B6DCFF] 
            flex items-center justify-center text-3xl font-bold text-[#175BAF]">
                <?= strtoupper(substr($mentor['nama'], 0, 1)); ?>
            </div>
        <?php endif; ?>

        <h2 class="mt-4 font-semibold text-lg">
            <?= $mentor['nama']; ?>
        </h2>

        <p class="text-gray-500 text-sm">
            <?= $mentor['nama_kampus']; ?>
        </p>

        <p class="text-gray-400 text-sm">
            Semester <?= $mentor['semester']; ?>
        </p>

        <a href="booking.php?id_mentor=<?= $mentor['id_mentor']; ?>"
        class="mt-5 inline-block bg-[#175BAF] text-white px-6 py-2 rounded-full text-sm hover:scale-105 transition">
            Book Session
        </a>

    </div>

    <!-- RIGHT DETAIL -->
    <div class="md:col-span-2 space-y-6">

        <!-- BIO -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold text-[#2F5789] mb-3">
                Biography
            </h3>

            <p class="text-sm text-gray-600 leading-relaxed">
                <?= !empty($mentor['biografi']) ? $mentor['biografi'] : 'No biography yet.' ?>
            </p>
        </div>

        <!-- EXPERIENCE -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold text-[#2F5789] mb-3">
                Experience
            </h3>

            <p class="text-sm text-gray-600 leading-relaxed">
                <?= !empty($mentor['pengalaman']) ? $mentor['pengalaman'] : 'No experience added.' ?>
            </p>
        </div>

        <!-- CV -->
        <?php if (!empty($mentor['cv'])): ?>
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold text-[#2F5789] mb-3">
                Curriculum Vitae
            </h3>

            <a href="/ProjectPemWeb/<?= $mentor['cv']; ?>" target="_blank"
class="text-blue-500 text-sm underline">
    View CV
</a>
        </div>
        <?php endif; ?>

    </div>

</section>

</body>
</html>