<?php
session_start();
require 'config.php';

// Proteksi halaman admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// 1. LOGIKA HAPUS BOOKING
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    // Menggunakan id_booking sesuai struktur database kamu
    $query_delete = "DELETE FROM booking WHERE id_booking = '$id'"; 
    if (mysqli_query($conn, $query_delete)) {
        header("Location: admin-booking.php?msg=deleted");
        exit;
    }
}

// 2. QUERY AMBIL DATA (JOIN Sesuai Gambar Database)
$query = "SELECT 
            b.id_booking as id, 
            b.status, 
            b.created_at,
            u_student.nama as nama_student, 
            u_mentor.nama as nama_mentor,
            m.spesialisasi
          FROM booking b
          JOIN users u_student ON b.id_student = u_student.id_user
          JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
          JOIN mentor_profiles m ON ms.id_mentor = m.id_mentor
          JOIN users u_mentor ON m.id_user = u_mentor.id_user
          ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $query);

// Cek jika query error untuk memudahkan debugging
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - MentorCampus Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] pt-24">

    <?php include 'navbar-admin.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs text-slate-400">
                        <li>Admin</li>
                        <li><i class="fas fa-chevron-right mx-2 text-[8px]"></i></li>
                        <li class="text-[#175BAF] font-bold">Booking Management</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-extrabold text-[#1e293b]">Manajemen Booking</h1>
                <p class="text-slate-500 mt-1">Pantau semua transaksi jadwal mentoring yang terjadi di platform.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="admin-dashboard.php" class="bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 transition flex items-center shadow-sm">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Dashboard
                </a>
            </div>
        </div>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm">
                <i class="fas fa-check-circle mr-3"></i>
                <span class="text-sm font-bold">Data booking berhasil dihapus permanen dari sistem.</span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">ID</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Student</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Mentor / Spesialisasi</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Waktu Transaksi</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 text-sm font-bold text-[#175BAF]">#<?= $row['id'] ?></td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-slate-700 block"><?= $row['nama_student'] ?></span>
                                <span class="text-[10px] text-slate-400 uppercase font-medium">Student</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-slate-700 block"><?= $row['nama_mentor'] ?></span>
                                <span class="text-xs text-[#175BAF] font-medium italic"><?= $row['spesialisasi'] ?></span>
                            </td>
                            <td class="px-8 py-6 text-sm text-slate-500">
                                <?= date('d M Y, H:i', strtotime($row['created_at'])) ?>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center">
                                    <?php 
                                        $statusLabel = strtolower($row['status']);
                                        $colorClass = "bg-slate-100 text-slate-500"; // default
                                        if($statusLabel == 'completed') $colorClass = "bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200";
                                        if($statusLabel == 'ongoing') $colorClass = "bg-blue-50 text-blue-600 ring-1 ring-blue-200";
                                        if($statusLabel == 'cancelled') $colorClass = "bg-rose-50 text-rose-600 ring-1 ring-rose-200";
                                    ?>
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-tighter <?= $colorClass ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button onclick="confirmDelete(<?= $row['id'] ?>)" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition shadow-sm flex items-center justify-center ml-auto">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>

                        <?php if(mysqli_num_rows($result) == 0): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-slate-200 text-5xl mb-4"></i>
                                    <p class="text-slate-400 font-medium">Belum ada transaksi booking ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function confirmDelete(id) {
            if (confirm("🚨 PERINGATAN: Menghapus data booking ID #" + id + " akan menghapus riwayat transaksi ini secara permanen. Lanjutkan?")) {
                window.location.href = "admin-booking.php?delete_id=" + id;
            }
        }
    </script>

</body>
</html>