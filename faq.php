<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$faq_categories = [
    "Umum" => [
        ["q" => "Apa itu sebenarnya MentorCampus?", "a" => "MentorCampus adalah platform jembatan akademik yang memungkinkan mahasiswa (Student) belajar langsung dari kakak tingkat atau sesama mahasiswa (Mentor) yang lebih berpengalaman."],
        ["q" => "Bagaimana cara kerja sistem booking di sini?", "a" => "Sederhana: Cari mentor -> Pilih jadwal tersedia -> Tunggu konfirmasi -> Lakukan sesi mentoring sesuai waktu yang disepakati."],
        ["q" => "Apakah data pribadi saya aman?", "a" => "Tentu saja. Kami menggunakan enkripsi standar industri untuk melindungi data profil dan riwayat booking Anda."]
    ],
    "Untuk Student" => [
        ["q" => "Bagaimana jika mentor tidak muncul saat sesi?", "a" => "Jika mentor tidak hadir dalam 15 menit, Anda dapat melaporkannya melalui menu riwayat untuk pengembalian poin atau jadwal ulang."],
        ["q" => "Berapa lama durasi rata-rata satu sesi?", "a" => "Standar durasi adalah 60 hingga 90 menit, namun bervariasi tergantung pengaturan mentor."]
    ],
    "Untuk Mentor" => [
        ["q" => "Bagaimana cara menjadi mentor?", "a" => "Lengkapi data 'Mentor Profile' termasuk CV di menu Profile. Admin akan memverifikasi akun Anda."],
        ["q" => "Bagaimana sistem pencairan dana?", "a" => "Setiap sesi selesai akan menambah saldo. Pencairan dilakukan setiap akhir bulan ke rekening terdaftar."]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ffffff; }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease-out;
            opacity: 0;
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
            opacity: 1;
            padding-bottom: 1.5rem;
        }

        .faq-item {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .faq-item:hover {
            background-color: #f8faff;
        }

        .faq-item.active .icon-chevron {
            transform: rotate(180deg);
            color: #175BAF;
        }
    </style>
</head>

<body class="pt-16">

    <?php include 'navbar.php'; ?>

    <header class="relative w-full h-[450px] flex items-center justify-center overflow-hidden">
        <img src="image/priabelajar.jpg" alt="Hero FAQ" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0f172a]/60 backdrop-blur-[2px]"></div>
        
        <div class="relative z-10 text-center px-6">
            <span class="px-4 py-1 bg-blue-500 text-white text-[10px] font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Help Center</span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight">Apa yang bisa kami bantu?</h1>
            
            <div class="max-w-2xl mx-auto relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#175BAF]"></i>
                <input type="text" id="faqSearch" placeholder="Cari pertanyaan kamu di sini..." 
                       class="w-full py-5 pl-14 pr-6 bg-white rounded-2xl shadow-2xl outline-none text-slate-700 text-lg">
            </div>
        </div>
    </header>

    <section class="max-w-4xl mx-auto px-6 py-20">
        
        <?php foreach ($faq_categories as $category => $items): 
            $catId = str_replace(' ', '', $category); ?>
            
            <div id="cat-<?= $catId ?>" class="mb-16 category-section">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-2xl font-extrabold text-[#1e293b] whitespace-nowrap"><?= $category ?></h2>
                    <div class="h-[1px] w-full bg-slate-100"></div>
                </div>

                <div class="divide-y divide-slate-100">
                    <?php foreach ($items as $item): ?>
                        <div class="faq-item group">
                            <button onclick="toggleAccordion(this)" 
                                    class="w-full flex items-center justify-between py-6 text-left focus:outline-none">
                                <span class="text-lg font-semibold text-slate-700 group-hover:text-[#175BAF] transition-colors pr-8">
                                    <?= $item['q'] ?>
                                </span>
                                <i class="fa-solid fa-chevron-down icon-chevron text-slate-300 transition-transform duration-300"></i>
                            </button>
                            
                            <div class="faq-answer">
                                <p class="text-slate-500 leading-relaxed text-[16px]">
                                    <?= $item['a'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="mt-24 p-12 bg-slate-50 rounded-[3rem] border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <h3 class="text-2xl font-bold text-[#1e293b] mb-2">Masih bingung?</h3>
                <p class="text-slate-500">Hubungi tim kami untuk bantuan lebih lanjut via email.</p>
            </div>
            <a href="mailto:support@mentorcampus.id" 
               class="px-10 py-4 bg-[#175BAF] text-white font-bold rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Hubungi Support
            </a>
        </div>

    </section>

    <script>
        function toggleAccordion(btn) {
            const item = btn.parentElement;
            
            // Tutup item lain
            document.querySelectorAll('.faq-item').forEach(el => {
                if (el !== item) el.classList.remove('active');
            });

            // Toggle item klik
            item.classList.toggle('active');
        }

        // Fitur Cari (Search)
        document.getElementById('faqSearch').addEventListener('input', function(e) {
            const val = e.target.value.toLowerCase();
            document.querySelectorAll('.faq-item').forEach(item => {
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(val) ? "block" : "none";
            });
            document.querySelectorAll('.category-section').forEach(sec => {
                const visible = [...sec.querySelectorAll('.faq-item')].some(i => i.style.display !== "none");
                sec.style.display = visible ? "block" : "none";
            });
        });
    </script>

</body>
</html>