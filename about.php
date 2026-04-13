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
    <title>About Us - MentorCampus</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Lexend', sans-serif; }
        .hero-gradient {
            background: linear-gradient(to right, rgba(29, 98, 183, 0.8), rgba(29, 98, 183, 0.2));
        }
    </style>
</head>

<body class="bg-gray-50 pt-16">

<?php include 'navbar.php'; ?>

<section class="relative h-[550px] flex items-center px-6 md:px-20 overflow-hidden">
    <img src="image/mejabelajar.jpg" alt="Study Space" 
         class="absolute inset-0 w-full h-full object-cover">
    
    <div class="absolute inset-0 hero-gradient"></div>

    <div class="relative z-10 max-w-2xl text-white">
        <span class="inline-block px-4 py-1 bg-blue-500/30 border border-blue-400 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
            Our Story
        </span>
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
            Connecting Minds, <br> <span class="text-blue-300">Empowering</span> Futures.
        </h1>
        <p class="text-lg text-blue-50 leading-relaxed mb-8 opacity-90">
            MentorCampus adalah komunitas tempat mahasiswa saling berbagi ilmu, memecahkan kesulitan akademik, dan tumbuh bersama tanpa batasan formalitas yang kaku.
        </p>

        <a href="courses.php" 
           class="inline-flex items-center gap-3 bg-white text-[#1D62B7] px-8 py-4 rounded-full font-bold shadow-lg hover:bg-blue-50 transition transform hover:-translate-y-1 active:scale-95">
            Explore All Courses
            <i class="fas fa-arrow-right text-sm"></i>
        </a>
    </div>
</section>

<section class="relative z-20 -mt-12 px-6 md:px-20">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-500">
            <p class="text-3xl font-bold text-[#1D62B7]">500+</p>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">Active Students</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-400">
            <p class="text-3xl font-bold text-[#1D62B7]">120+</p>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">Verified Mentors</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-300">
            <p class="text-3xl font-bold text-[#1D62B7]">45+</p>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">Subject Categories</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-200">
            <p class="text-3xl font-bold text-[#1D62B7]">4.9</p>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">Average Rating</p>
        </div>
    </div>
</section>

<section class="px-6 md:px-20 py-24">
    <div class="grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-3xl font-bold text-[#2F5789] mb-6 border-l-4 border-blue-500 pl-4">Visi & Misi Kami</h2>
            <p class="text-gray-600 leading-relaxed mb-8">
                Kami percaya bahwa guru terbaik bagi seorang mahasiswa adalah mahasiswa lainnya yang baru saja melewati tantangan yang sama. Dengan pendekatan <span class="font-bold text-blue-600">Peer-to-Peer Learning</span>, kami menciptakan ruang belajar yang nyaman dan terjangkau.
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                    <i class="fas fa-check-circle text-blue-500 mb-2"></i>
                    <h4 class="font-bold text-sm text-[#2F5789]">Accessible</h4>
                    <p class="text-[11px] text-gray-500">Akses materi kapan saja dan di mana saja.</p>
                </div>
                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                    <i class="fas fa-wallet text-green-500 mb-2"></i>
                    <h4 class="font-bold text-sm text-[#2F5789]">Affordable</h4>
                    <p class="text-[11px] text-gray-500">Harga yang sangat bersahabat bagi mahasiswa.</p>
                </div>
            </div>
        </div>
        
        <div class="relative">
            <div class="w-full h-[350px] rounded-3xl bg-blue-200 overflow-hidden shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                <img src="image/priabelajar.jpg" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-24 px-6 md:px-20">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl font-bold text-[#2F5789] mb-4">Meet Our Team</h2>
        <p class="text-gray-500">Para pengembang di balik platform MentorCampus.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <?php 
        $team = [
            ['nama' => 'Dishwar Raya Pradipta', 'npm' => '24082010008', 'foto' => 'image/raya.jpeg'],
            ['nama' => 'Fachrisya Maula Ardhi', 'npm' => '24082010023', 'foto' => 'image/fachris.jpeg'],
            ['nama' => 'Nissa Febriyanti', 'npm' => '24082010028', 'foto' => 'image/nissaa.jpeg']
        ];

        foreach ($team as $member): ?>
        <div class="group text-center">
            <div class="relative inline-block mb-6">
                <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-blue-50 shadow-lg group-hover:border-blue-400 transition-colors duration-300">
                    <img src="<?= $member['foto'] ?>" alt="<?= $member['nama'] ?>" 
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($member['nama']) ?>&background=random'">
                </div>
                <div class="absolute bottom-2 right-2 bg-[#1D62B7] text-white text-[10px] px-3 py-1 rounded-full font-bold shadow-md">
                    UPNV Jawa Timur
                </div>
            </div>
            
            <h3 class="text-lg font-bold text-[#2F5789] group-hover:text-blue-600 transition-colors">
                <?= $member['nama'] ?>
            </h3>
            <p class="text-sm font-medium text-blue-400 tracking-widest mt-1">
                <?= $member['npm'] ?>
            </p>

            <div class="flex justify-center gap-4 mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-github"></i></a>
                <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="px-6 md:px-20 py-20 bg-gray-50">
    <div class="bg-[#1D62B7] rounded-[40px] p-12 text-center text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-6">Siap Memulai Perjalanan Akademikmu?</h2>
            <p class="text-blue-100 mb-10 max-w-xl mx-auto opacity-80">Gabung sekarang dan temukan mentor yang paling mengerti cara belajarmu.</p>
            
            <a href="courses.php" class="inline-block bg-white text-[#1D62B7] px-10 py-4 rounded-full font-bold hover:bg-blue-50 transition shadow-xl transform hover:scale-105 active:scale-95">
                Cari Mentor Sekarang
            </a>
        </div>
    </div>
</section>

<footer class="py-12 text-center">
    <p class="text-gray-400 text-sm">&copy; 2026 MentorCampus. Created for Excellence.</p>
</footer>

</body>
</html>