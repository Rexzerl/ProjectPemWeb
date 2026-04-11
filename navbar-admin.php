<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil nama file sekarang (buat menu aktif)
$current = basename($_SERVER['PHP_SELF']);

// Ambil inisial nama (biar ga error kalau belum ada session)
$initial = isset($_SESSION['nama']) ? strtoupper(substr($_SESSION['nama'], 0, 1)) : 'U';
?>

<nav class="w-full bg-white shadow-sm px-10 py-4 flex items-center justify-between fixed top-0 left-0 z-50">

    <!-- LOGO -->
    <div class="flex items-center">
        <img src="image/logo.png" class="w-[170px]" alt="Logo">
    </div>

    <!-- MENU -->
    <ul class="flex items-center gap-8 text-sm font-medium text-gray-600">

    <li>
        <a href="admin-dashboard.php"
           class="<?= ($current == 'admin-dashboard.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
           Home
        </a>
    </li>

    <li>
        <a href="admin-approval.php"
           class="<?= ($current == 'admin-approval.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
           Approval Mentor
        </a>
    </li>

    <li>
        <a href="admin-users.php"
           class="<?= ($current == 'admin-users.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
           Users
        </a>
    </li>

    <li>
        <a href="admin-mentor.php"
           class="<?= ($current == 'admin-mentor.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
           Mentor
        </a>
    </li>

</ul>

    <!-- RIGHT SIDE -->
    <div class="flex items-center gap-4">

    <!-- LOGOUT -->
    <a href="logout.php" 
       class="bg-[#B6DCFF] text-[#175BAF] px-4 py-2 rounded-full text-sm font-medium hover:scale-105 transition">
       Logout
    </a>

    <!-- AVATAR -->
    <div class="w-9 h-9 rounded-full bg-[#B6DCFF] flex items-center justify-center">
        <span class="text-sm font-semibold text-[#175BAF]">
            <?= $initial; ?>
        </span>
    </div>

    </div>

</nav>