<?php
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
    <title>MentorCampus Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Lexend', sans-serif; }
        .hero-overlay {
            background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6));
        }
    </style>
</head>

<body class="bg-[#F5F7FA] pt-16">

<?php include 'navbar.php'; ?>

<section class="relative h-[500px] flex items-center justify-center overflow-hidden">
    <img src="image/pena.jpg" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 hero-overlay"></div>

    <div class="relative z-10 text-center px-6 max-w-3xl">
        <span class="inline-block px-4 py-1 bg-blue-500/30 border border-blue-400 rounded-full text-xs font-bold text-blue-100 uppercase tracking-widest mb-4">
            Welcome back, <?= $_SESSION['nama']; ?> 👋
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
            Temukan Mentor <br> <span class="text-blue-400">Terbaikmu</span> Sekarang.
        </h1>
        <p class="text-blue-50 text-base md:text-lg mb-8 opacity-90">
            Akses ribuan mentor mahasiswa yang siap membantumu menguasai materi kuliah dengan cara yang lebih seru dan mudah dipahami.
        </p>
        <button onclick="window.location.href='courses.php'"
            class="bg-[#175BAF] text-white px-10 py-4 rounded-full font-bold shadow-2xl hover:bg-blue-600 transition transform hover:scale-105 active:scale-95">
            Mulai Belajar Sekarang
        </button>
    </div>
</section>

<div class="max-w-6xl mx-auto px-6 -mt-10 relative z-20">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">12</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Kelas Saya</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">150+</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Mentor Aktif</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">4.8</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Rating Kepuasan</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">24/7</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Dukungan Belajar</p>
        </div>
    </div>
</div>

<section class="max-w-6xl mx-auto px-6 py-20">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h2 class="text-3xl font-bold text-[#2F5789]">Kategori Populer</h2>
            <p class="text-gray-500 mt-2 text-sm">Pilih bidang yang ingin kamu kuasai hari ini.</p>
        </div>
        <a href="courses.php" class="text-[#175BAF] font-bold text-sm hover:underline">Lihat Semua →</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 transition-colors">
                <i class="fas fa-code text-2xl text-blue-500 group-hover:text-white"></i>
            </div>
            <h4 class="font-bold text-[#2F5789]">Programming</h4>
        </div>
        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-500 transition-colors">
                <i class="fas fa-pen-nib text-2xl text-orange-500 group-hover:text-white"></i>
            </div>
            <h4 class="font-bold text-[#2F5789]">Design UI/UX</h4>
        </div>
        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                <i class="fas fa-calculator text-2xl text-green-500 group-hover:text-white"></i>
            </div>
            <h4 class="font-bold text-[#2F5789]">Mathematics</h4>
        </div>
        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500 transition-colors">
                <i class="fas fa-language text-2xl text-purple-500 group-hover:text-white"></i>
            </div>
            <h4 class="font-bold text-[#2F5789]">Languages</h4>
        </div>
    </div>
</section>

<section class="bg-white py-24 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-4xl font-extrabold text-[#2F5789] leading-tight mb-6">Kenapa Belajar di <span class="text-[#175BAF]">MentorCampus?</span></h2>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-check text-[#175BAF]"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#2F5789]">Peer-to-Peer Learning</h4>
                        <p class="text-gray-500 text-sm">Belajar langsung dari teman sebaya yang mengerti bahasa dan cara belajarmu.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-wallet text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#2F5789]">Harga Terjangkau</h4>
                        <p class="text-gray-500 text-sm">Sistem pembayaran yang transparan dan bersahabat bagi kantong mahasiswa.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative">
            <div class="aspect-video bg-blue-100 rounded-[2rem] overflow-hidden shadow-2xl rotate-3">
                <img src="image/wanita-belajar.jpg" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl flex items-center gap-4">
                <div class="bg-yellow-400 w-12 h-12 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase">Mentor Favorit</p>
                    <p class="font-bold text-[#2F5789]">Edo Pradiga</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-[#F5F7FA] py-12 text-center border-t">
    <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.4em]">&copy; 2026 MentorCampus. Created for Excellence.</p>
</footer>

</body>
</html>