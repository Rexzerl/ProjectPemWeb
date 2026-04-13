<?php
session_start();
require 'config.php';

// Proteksi Login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// 1. AMBIL DATA USER
$userQ = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id");
$user = mysqli_fetch_assoc($userQ);

// 2. DATA MENTOR (KHUSUS ROLE MENTOR)
$mentor = null;
$id_mentor = null;

if ($role == 'mentor') {
    $mQ = mysqli_query($conn, "SELECT * FROM mentor_profiles WHERE id_user = $id");
    $mentor = mysqli_fetch_assoc($mQ);
    $id_mentor = $mentor['id_mentor'] ?? null;
}

// 3. LOGIKA UPDATE PROFILE (NAMA & FOTO)
if (isset($_POST['update_profile'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $fotoPath = $user['foto_profil'];

    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
        $newName = "uploads/profile_" . time() . "." . $ext;
        
        // Pastikan folder uploads ada
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $newName)) {
            $fotoPath = $newName;
        }
    }

    mysqli_query($conn, "UPDATE users SET nama='$nama', foto_profil='$fotoPath' WHERE id_user = $id");
    $_SESSION['nama'] = $nama;

    header("Location: profile.php");
    exit;
}

// 4. LOGIKA UPDATE MENTOR (BIO, PENGALAMAN, CV)
if (isset($_POST['save_mentor'])) {
    $bio = mysqli_real_escape_string($conn, $_POST['biografi']);
    $pengalaman = mysqli_real_escape_string($conn, $_POST['pengalaman']);
    $cvPath = $mentor['cv'] ?? '';

    if (!empty($_FILES['cv']['name'])) {
        $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
        $cvPath = "uploads/cv_" . time() . "." . $ext;
        move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
    }

    mysqli_query($conn, "UPDATE mentor_profiles SET biografi='$bio', pengalaman='$pengalaman', cv='$cvPath' WHERE id_user = $id");

    header("Location: profile.php");
    exit;
}

// 5. STATISTIK SESI
if ($role == 'mentor' && $id_mentor) {
    $total = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(*) as total FROM booking b
        JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
        WHERE ms.id_mentor = $id_mentor
    "))['total'] ?? 0;

    $completed = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(*) as total FROM booking b
        JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
        WHERE ms.id_mentor = $id_mentor AND b.status='completed'
    "))['total'] ?? 0;

    $ongoing = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(*) as total FROM booking b
        JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
        WHERE ms.id_mentor = $id_mentor AND b.status='ongoing'
    "))['total'] ?? 0;
} else {
    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM booking WHERE id_student = $id"))['total'] ?? 0;
    $completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM booking WHERE id_student = $id AND status='completed'"))['total'] ?? 0;
    $ongoing = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM booking WHERE id_student = $id AND status='ongoing'"))['total'] ?? 0;
}

// 6. QUERY DAFTAR SESI (ONGOING, COMPLETED, CANCELLED)
$where = ($role == 'student') ? "b.id_student = $id" : "ms.id_mentor = $id_mentor";

// Query dasar untuk mengambil detail booking
$baseQuery = "
    SELECT b.*, 
           u.nama as mentor_nama,
           u.foto_profil,
           u.semester,
           mp.spesialisasi,
           mp.jurusan,
           k.nama_kampus,
           ms.tanggal,
           ms.jam
    FROM booking b
    JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
    JOIN mentor_profiles mp ON ms.id_mentor = mp.id_mentor
    JOIN users u ON mp.id_user = u.id_user
    JOIN kampus k ON mp.id_kampus = k.id_kampus
    WHERE $where
";

$ongoingList = mysqli_query($conn, "$baseQuery AND b.status = 'ongoing' ORDER BY ms.tanggal ASC");
$completedList = mysqli_query($conn, "$baseQuery AND b.status = 'completed' ORDER BY ms.tanggal DESC, ms.jam DESC");
$cancelledList = mysqli_query($conn, "$baseQuery AND b.status = 'cancelled' ORDER BY ms.tanggal DESC, ms.jam DESC");

$fotoUser = !empty($user['foto_profil']) ? $user['foto_profil'] : "image/default.jpg";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lexend', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 pt-24">

<?php include 'navbar.php'; ?>

<section class="relative h-[220px]">
    <img src="image/wanita-belajar.jpg" class="w-full h-full object-cover">
    <div class="absolute bottom-6 left-12 text-white">
        <h1 class="text-2xl font-bold">Welcome, <?= htmlspecialchars($_SESSION['nama']); ?> 👋</h1>
        <p class="text-sm">Manage your account and sessions here</p>
    </div>
</section>

<section class="px-12 py-8 grid md:grid-cols-3 gap-8">

    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <?php if (!empty($user['foto_profil']) && file_exists($user['foto_profil'])): ?>
                <img src="<?= $user['foto_profil'] ?>" class="w-24 h-24 mx-auto rounded-full object-cover shadow-md">
            <?php else: ?>
                <div class="w-24 h-24 mx-auto rounded-full bg-[#B6DCFF] flex items-center justify-center text-2xl font-bold text-[#175BAF] shadow-md">
                    <?= strtoupper(substr($user['nama'], 0, 1)); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" 
                       class="w-full border px-3 py-2 rounded-lg text-center focus:ring-2 focus:ring-blue-400 outline-none">
                
                <div class="text-left">
                    <label class="text-[10px] text-gray-400 uppercase font-bold ml-1">Ganti Foto Profil</label>
                    <input type="file" name="foto_profil" class="text-xs w-full mt-1">
                </div>

                <button type="submit" name="update_profile" 
                        class="w-full bg-[#175BAF] text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition transform hover:scale-[1.02]">
                    Save Changes
                </button>
            </form>

            <p class="text-gray-500 text-sm mt-4 border-t pt-4">
                <span class="block text-xs text-gray-400">Email Address</span>
                <?= $user['email']; ?>
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div class="bg-white p-6 rounded-2xl shadow flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Total Sessions</p>
                    <p class="text-2xl font-bold text-[#2F5789]"><?= $total ?></p>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Completed</p>
                    <p class="text-2xl font-bold text-green-600"><?= $completed ?></p>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-bold text-[#2F5789] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Account Info
            </h3>
            <div class="grid grid-cols-2 gap-6 text-sm">
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-gray-400 text-xs font-bold uppercase">Full Name</p>
                    <p class="font-semibold text-gray-700"><?= htmlspecialchars($user['nama']); ?></p>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-gray-400 text-xs font-bold uppercase">Current Role</p>
                    <p class="font-semibold text-gray-700"><?= ucfirst($role); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-bold text-[#2F5789] mb-4">Ongoing Sessions</h3>
            <?php if (mysqli_num_rows($ongoingList) > 0): ?>
                <div class="space-y-4">
                <?php while($b = mysqli_fetch_assoc($ongoingList)): ?>
                    <div class="border border-blue-100 p-4 rounded-xl flex flex-wrap md:flex-nowrap gap-4 items-center bg-blue-50/30">
                        <img src="<?= !empty($b['foto_profil']) ? $b['foto_profil'] : 'image/default.jpg'; ?>" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">
                        
                        <div class="flex-1 min-w-[200px]">
                            <p class="font-bold text-gray-800 text-base"><?= $b['mentor_nama']; ?></p>
                            <p class="text-xs text-blue-600 font-medium"><?= $b['nama_kampus']; ?> • <?= $b['jurusan']; ?></p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[11px] bg-white px-2 py-0.5 rounded border text-gray-500">
                                    <?= date('d M Y', strtotime($b['tanggal'])) ?>
                                </span>
                                <span class="text-[11px] bg-white px-2 py-0.5 rounded border text-gray-500">
                                    <?= date('H:i', strtotime($b['jam'])) ?> WIB
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2 w-full md:w-auto">
                            <a href="finish-booking.php?id=<?= $b['id_booking']; ?>"
                               class="flex-1 md:flex-none text-center bg-green-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-600">
                               Selesai
                            </a>
                            <a href="cancel-booking.php?id=<?= $b['id_booking']; ?>"
                               onclick="return confirm('Yakin mau batalkan sesi ini?')"
                               class="flex-1 md:flex-none text-center bg-red-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-600">
                               Batalkan
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-6 border-2 border-dashed rounded-2xl">
                    <p class="text-gray-400 text-sm italic">Belum ada sesi ongoing saat ini.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-bold text-[#2F5789] mb-4">Completed Sessions History</h3>
            <?php if (mysqli_num_rows($completedList) > 0): ?>
                <div class="space-y-3">
                    <?php while($b = mysqli_fetch_assoc($completedList)): ?>
                        <div class="border p-4 rounded-xl flex gap-4 items-center hover:bg-gray-50 transition">
                            <img src="<?= !empty($b['foto_profil']) ? $b['foto_profil'] : 'image/default.jpg'; ?>" 
                                 class="w-12 h-12 rounded-full object-cover grayscale-[0.5]">
                            
                            <div class="flex-1">
                                <p class="font-bold text-gray-700 text-sm"><?= $b['mentor_nama']; ?></p>
                                <p class="text-xs text-gray-500"><?= $b['nama_kampus']; ?> • <?= date('d M Y', strtotime($b['tanggal'])) ?></p>
                            </div>

                            <a href="rating.php?id=<?= $b['id_booking']; ?>" 
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-yellow-600">
                                Beri Rating
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400 text-sm text-center py-4">Belum ada riwayat sesi selesai.</p>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-red-500">
            <h3 class="font-bold text-red-600 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Cancelled Sessions
            </h3>
            <?php if (mysqli_num_rows($cancelledList) > 0): ?>
                <div class="space-y-3">
                    <?php while($b = mysqli_fetch_assoc($cancelledList)): ?>
                        <div class="border border-red-50 p-4 rounded-xl flex gap-4 items-center opacity-75 bg-red-50/20">
                            <img src="<?= !empty($b['foto_profil']) ? $b['foto_profil'] : 'image/default.jpg'; ?>" 
                                 class="w-12 h-12 rounded-full object-cover grayscale">
                            
                            <div class="flex-1">
                                <p class="font-bold text-gray-600 text-sm"><?= $b['mentor_nama']; ?></p>
                                <p class="text-[11px] text-gray-400"><?= date('d M Y', strtotime($b['tanggal'])) ?> • <?= $b['jam'] ?></p>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="text-[10px] px-2 py-1 rounded-full bg-red-100 text-red-600 font-bold uppercase tracking-wider">
                                    Cancelled
                                </span>
                                
                                <a href="delete-history.php?id=<?= $b['id_booking']; ?>" 
                                   onclick="return confirm('Hapus riwayat pembatalan ini?')"
                                   class="text-gray-300 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-full" title="Hapus Riwayat">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400 text-sm text-center py-4">Tidak ada pembatalan sesi.</p>
            <?php endif; ?>
        </div>

        <?php if ($role == 'mentor'): ?>
            <div class="bg-[#175BAF] rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <h3 class="font-bold text-xl mb-6 flex items-center gap-3 relative z-10">
                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Public Mentor Profile Details
                </h3>

                <form method="POST" enctype="multipart/form-data" class="space-y-5 relative z-10">
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase text-blue-100">Biografi Singkat</label>
                        <textarea name="biografi" rows="3"
                                  class="w-full px-4 py-3 border-none rounded-xl text-gray-800 focus:ring-4 focus:ring-blue-300 outline-none transition"
                                  placeholder="Ceritakan sedikit tentang dirimu..."><?= htmlspecialchars($mentor['biografi'] ?? ''); ?></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase text-blue-100">Pengalaman Utama</label>
                        <textarea name="pengalaman" rows="3"
                                  class="w-full px-4 py-3 border-none rounded-xl text-gray-800 focus:ring-4 focus:ring-blue-300 outline-none transition"
                                  placeholder="Sebutkan pengalaman atau pencapaianmu..."><?= htmlspecialchars($mentor['pengalaman'] ?? ''); ?></textarea>
                    </div>

                    <div class="bg-blue-800/50 p-4 rounded-xl border border-blue-400/30">
                        <label class="text-xs font-bold uppercase text-blue-100 block mb-2">Update Curriculum Vitae (PDF)</label>
                        <input type="file" name="cv" class="text-sm">
                        <?php if (!empty($mentor['cv'])): ?>
                            <a href="<?= $mentor['cv'] ?>" target="_blank" class="mt-3 inline-flex items-center gap-2 text-xs bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View Current CV
                            </a>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="save_mentor"
                            class="w-full bg-white text-[#175BAF] py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
                        Update Mentor Data
                    </button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</section>

<div class="h-20"></div>

</body>
</html>