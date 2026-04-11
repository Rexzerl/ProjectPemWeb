<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// ambil user
$userQ = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id");
$user = mysqli_fetch_assoc($userQ);

// mentor
$mentor = null;
$id_mentor = null;

if ($role == 'mentor') {
    $mQ = mysqli_query($conn, "SELECT * FROM mentor_profiles WHERE id_user = $id");
    $mentor = mysqli_fetch_assoc($mQ);
    $id_mentor = $mentor['id_mentor'] ?? null;
}

// ================= UPDATE PROFILE =================
if (isset($_POST['update_profile'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $fotoPath = $user['foto_profil'];

    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {

        $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
        $newName = "uploads/profile_" . time() . "." . $ext;

        move_uploaded_file($_FILES['foto_profil']['tmp_name'], $newName);

        $fotoPath = $newName;
    }

    mysqli_query($conn, "
        UPDATE users 
        SET nama='$nama', foto_profil='$fotoPath'
        WHERE id_user = $id
    ");

    $_SESSION['nama'] = $nama;

    header("Location: profile.php");
    exit;
}

// ================= UPDATE MENTOR =================
if (isset($_POST['save_mentor'])) {

    $bio = mysqli_real_escape_string($conn, $_POST['biografi']);
    $pengalaman = mysqli_real_escape_string($conn, $_POST['pengalaman']);

    $cvPath = $mentor['cv'] ?? '';

    if (!empty($_FILES['cv']['name'])) {

        $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
        $cvPath = "uploads/cv_" . time() . "." . $ext;

        move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
    }

    mysqli_query($conn, "
        UPDATE mentor_profiles 
        SET biografi='$bio', pengalaman='$pengalaman', cv='$cvPath'
        WHERE id_user = $id
    ");

    header("Location: profile.php");
    exit;
}

// ================= STATS =================
if ($role == 'mentor' && $id_mentor) {

    $total = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(*) as total 
        FROM booking b
        JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
        WHERE ms.id_mentor = $id_mentor
    "))['total'];

    $completed = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(*) as total 
        FROM booking b
        JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
        WHERE ms.id_mentor = $id_mentor AND b.status='completed'
    "))['total'];

    $ongoing = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(*) as total 
        FROM booking b
        JOIN mentor_schedule ms ON b.id_schedule = ms.id_schedule
        WHERE ms.id_mentor = $id_mentor AND b.status='ongoing'
    "))['total'];

} else {

    $total = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) as total FROM booking WHERE id_user = $id"))['total'];

    $completed = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) as total FROM booking WHERE id_user = $id AND status='completed'"))['total'];

    $ongoing = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) as total FROM booking WHERE id_user = $id AND status='ongoing'"))['total'];
}

// ================= FOTO =================
$foto = !empty($user['foto_profil']) ? $user['foto_profil'] : "image/default.jpg";
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
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-gray-100 pt-24">

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="relative h-[220px]">
    <img src="image/wanita-belajar.jpg" class="w-full h-full object-cover">
    <div class="absolute bottom-6 left-12 text-white">
        <h1 class="text-2xl font-bold">
            Welcome, <?= $_SESSION['nama']; ?> 👋
        </h1>
        <p class="text-sm">Manage your account here</p>
    </div>
</section>

<section class="px-12 py-8 grid md:grid-cols-3 gap-8">

    <!-- LEFT -->
    <div class="bg-white rounded-2xl shadow p-6 text-center">

        <!-- FOTO PROFIL -->
    <?php 
$foto = $user['foto_profil'];

if (!empty($foto) && $foto != 'default.jpg' && file_exists($foto)): 
?>

    <img src="<?= $foto ?>" 
         class="w-24 h-24 mx-auto rounded-full object-cover shadow-md">

<?php else: ?>

    <div class="w-24 h-24 mx-auto rounded-full bg-[#B6DCFF] 
    flex items-center justify-center text-2xl font-bold text-[#175BAF] shadow-md">
        <?= strtoupper(substr($user['nama'], 0, 1)); ?>
    </div>

<?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">

            <input type="text" name="nama"
            value="<?= $user['nama']; ?>"
            class="w-full border px-3 py-2 rounded-lg text-center">

            <input type="file" name="foto_profil" class="text-sm">

            <button type="submit" name="update_profile"
            class="w-full bg-[#175BAF] text-white py-2 rounded-lg text-sm hover:scale-105 transition">
                Save Changes
            </button>

        </form>

        <p class="text-gray-500 text-sm mt-3">
            <?= $user['email']; ?>
        </p>

    </div>

    <!-- RIGHT -->
    <div class="md:col-span-2 space-y-6">

        <!-- INFO -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold text-[#2F5789] mb-4">Account Info</h3>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Full Name</p>
                    <p><?= $user['nama']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Email</p>
                    <p><?= $user['email']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Role</p>
                    <p><?= ucfirst($role); ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Status</p>
                    <p class="text-green-500">Active</p>
                </div>
            </div>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-3 gap-4">

            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-400">Total Sessions</p>
                <p class="text-xl font-bold text-[#2F5789]"><?= $total ?></p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-400">Completed</p>
                <p class="text-xl font-bold text-[#2F5789]"><?= $completed ?></p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-sm text-gray-400">Ongoing</p>
                <p class="text-xl font-bold text-[#2F5789]"><?= $ongoing ?></p>
            </div>

        </div>

        <!-- MENTOR -->
        <?php if ($role == 'mentor'): ?>

        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="font-semibold text-[#2F5789] mb-4">
                Mentor Profile
            </h3>

            <form method="POST" enctype="multipart/form-data" class="space-y-4">

                <textarea name="biografi" rows="3"
                class="w-full px-3 py-2 border rounded-lg"
                placeholder="Biography"><?= $mentor['biografi'] ?? '' ?></textarea>

                <textarea name="pengalaman" rows="3"
                class="w-full px-3 py-2 border rounded-lg"
                placeholder="Experience"><?= $mentor['pengalaman'] ?? '' ?></textarea>

                <input type="file" name="cv">

                <?php if (!empty($mentor['cv'])): ?>
                    <a href="/ProjectPemWeb/<?= $mentor['cv'] ?>" target="_blank">
                     View CV
                    </a>
                <?php endif; ?>

                <button type="submit" name="save_mentor"
                class="bg-[#175BAF] text-white px-4 py-2 rounded-lg">
                    Save
                </button>

            </form>

        </div>

        <?php endif; ?>

    </div>

</section>

</body>
</html>