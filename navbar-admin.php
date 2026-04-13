<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil nama file sekarang (buat menu aktif)
$current = basename($_SERVER['PHP_SELF']);

// Ambil data asli dari session
$nama_user = $_SESSION['nama'] ?? 'Admin';
$email_user = $_SESSION['email'] ?? 'admin@mentorcampus.id';
?>

<style>
    /* Dropdown Design: Clean & Square */
    #adminDropdown.hidden { display: none; }
    
    .dropdown-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 4px; /* Kotak tegas */
        width: 240px;
        animation: fadeIn 0.1s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        color: #4b5563;
        font-size: 13px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .menu-item:hover {
        background-color: #f3f4f6;
        color: #175BAF;
    }
</style>

<nav class="w-full bg-white shadow-sm px-10 py-4 flex items-center justify-between fixed top-0 left-0 z-50">

    <div class="flex items-center">
        <img src="image/logo.png" class="w-[170px]" alt="Logo">
    </div>

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

    <div class="flex items-center gap-4 relative" id="adminArea">

        <a href="logout.php" 
           class="bg-[#B6DCFF] text-[#175BAF] px-4 py-2 rounded-full text-sm font-medium hover:scale-105 transition">
            Logout
        </a>

        <button onclick="toggleAdminMenu()" class="w-9 h-9 flex flex-col items-center justify-center gap-1.5 hover:bg-gray-100 rounded-md transition focus:outline-none">
            <span class="w-5 h-0.5 bg-[#175BAF]"></span>
            <span class="w-5 h-0.5 bg-[#175BAF]"></span>
            <span class="w-5 h-0.5 bg-[#175BAF]"></span>
        </button>

        <div id="adminDropdown" class="hidden dropdown-box absolute right-0 top-[110%] z-[60]">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <p class="text-sm font-bold text-gray-800 truncate"><?= $nama_user ?></p>
                <p class="text-[11px] text-gray-500 truncate"><?= $email_user ?></p>
            </div>

            <div class="py-1">
                <a href="admin-profile.php" class="menu-item">
                    <i class="fas fa-user-circle mr-3 opacity-50"></i> Akun Saya
                </a>
                <a href="admin-settings.php" class="menu-item">
                    <i class="fas fa-cog mr-3 opacity-50"></i> Pengaturan
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <a href="logout.php" class="menu-item text-red-600">
                    <i class="fas fa-sign-out-alt mr-3 opacity-50"></i> Keluar
                </a>
            </div>
        </div>

    </div>

</nav>

<script>
    function toggleAdminMenu() {
        const menu = document.getElementById('adminDropdown');
        menu.classList.toggle('hidden');
    }

    // Tutup dropdown jika klik di luar area
    window.addEventListener('click', function(e) {
        const area = document.getElementById('adminArea');
        const menu = document.getElementById('adminDropdown');
        if (area && !area.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>