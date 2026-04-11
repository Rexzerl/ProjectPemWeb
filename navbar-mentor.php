<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil nama file sekarang
$current = basename($_SERVER['PHP_SELF']);

// Ambil inisial nama
$initial = isset($_SESSION['nama']) ? strtoupper(substr($_SESSION['nama'], 0, 1)) : 'U';

// Ambil role
$role = $_SESSION['role'] ?? 'guest';
?>

<nav class="w-full bg-white shadow-sm px-10 py-4 flex items-center justify-between fixed top-0 left-0 z-50">

    <!-- LOGO -->
    <div class="flex items-center">
        <img src="image/logo.png" class="w-[170px]" alt="Logo">
    </div>

    <!-- MENU -->
    <ul class="flex items-center gap-8 text-sm font-medium text-gray-600">

        <li>
            <a href="dashboard.php"
               class="<?= ($current == 'dashboard.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               Home
            </a>
        </li>

        <li>
            <a href="courses.php"
               class="<?= ($current == 'courses.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               Courses
            </a>
        </li>

        <li>
            <a href="about.php"
               class="<?= ($current == 'about.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               About Us
            </a>
        </li>

        <li>
            <a href="faq.php"
               class="<?= ($current == 'faq.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               FAQ
            </a>
        </li>

        <li>
            <a href="profile.php"
               class="<?= ($current == 'profile.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               Profil
            </a>
        </li>

        <!-- 🔥 TAMBAHAN KHUSUS MENTOR -->
        <?php if ($role == 'mentor'): ?>

        <li>
            <a href="mentor-schedule.php"
               class="<?= ($current == 'mentor-schedule.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               Schedule
            </a>
        </li>

        <li>
            <a href="mentor-booking.php"
               class="<?= ($current == 'mentor-booking.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               Booking
            </a>
        </li>

        <li>
            <a href="mentor-history.php"
               class="<?= ($current == 'mentor-history.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">
               History
            </a>
        </li>

        <?php endif; ?>

    </ul>

    <!-- RIGHT SIDE -->
    <div class="flex items-center gap-4">

        <!-- ❗ HANYA MUNCUL KALAU BUKAN MENTOR -->
        <?php if ($role != 'mentor'): ?>
        <a href="mentor-register.php" 
           class="bg-[#175BAF] text-white px-4 py-2 rounded-full text-sm font-medium hover:scale-105 transition">
           Become Mentor
        </a>
        <?php endif; ?>

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