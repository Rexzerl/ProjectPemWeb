<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];
$nama = $_SESSION['nama'];

$result = mysqli_query($conn, "SELECT email FROM users WHERE id_user = $id_user");
$user = mysqli_fetch_assoc($result);

$email = $user['email'] ?? '';

// CEK SUDAH DAFTAR
$cek = mysqli_query($conn, "SELECT * FROM calon_mentor WHERE id_user = $id_user");
$sudah_daftar = mysqli_fetch_assoc($cek);

if (isset($_POST['submit'])) {

    if (!empty($sudah_daftar)) {
        echo "<script>alert('Kamu sudah mengajukan pendaftaran mentor!');</script>";
    } else {

        $id_kampus = $_POST['kampus'];
        $spesialisasi = mysqli_real_escape_string($conn, $_POST['spesialisasi']);
        $biografi = mysqli_real_escape_string($conn, $_POST['biografi']);

        // UPLOAD FILE
        $file = $_FILES['transkrip']['name'];
        $tmp = $_FILES['transkrip']['tmp_name'];
        $usia = $_POST['usia'];
        $fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);
        $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);

        $folder = "uploads/";
        $path = $folder . time() . "_" . $file;

        move_uploaded_file($tmp, $path);

        // INSERT
        $query = "INSERT INTO calon_mentor 
        (id_user, id_kampus, fakultas, jurusan, spesialisasi, file_transkrip, biografi, usia, status) 
        VALUES 
        ('$id_user','$id_kampus','$fakultas','$jurusan','$spesialisasi','$path','$biografi','$usia','pending')";

        if (mysqli_query($conn, $query)) {
            header("Location: mentor-status.php?success=1");
            exit;
        }

    } 

} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Become Mentor - MentorCampus</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-[#F5F7FA] pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="relative h-[260px] overflow-hidden flex items-center justify-center text-center">

    <img src="image/wanita-belajar.jpg" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/70"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Become a Mentor</h1>
        <p class="text-sm">Share your knowledge & grow together 🚀</p>
    </div>

</section>

<!-- FORM -->
<section class="px-6 py-16">

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow">

<h2 class="text-xl font-semibold text-[#175BAF] mb-6 text-center">
Mentor Application Form
</h2>

<?php if (!empty($sudah_daftar)): ?>

    <?php $status = $sudah_daftar['status'] ?? ''; ?>

    <!-- STATUS -->
    <div class="text-center p-6 bg-gray-50 rounded-xl">
        <p class="text-lg font-medium">You have already applied</p>

        <p class="mt-2 
        <?php 
            if ($status == 'pending') echo 'text-yellow-500';
            elseif ($status == 'accepted') echo 'text-green-500';
            else echo 'text-red-500';
        ?>">
            Status: <?= ucfirst($status); ?>
        </p>
    </div>

<?php else: ?>

<form method="POST" enctype="multipart/form-data" class="space-y-5">

<!-- NAME -->
<div>
<label class="text-sm text-gray-600">Full Name</label>
<input type="text" value="<?= $nama ?>" readonly
class="w-full mt-1 px-4 py-2 rounded-lg bg-gray-100">
</div>

<!-- EMAIL -->
<div>
<label class="text-sm text-gray-600">Email</label>
<input type="text" value="<?= $email ?>" readonly
class="w-full mt-1 px-4 py-2 rounded-lg bg-gray-100">
</div>

<!-- KAMPUS -->
<div>
<label class="text-sm text-gray-600">Campus</label>
<select name="kampus" required
class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">

<option value="">Select Campus</option>

<?php
$q = mysqli_query($conn, "SELECT * FROM kampus");
while ($k = mysqli_fetch_assoc($q)) {
?>
<option value="<?= $k['id_kampus']; ?>">
<?= $k['nama_kampus']; ?>
</option>
<?php } ?>

</select>
</div>

<!-- FAKULTAS -->
<div>
<label class="text-sm text-gray-600">Faculty</label>
<input type="text" name="fakultas" required
placeholder="Contoh: Fakultas Teknik"
class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">
</div>

<!-- JURUSAN -->
<div>
<label class="text-sm text-gray-600">Major / Jurusan</label>
<input type="text" name="jurusan" required
placeholder="Contoh: Teknik Informatika"
class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">
</div>

<!-- USIA -->
<div>
<label class="text-sm text-gray-600">Age</label>
<input type="number" name="usia" required min="17" max="40"
placeholder="Contoh: 20"
class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">
</div>

<!-- SPESIALISASI -->
<div>
<label class="text-sm text-gray-600">Specialization</label>
<input type="text" name="spesialisasi" required
placeholder="Web Development, UI/UX"
class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]">
</div>

<!-- BIO -->
<div>
<label class="text-sm text-gray-600">Short Bio</label>
<textarea name="biografi" rows="3"
class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#175BAF]"></textarea>
</div>

<!-- FILE -->
<div>
<label class="text-sm text-gray-600">Upload Transcript (PDF)</label>
<input type="file" name="transkrip" accept="application/pdf" required
class="mt-1">
</div>

<!-- BUTTON -->
<button type="submit" name="submit"
class="w-full bg-[#175BAF] text-white py-3 rounded-lg hover:scale-105 transition">
Submit Application
</button>

</form>

<?php endif; ?>

</div>

</section>

</body>
</html>