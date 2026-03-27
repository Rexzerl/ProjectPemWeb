<?php
// 1. Harus ada session_start di baris paling atas!
session_start();

// 2. Cek apakah session login sudah ada
if (!isset($_SESSION['login'])) {
    // Jika belum login, paksa balik ke halaman login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center">
        <div class="mb-4">
            <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto">
                <span class="text-3xl">👤</span>
            </div>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang!</h1>
        <p class="text-gray-600 mt-2">Halo, <span class="font-bold text-blue-600"><?php echo $_SESSION['nama']; ?></span></p>
        
        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-700">✅ Login Berhasil menggunakan Session</p>
        </div>

        <div class="mt-8">
            <a href="logout.php" class="inline-block w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl transition duration-300">
                Keluar (Logout)
            </a>
        </div>
    </div>

</body>
</html>