<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config.php';

/* =======================
   1. CHECK LOGIN & SESSION
   ======================= */
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Mengambil ID User dari session (mengantisipasi perbedaan key session)
$id_user = $_SESSION['user_id'] ?? $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("Error: Session User ID tidak ditemukan. Silahkan login kembali.");
}

/* =======================
   2. GET & VALIDATE SCHEDULE
   ======================= */
$id_schedule = isset($_GET['id_schedule']) ? (int)$_GET['id_schedule'] : 0;

if (!$id_schedule) {
    die("Jadwal tidak ditemukan.");
}

// Ambil detail jadwal dan mentor
$query_detail = "
    SELECT ms.*, mp.id_mentor, u.nama, mp.spesialisasi 
    FROM mentor_schedule ms
    JOIN mentor_profiles mp ON ms.id_mentor = mp.id_mentor
    JOIN users u ON mp.id_user = u.id_user
    WHERE ms.id_schedule = $id_schedule
";
$result_detail = mysqli_query($conn, $query_detail);
$schedule = mysqli_fetch_assoc($result_detail);

if (!$schedule) {
    die("Data jadwal tidak valid di database.");
}

/* =======================
   3. CEK STATUS BOOKING USER
   ======================= */
// Cek apakah user ini sudah pernah membooking jadwal ini sebelumnya
$cek_booking = mysqli_query($conn, "
    SELECT * FROM booking 
    WHERE id_schedule = $id_schedule 
    AND id_student = $id_user 
    AND status != 'cancelled'
");
$isAlreadyBooked = mysqli_num_rows($cek_booking) > 0;

/* =======================
   4. LOGIKA PROSES BOOKING
   ======================= */
if (isset($_GET['action']) && $_GET['action'] === 'book') {

    // A. Cegah double booking jika user sudah booking jadwal yang sama
    if ($isAlreadyBooked) {
        header("Location: booking.php?id_schedule=$id_schedule&status=already");
        exit;
    }

    // B. Pastikan jadwal masih 'available' di tabel mentor_schedule
    if ($schedule['status'] !== 'available') {
        header("Location: booking.php?id_schedule=$id_schedule&status=unavailable");
        exit;
    }

    // C. Mulai Transaksi Database
    mysqli_begin_transaction($conn);

    try {
        // 1. Insert ke tabel booking
        $insert_query = "INSERT INTO booking (id_schedule, id_student, status, created_at) 
                         VALUES ($id_schedule, $id_user, 'ongoing', NOW())";
        mysqli_query($conn, $insert_query);

        // 2. Update status di mentor_schedule menjadi 'booked' 
        // Agar tidak muncul lagi di course.php
        $update_query = "UPDATE mentor_schedule SET status = 'booked' WHERE id_schedule = $id_schedule";
        mysqli_query($conn, $update_query);

        // Jika semua OK, commit
        mysqli_commit($conn);
        header("Location: booking.php?id_schedule=$id_schedule&status=success");
        exit;

    } catch (Exception $e) {
        // Jika gagal, batalkan semua perubahan
        mysqli_rollback($conn);
        die("Terjadi kesalahan saat booking: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Session - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lexend', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 pt-20">

<?php include 'navbar.php'; ?>

<section class="relative h-[300px] flex items-center justify-center text-center overflow-hidden">
    <img src="image/cowobelajar.jpg" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-[#175BAF]/80"></div>
    <div class="relative z-10 text-white px-4">
        <h1 class="text-4xl font-bold mb-2">Konfirmasi Booking</h1>
        <p class="text-lg opacity-90">Satu langkah lagi untuk memulai sesi belajarmu bersama <b><?= $schedule['nama']; ?></b></p>
    </div>
</section>

<div class="max-w-2xl mx-auto -mt-12 mb-20 relative z-20 px-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="text-center py-10">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">🎉 Booking Berhasil!</h2>
        <p class="text-gray-500 mt-3 leading-relaxed">
            Jadwal kamu sudah tercatat. Mentor akan segera menghubungimu. <br>
            Kamu bisa memantau status sesi ini di halaman profil.
        </p>
        <div class="mt-8 flex flex-col gap-3">
            <a href="profile.php" class="bg-[#175BAF] text-white font-semibold px-8 py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Lihat Progres di Profil
            </a>
            
            <a href="course.php" class="text-gray-400 hover:text-[#175BAF] font-medium transition py-2 underline decoration-dotted">
                ← Kembali ke Daftar Mentor
            </a>
        </div>
    </div>
<?php endif; ?>

    </div>
</div>

</body>
</html>