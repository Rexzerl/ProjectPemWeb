<?php
session_start();
require 'config.php';

/**
 * Validasi otentikasi pengguna
 */
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

/**
 * Inisialisasi variabel identitas
 */
$id = $_SESSION['user_id'] ?? $_SESSION['id_user'];
$role = $_SESSION['role'];
$current_id = (int)$id;

/**
 * Mengambil data profil dasar dari database
 */
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $current_id");
$user = mysqli_fetch_assoc($user_query);

$mentor_data = null;
$id_mentor = null;

/**
 * Jika user adalah mentor, ambil data spesifik profil mentor
 */
if ($role == 'mentor') {
    $mentor_query = mysqli_query($conn, "SELECT * FROM mentor_profiles WHERE id_user = $current_id");
    $mentor_data = mysqli_fetch_assoc($mentor_query);
    $id_mentor = $mentor_data['id_mentor'] ?? null;
}

/**
 * Proses pembaruan profil user (Nama & Foto)
 */
if (isset($_POST['update_profile'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $fotoPath = $user['foto_profil'];

    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
        $newName = "uploads/profile_" . time() . "." . $ext;
        
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $newName)) {
            $fotoPath = $newName;
        }
    }

    $sql_update = "UPDATE users SET nama='$nama', foto_profil='$fotoPath' WHERE id_user = $current_id";
    mysqli_query($conn, $sql_update);
    $_SESSION['nama'] = $nama;

    header("Location: profile.php?status=success");
    exit;
}

/**
 * Proses pembaruan data profesional mentor
 */
if (isset($_POST['save_mentor'])) {
    $bio = mysqli_real_escape_string($conn, $_POST['biografi']);
    $pengalaman = mysqli_real_escape_string($conn, $_POST['pengalaman']);
    $cvPath = $mentor_data['cv'] ?? '';

    if (!empty($_FILES['cv']['name'])) {
        $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
        $cvPath = "uploads/cv_" . time() . "." . $ext;
        move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
    }

    $sql_mentor = "UPDATE mentor_profiles SET biografi='$bio', pengalaman='$pengalaman', cv='$cvPath' WHERE id_user = $current_id";
    mysqli_query($conn, $sql_mentor);

    header("Location: profile.php?status=mentor_success");
    exit;
}

/**
 * Perhitungan Statistik (Hybrid: Sebagai Student & Mentor)
 */
$m_id = (int)($id_mentor ?? 0);

$query_total = "SELECT COUNT(*) as res FROM booking b 
                JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule 
                WHERE b.id_student = $current_id OR ms.id_mentor = $m_id";
$total_sessions = mysqli_fetch_assoc(mysqli_query($conn, $query_total))['res'] ?? 0;

$query_comp = "SELECT COUNT(*) as res FROM booking b 
               JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule 
               WHERE (b.id_student = $current_id OR ms.id_mentor = $m_id) AND b.status='completed'";
$completed_sessions = mysqli_fetch_assoc(mysqli_query($conn, $query_comp))['res'] ?? 0;

$query_ong = "SELECT COUNT(*) as res FROM booking b 
              JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule 
              WHERE (b.id_student = $current_id OR ms.id_mentor = $m_id) AND b.status='ongoing'";
$ongoing_sessions = mysqli_fetch_assoc(mysqli_query($conn, $query_ong))['res'] ?? 0;

/**
 * Query Utama untuk Daftar Sesi (Data Relasional)
 */
$base_sql = "
    SELECT b.*, 
           um.nama as mentor_nama, us.nama as student_nama,
           um.foto_profil as mentor_foto, us.foto_profil as student_foto,
           us.semester as student_semester,
           ms.tanggal, ms.jam, ms.id_mentor as schedule_owner_id,
           k.nama_kampus, mp.jurusan
    FROM booking b
    JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
    LEFT JOIN mentor_profiles mp ON ms.id_mentor = mp.id_mentor
    LEFT JOIN users um ON mp.id_user = um.id_user 
    LEFT JOIN users us ON b.id_student = us.id_user
    LEFT JOIN kampus k ON mp.id_kampus = k.id_kampus
    WHERE (b.id_student = $current_id OR ms.id_mentor = $m_id)
";

$ongoing_data = mysqli_query($conn, "$base_sql AND b.status = 'ongoing' ORDER BY ms.tanggal ASC");
$completed_data = mysqli_query($conn, "$base_sql AND b.status = 'completed' ORDER BY ms.tanggal DESC");
$cancelled_data = mysqli_query($conn, "$base_sql AND b.status = 'cancelled' ORDER BY ms.tanggal DESC");

/**
 * Fungsi pembantu untuk merender card secara konsisten
 */
function renderSessionCard($result, $type, $current_id) {
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="grid grid-cols-1 gap-4">';
        while($row = mysqli_fetch_assoc($result)) {
            // Logika Penentuan Lawan Bicara
            // Jika saya adalah student di baris ini, tampilkan data mentor
            $isMeAsStudent = ($current_id == $row['id_student']);
            $displayName = $isMeAsStudent ? $row['mentor_nama'] : $row['student_nama'];
            $displayFoto = $isMeAsStudent ? $row['mentor_foto'] : $row['student_foto'];
            $displayRole = $isMeAsStudent ? "Mentor Anda" : "Student Anda";
            $subInfo = $isMeAsStudent ? ($row['nama_kampus'] ?? 'Info Kampus Kosong') : "Semester " . ($row['student_semester'] ?? '-');
            
            $cardStyle = ($type == 'ongoing') ? 'border-blue-100 bg-blue-50/30' : 'border-gray-100 bg-white';
            ?>
            <div class="group flex flex-col md:flex-row items-center gap-5 p-5 border rounded-2xl <?= $cardStyle ?> transition-all hover:shadow-lg">
                <div class="relative">
                    <img src="<?= (!empty($displayFoto) && file_exists($displayFoto)) ? $displayFoto : 'image/default.jpg'; ?>" 
                         class="w-16 h-16 rounded-full object-cover shadow-sm ring-4 ring-white">
                    <div class="absolute -bottom-1 -right-1 bg-blue-600 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-md shadow-sm">
                        <?= $displayRole ?>
                    </div>
                </div>
                
                <div class="flex-1 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-1">
                        <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($displayName); ?></h4>
                        <?php if($type == 'completed'): ?>
                            <span class="text-[9px] bg-green-100 text-green-600 font-bold px-2 py-0.5 rounded uppercase">Selesai</span>
                        <?php elseif($type == 'cancelled'): ?>
                            <span class="text-[9px] bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded uppercase">Batal</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-blue-500 font-semibold uppercase tracking-tight mb-3"><?= htmlspecialchars($subInfo); ?></p>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <div class="flex items-center gap-1.5 text-gray-500 text-xs bg-white/80 px-3 py-1.5 rounded-lg border border-gray-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" /></svg>
                            <?= date('d M Y', strtotime($row['tanggal'])) ?>
                        </div>
                        <div class="flex items-center gap-1.5 text-gray-500 text-xs bg-white/80 px-3 py-1.5 rounded-lg border border-gray-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <?= $row['jam'] ?>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row md:flex-col gap-2 w-full md:w-32">
                    <?php if($type == 'ongoing'): ?>
                        <a href="finish-booking.php?id=<?= $row['id_booking']; ?>" class="flex-1 text-center bg-green-500 text-white py-2 rounded-xl text-[10px] font-bold hover:bg-green-600 transition shadow-sm">SELESAI</a>
                        <a href="cancel-booking.php?id=<?= $row['id_booking']; ?>" onclick="return confirm('Batalkan sesi?')" class="flex-1 text-center bg-white border border-red-200 text-red-500 py-2 rounded-xl text-[10px] font-bold hover:bg-red-50 transition">BATAL</a>
                    <?php elseif($type == 'completed'): ?>
                        <a href="rating.php?id=<?= $row['id_booking']; ?>" class="flex-1 text-center bg-yellow-400 text-white py-2 rounded-xl text-[10px] font-bold hover:bg-yellow-500 transition shadow-sm">REVIEW</a>
                    <?php else: ?>
                        <a href="delete-history.php?id=<?= $row['id_booking']; ?>" onclick="return confirm('Hapus data?')" class="flex-1 text-center bg-gray-100 text-gray-400 py-2 rounded-xl text-[10px] font-bold hover:bg-red-500 hover:text-white transition">HAPUS</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<div class="text-center py-20 bg-gray-50/50 rounded-3xl border-2 border-dashed border-gray-100">
                <p class="text-gray-400 text-sm italic">Belum ada riwayat untuk kategori ini.</p>
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Hub - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lexend', sans-serif; background-color: #FAFBFE; }
        .tab-content { display: none; animation: slideUp 0.4s ease-out; }
        .tab-content.active { display: block; }
        .nav-glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .tab-btn.active { color: #175BAF; border-bottom: 3px solid #175BAF; font-weight: 600; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="pt-20">

    <?php include 'navbar.php'; ?>

    <div class="relative h-56 md:h-72 w-full overflow-hidden">
        <img src="image/wanita-belajar.jpg" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A] to-transparent opacity-90"></div>
        <div class="absolute inset-0 flex items-center px-6 md:px-20 max-w-7xl mx-auto">
            <div class="text-white max-w-lg">
                <span class="inline-block px-3 py-1 bg-blue-500/20 backdrop-blur-md border border-blue-400/30 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">Dashboard Kendali</span>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">Profil <span class="text-blue-400">Saya</span></h1>
                <p class="text-gray-300 mt-3 text-sm md:text-base leading-relaxed">Kelola jadwal mentoring, pantau progress belajar, dan perbarui eksistensi profesional Anda.</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-900/5 border border-gray-100 p-8 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-[#175BAF]"></div>
                    
                    <div class="relative w-36 h-36 mx-auto mb-6 group">
                        <?php if (!empty($user['foto_profil']) && file_exists($user['foto_profil'])): ?>
                            <img src="<?= $user['foto_profil'] ?>" class="w-full h-full rounded-[2.5rem] object-cover border-4 border-white shadow-2xl transition group-hover:rotate-3">
                        <?php else: ?>
                            <div class="w-full h-full rounded-[2.5rem] bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-4xl font-bold text-white shadow-xl">
                                <?= strtoupper(substr($user['nama'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        <div class="absolute -bottom-2 -right-2 bg-green-500 p-2 rounded-xl border-4 border-white shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                    </div>

                    <form method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div class="text-center">
                            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required
                                   class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-center focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800 text-xl">
                        </div>
                        
                        <div class="text-left bg-blue-50/50 p-4 rounded-2xl border border-blue-100/50">
                            <label class="text-[9px] uppercase font-black text-blue-400 tracking-widest block mb-2">Unggah Foto Baru</label>
                            <input type="file" name="foto_profil" class="block w-full text-xs text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        </div>

                        <button type="submit" name="update_profile" class="w-full bg-[#175BAF] text-white py-4 rounded-2xl font-bold text-sm hover:bg-blue-800 transition-all hover:shadow-lg hover:shadow-blue-500/20 active:scale-95">
                            SIMPAN PERUBAHAN
                        </button>
                    </form>

                    <div class="mt-8 pt-8 border-t border-gray-50 flex items-center justify-between text-left">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Status Akun</p>
                            <p class="text-xs font-bold text-gray-600"><?= strtoupper($role) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Email Terverifikasi</p>
                            <p class="text-xs font-bold text-gray-600"><?= htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm transition hover:scale-105">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ongoing</p>
                        <p class="text-3xl font-black text-gray-800"><?= $ongoing_sessions ?></p>
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm transition hover:scale-105">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Success</p>
                        <p class="text-3xl font-black text-gray-800"><?= $completed_sessions ?></p>
                    </div>
                    <div class="bg-gray-900 p-6 rounded-[2rem] col-span-2 shadow-xl shadow-blue-900/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Total Kontribusi Sesi</p>
                                <p class="text-4xl font-black text-white mt-1"><?= $total_sessions ?></p>
                            </div>
                            <div class="p-4 bg-white/10 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-10">
                
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-8 overflow-x-auto">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                            <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                            Aktivitas Mentoring
                        </h3>
                        <div class="flex p-1.5 bg-gray-50 rounded-2xl border border-gray-100">
                            <button onclick="openTab('ongoing')" id="btn-ongoing" class="tab-btn active px-5 py-2 text-xs font-bold transition-all rounded-xl">AKTIF</button>
                            <button onclick="openTab('completed')" id="btn-completed" class="tab-btn px-5 py-2 text-xs font-bold text-gray-400 transition-all rounded-xl">SELESAI</button>
                            <button onclick="openTab('cancelled')" id="btn-cancelled" class="tab-btn px-5 py-2 text-xs font-bold text-gray-400 transition-all rounded-xl">BATAL</button>
                        </div>
                    </div>

                    <div id="view-ongoing" class="tab-content active">
                        <?php renderSessionCard($ongoing_data, 'ongoing', $current_id); ?>
                    </div>
                    <div id="view-completed" class="tab-content">
                        <?php renderSessionCard($completed_data, 'completed', $current_id); ?>
                    </div>
                    <div id="view-cancelled" class="tab-content">
                        <?php renderSessionCard($cancelled_data, 'cancelled', $current_id); ?>
                    </div>
                </div>

                <?php if ($role == 'mentor'): ?>
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#175BAF] to-blue-500 px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-white/20 backdrop-blur-md rounded-2xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">Kelola Portfolio Mentor</h3>
                                    <p class="text-blue-100 text-[10px] font-medium opacity-80 uppercase tracking-widest">Verifikasi data publik Anda</p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Biografi Profesional</label>
                                    <textarea name="biografi" rows="5" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600 leading-relaxed transition-all" placeholder="Jelaskan spesialisasi Anda..."><?= htmlspecialchars($mentor_data['biografi'] ?? ''); ?></textarea>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Daftar Pengalaman</label>
                                    <textarea name="pengalaman" rows="5" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600 leading-relaxed transition-all" placeholder="Pencapaian utama Anda..."><?= htmlspecialchars($mentor_data['pengalaman'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <div class="p-6 bg-[#F8FAFF] rounded-3xl border border-blue-100 flex flex-col lg:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-5">
                                    <div class="p-4 bg-white rounded-2xl shadow-sm border border-blue-50">
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">Berkas Curriculum Vitae</h4>
                                        <p class="text-[10px] text-gray-400 font-medium">Pastikan berkas berformat PDF (Maks 2MB)</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <?php if (!empty($mentor_data['cv'])): ?>
                                        <a href="<?= $mentor_data['cv'] ?>" target="_blank" class="px-5 py-2 bg-white border border-blue-200 text-blue-600 text-xs font-bold rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">LIHAT CV</a>
                                    <?php endif; ?>
                                    <div class="relative">
                                        <input type="file" name="cv" class="text-xs file:hidden text-gray-400">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="save_mentor" class="w-full lg:w-max px-12 bg-gray-900 text-white py-4 rounded-2xl font-bold text-sm hover:bg-blue-800 transition-all hover:shadow-2xl hover:shadow-blue-500/30">
                                UPDATE DATA MENTOR
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function openTab(type) {
            // Sembunyikan semua konten tab
            const contents = document.getElementsByClassName('tab-content');
            for (let i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
            }

            // Reset semua tombol tab
            const buttons = document.getElementsByClassName('tab-btn');
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove('active');
                buttons[i].classList.add('text-gray-400');
            }

            // Aktifkan tab dan tombol yang dipilih
            document.getElementById('view-' + type).classList.add('active');
            const targetBtn = document.getElementById('btn-' + type);
            targetBtn.classList.add('active');
            targetBtn.classList.remove('text-gray-400');
        }
    </script>

    <div class="py-12"></div>
</body>
</html>