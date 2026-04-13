<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ambil halaman aktif
$current = basename($_SERVER['PHP_SELF']);

// ambil data asli dari session
$nama_user = $_SESSION['nama'] ?? 'User';
$email_user = $_SESSION['email'] ?? 'student@mentorcampus.id';

// ambil role
$role = $_SESSION['role'] ?? 'guest';
?>

<style>
    /* Dropdown Design: Clean, Sharp, & Professional */
    #userDropdown.hidden { display: none; }
    
    .dropdown-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 4px; /* Desain kotak tegas */
        width: 260px;
        animation: fadeIn 0.15s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #374151;
        font-size: 14px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .menu-item:hover {
        background-color: #f9fafb;
        color: #175BAF;
    }
</style>

<nav class="w-full bg-white shadow-sm px-10 py-4 flex items-center justify-between fixed top-0 left-0 z-50">

    <div class="flex items-center">
        <img src="image/logo.png" class="w-[170px]" alt="Logo">
    </div>

    <ul class="flex items-center gap-8 text-sm font-medium text-gray-600">
        <li>
            <a href="dashboard.php" class="<?= ($current == 'dashboard.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">Home</a>
        </li>
        <li>
            <a href="courses.php" class="<?= ($current == 'courses.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">Courses</a>
        </li>
        <li>
            <a href="about.php" class="<?= ($current == 'about.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">About Us</a>
        </li>
        <li>
            <a href="faq.php" class="<?= ($current == 'faq.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">FAQ</a>
        </li>
        <li>
            <a href="profile.php" class="<?= ($current == 'profile.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">Profil</a>
        </li>

        <?php if ($role == 'mentor'): ?>
        <li><a href="mentor-schedule.php" class="<?= ($current == 'mentor-schedule.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">Schedule</a></li>
        <li><a href="mentor-booking.php" class="<?= ($current == 'mentor-booking.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">Booking</a></li>
        <li><a href="mentor-history.php" class="<?= ($current == 'mentor-history.php') ? 'text-blue-500 font-semibold' : 'hover:text-blue-500' ?>">History</a></li>
        <?php endif; ?>
    </ul>

    <div class="flex items-center gap-4 relative" id="profileArea">

        <?php if ($role != 'mentor'): ?>
        <a href="mentor-register.php" class="bg-[#175BAF] text-white px-4 py-2 rounded-full text-sm font-medium hover:scale-105 transition">
            Become Mentor
        </a>
        <?php endif; ?>

        <a href="logout.php" class="bg-[#B6DCFF] text-[#175BAF] px-4 py-2 rounded-full text-sm font-medium hover:scale-105 transition">
            Logout
        </a>

        <button onclick="toggleDropdown()" class="w-9 h-9 flex flex-col items-center justify-center gap-1.5 hover:bg-gray-100 rounded-md transition focus:outline-none">
            <span class="w-5 h-0.5 bg-[#175BAF]"></span>
            <span class="w-5 h-0.5 bg-[#175BAF]"></span>
            <span class="w-5 h-0.5 bg-[#175BAF]"></span>
        </button>

        <div id="userDropdown" class="hidden dropdown-box absolute right-0 top-[110%] z-[60]">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <p class="text-sm font-bold text-gray-800 truncate"><?= $nama_user ?></p>
                <p class="text-[11px] text-gray-500 truncate"><?= $email_user ?></p>
            </div>

            <div class="py-1">
                <a href="profile.php" class="menu-item">
                    <svg class="w-4 h-4 mr-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Kelola Profil
                </a>
                <a href="index.php" class="menu-item">
                    <svg class="w-4 h-4 mr-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Akun
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <a href="logout.php" class="menu-item text-red-600 font-medium">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </a>
            </div>
        </div>

    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Klik di luar area profil untuk menutup dropdown
    window.addEventListener('click', function(e) {
        const profileArea = document.getElementById('profileArea');
        const dropdown = document.getElementById('userDropdown');
        if (profileArea && !profileArea.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>