<?php
session_start();
require 'config.php';

// Perbaikan syntax di baris ini:
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Query Mentor (JOIN dengan profil dan status)
$query_mentor = "SELECT u.email, m.* FROM users u
                 INNER JOIN mentor_profiles m ON u.id_user = m.id_user";
$result_mentor = mysqli_query($conn, $query_mentor);
if (!$result_mentor) {
    die("Query Mentor Gagal: " . mysqli_error($conn));
}

// Query Student
$query_student = "SELECT u.email, s.* FROM users u
                  INNER JOIN student_profiles s ON u.id_user = s.id_user";
$result_student = mysqli_query($conn, $query_student);
if (!$result_student) {
    die("Query Student Gagal: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <nav class="bg-white shadow-sm border-b px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-600 italic">MentorCampus <span class="text-gray-400 font-normal text-sm">| Admin Panel</span></h1>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">Halo, <strong><?= $_SESSION['nama']; ?></strong></span>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition">Logout</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800">Manajemen Pengguna</h2>
            <p class="text-gray-500">Pantau dan kelola data Mentor serta Student yang terdaftar di sistem.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-10 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold"><i class="fas fa-chalkboard-teacher mr-2"></i> Data Mentor Terdaftar</h3>
                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded"><?= mysqli_num_rows($result_mentor); ?> Orang</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Kampus</th>
                            <th class="px-6 py-4">Spesialisasi</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php while($row = mysqli_fetch_assoc($result_mentor)) : ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium"><?= $row['nama_lengkap']; ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= $row['email']; ?></td>
                            <td class="px-6 py-4"><?= $row['nama_kampus'] ?? '-'; ?></td>
                            <td class="px-6 py-4"><span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs"><?= $row['spesialisasi']; ?></span></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $row['id_status_verif'] == 3 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= $row['nama_status_verif']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button class="text-blue-600 hover:underline text-sm">Detail</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold"><i class="fas fa-user-graduate mr-2"></i> Data Student Terdaftar</h3>
                <span class="bg-emerald-500 text-white text-xs px-2 py-1 rounded"><?= mysqli_num_rows($result_student); ?> Orang</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Kampus</th>
                            <th class="px-6 py-4">Semester</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php while($row = mysqli_fetch_assoc($result_student)) : ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium"><?= $row['nama_lengkap']; ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= $row['email']; ?></td>
                            <td class="px-6 py-4"><?= $row['nama_kampus'] ?? '-'; ?></td>
                            <td class="px-6 py-4 text-center"><?= $row['semester']; ?></td>
                            <td class="px-6 py-4">
                                <button class="text-emerald-600 hover:underline text-sm">Lihat Profil</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
