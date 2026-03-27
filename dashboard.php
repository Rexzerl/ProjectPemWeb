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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">
<!--navigasi atas-->
    <div x-data="{ open: false}" class="">
        <div class="">
            <div class="">
               <div class="">
                <a href="#" class="">Mentor Campus</a>
                <svg class>
                    <path>
                </svg>
               </div>
               <button class="">
                    <svg class="">
                        <path></path>
                        <path></path>
                    </svg>
               </button> 
            </div>
            <nav class="">
                <a class="" href="#">Home</a>
                <a class="" href="#">Serach Mentor</a>
                <a class="" href="#">How</a>
                <a class="" href="#">Campus</a>
                <a class="" href="#">About Us</a>
                <a class="" href="#">Login</a>
                <a class="" href="#">Sign Up</a>
            </nav>
        </div>
    </div>
    <!--Awalan-->
    <div class="">
        <div class="">
    <!--bagian kiri, lihat contoh yg kata studying-->
            <div class="">
                <h1 class="">
                    <span class="">Cari</span> Mentor dari Kampusmu Sendiri
                </h1>
                <p class="">Mentor Campus adalah platform belajar peer to peer antar mahasiswa. Temukan teman belajar 
                    untuk matkul sulit, persiapan UTS/UAS, atau sekedar diskusi</p>
                <div class="">
                    <button class="">
                        Mulai Belajar
                    </button>
                    <div class="">
                        <button class="">
                            <svg class="">
                            </svg>
                        </button>
                        <span class="">Cari sekarang</span>
                    </div>
                </div>
            </div>
    <!--bagian kanan mungkin isi gambar saja-->
        </div>
    </div>

    <!--kontainer trusted-->
    <div>
        <!--trusted by-->
        <div class="">
            <h1 class="">15+ Kampus Terdaftar, 500+ Mentor Aktif, dan 2.000+ Jam Belajar Terlampaui</h1>
        </div>
    </div>
    <!--untuk memulai mentor atau mahasiswa-->
    <div class="">
        <div class="">
            <div class="">
                <img class="">
                <div class="">
                    <div class="">
                        <h1 class="">Untuk Mentor</h1>
                        <button class="">Mulai kelas hari ini</button>
                    </div>
                </div>
            </div>
            <div class="">
                <img class="">
                <div class="">
                    <div class="">
                        <h1 class="">Untuk Mahasiswa</h1>
                        <button class="">Masukkan kode</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!--testimoni-->
    <div class="">
			<div class="">
				<div class="">
					<span class=""></span>
					<h1 class="">TESTIMONI</h1>
				</div>
				<h1 class="">Apa yang mereka katakan?</h1>
				<p class="">Saya lulus mata kuliah tersulit berkat platform ini.</p>
				<p class="">Bagaimana dengan kamu? kirimkan tanggapanmu</p>
				<button class="">
					<span>Tulis tanggapan</span>
					<div class="">
						<svg class="">
						</svg>
					</div>
				</button>
			</div>
			<div class="">
				<img class="" src="">
			</div>
		</div>

    <!--footer-->
    <footer class="">
        <div class="max-w-lg mx-auto">
            <div class="">
                <div class="relative">
                    <h1 class="">Mentor Campus</h1>
                    <svg class="">
                    </svg>
                </div>
                <span class="">Satu Kampus, Saling Bantu</span>
            </div>
            <div class="">
                <label class="">Subscribe to get our newsletter</label> <!--Iki nanti ubah en slogan sing cocok ya, ini cuma contoh-->
            </div>
            <div class="">
                <a href="" class="">FAQ</a>
                <a href="" class="">Privacy</a>
                <a href="" class="">Terms & Conditions</a>
            </div>
            <div class="">
                <p class="">&copy; 2026 MentorKampus. Seluruh Hak Cipta Dilindungi.</p>
                <div class="">
                    <p>Dibuat oleh Kelompok <span class="font-semibold">13</span></p>
                    <p>Information System 2024 <span class="font-semibold">UPNVJT</span></p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>