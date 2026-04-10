<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
<title>Courses - MentorCampus</title>

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
<section class="relative h-[400px] overflow-hidden">

    <img src="./image/wanita-belajar.jpg" 
         class="absolute w-full h-full object-cover z-0">

    <div class="absolute inset-0 bg-black/30 z-10"></div>

    <div class="relative z-20 px-12 pt-28 text-white">

        <h1 class="text-3xl font-semibold mb-6">
            Find Your Mentor & Start Learning
        </h1>

        <form method="GET">
      <div class="flex items-center bg-white rounded-full shadow-lg px-4 py-2 w-[600px]">

        <svg xmlns="http://www.w3.org/2000/svg" 
        class="w-5 h-5 text-gray-400 mr-2" 
        fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
        d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />

        </svg>

        <input type="text" name="search"
           value="<?= $_GET['search'] ?? '' ?>"
           placeholder="Search mentor, skill..." 
           class="w-full outline-none text-sm text-gray-600 bg-transparent">

        <button type="submit"
        class="bg-[#175BAF] text-white text-sm px-4 py-1.5 rounded-full hover:scale-105 transition">
        Search
        </button>

    </div>
    </form>

    </div>

</section>

<!-- MAIN -->
<section class="px-12 py-10 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- LEFT -->
    <div class="lg:col-span-2">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Recommended Mentors</h2>

            <select class="border rounded-lg px-3 py-1 text-sm">
                <option>Sort by</option>
                <option>Highest Rating</option>
                <option>Lowest Price</option>
            </select>
        </div>

        <div class="space-y-6">

        <?php
require 'config.php';

$search = $_GET['search'] ?? '';

// QUERY DATABASE
$query = "
SELECT mp.*, u.nama, u.semester, k.nama_kampus
FROM mentor_profiles mp
JOIN users u ON mp.id_user = u.id_user
JOIN kampus k ON mp.id_kampus = k.id_kampus
WHERE 1
";

// FILTER SEARCH
if (!empty($search)) {
    $query .= " AND (
        u.nama LIKE '%$search%' OR
        mp.spesialisasi LIKE '%$search%' OR
        mp.jurusan LIKE '%$search%'
    )";
}

// RANDOM RECOMMENDATION
$query .= " ORDER BY RAND() LIMIT 8";

$result = mysqli_query($conn, $query);
?>

<?php if (mysqli_num_rows($result) > 0): ?>
<?php while ($mentor = mysqli_fetch_assoc($result)): ?>

<div class="bg-white rounded-xl shadow p-5 flex gap-5 items-center hover:shadow-lg transition relative">

    <!-- FOTO -->
    <img src="image/wanita-belajar.jpg" 
         class="w-32 h-32 object-cover rounded-full">

    <!-- INFO -->
    <div class="flex-1 pb-10">

        <p class="text-sm text-gray-500">
            <?= $mentor['nama_kampus']; ?> • Semester <?= $mentor['semester']; ?>
        </p>

        <h3 class="font-semibold text-lg">
            <?= $mentor['nama']; ?>
        </h3>

        <div class="text-sm text-gray-500 mt-1">
            <?= $mentor['jurusan']; ?> • <?= $mentor['spesialisasi']; ?>
        </div>

        <div class="text-sm text-yellow-500 mt-1">
            ⭐ 4.8 • Active Mentor
        </div>

        <p class="text-green-600 text-sm mt-2 font-semibold">
            Available for booking
        </p>
    </div>

    <!-- BUTTONS -->
    <div class="absolute bottom-4 right-5 flex gap-2">

        <a href="mentor-profile.php?id=<?= $mentor['id_mentor']; ?>"
           class="bg-[#175BAF] text-white text-sm px-4 py-1.5 rounded-lg hover:scale-105 transition">
            Book
        </a>

        <a href="mentor-profile.php?id=<?= $mentor['id_mentor']; ?>"
           class="bg-[#175BAF] text-white text-sm px-4 py-1.5 rounded-lg hover:scale-105 transition">
            View Profile
        </a>

    </div>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="text-center text-gray-500 py-10">
    Mentor not found 😢
</div>

<?php endif; ?>

</div> 
</div> 

    <!-- RIGHT FILTER -->
    <div class="bg-white rounded-xl shadow p-4 self-start h-fit">

        <h3 class="font-semibold mb-3">Filter Mentor</h3>

        <div class="mb-3">
            <label class="text-sm">Major / Jurusan</label>
            <select class="w-full border rounded-lg px-2 py-1 text-sm mt-1">
                <option>All</option>
                <option>Teknik Informatika</option>
                <option>Sistem Informasi</option>
                <option>Teknik Komputer</option>
                <option>Ilmu Komputer</option>
                <option>Teknologi Informasi</option>
                <option>Teknik Elektro</option>
                <option>Teknik Industri</option>
                <option>Teknik Sipil</option>
                <option>Teknik Mesin</option>
                <option>Arsitektur</option>
                <option>Manajemen</option>
                <option>Akuntansi</option>
                <option>Bisnis Digital</option>
                <option>Ilmu Komunikasi</option>
                <option>DKV</option>
                <option>Psikologi</option>
                <option>Hukum</option>
                <option>Kedokteran</option>
                <option>Farmasi</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="text-sm">Subject</label>
            <input type="text" placeholder="Algoritma, Basis Data..."
                   class="w-full border rounded-lg px-2 py-1 text-sm mt-1">
        </div>

        <div class="mb-3">
            <label class="text-sm">Campus</label>
            <select class="w-full border rounded-lg px-2 py-1 text-sm mt-1">
                <option>All</option>
                <option>ITS</option>
                <option>UNAIR</option>
                <option>UB</option>
                <option>UI</option>
                <option>UGM</option>
                <option>UPN Veteran Jawa Timur</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="text-sm">Semester</label>
            <select class="w-full border rounded-lg px-2 py-1 text-sm mt-1">
                <option>All</option>
                <option>1 - 2</option>
                <option>3 - 4</option>
                <option>5 - 6</option>
                <option>7 - 8</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="text-sm">Gender</label>
            <select class="w-full border rounded-lg px-2 py-1 text-sm mt-1">
                <option>All</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </div>

        <button class="w-full bg-[#175BAF] text-white py-2 rounded-lg text-sm mt-2">
            Apply
        </button>

    </div>

</section>

</body>
</html>