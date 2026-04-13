<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// DELETE USER
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM users WHERE id_user = $id");

    header("Location: admin-users.php");
    exit;
}

// AMBIL DATA USER
$users = mysqli_query($conn, "
SELECT * FROM users
ORDER BY id_user DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-gray-100 pt-24">

<?php include 'navbar-admin.php'; ?>

<!-- HERO -->
<section class="relative h-[220px] flex items-center justify-center text-center overflow-hidden">

    <div class="absolute inset-0 bg-[#175BAF]"></div>

    <div class="relative z-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Manage Users</h1>
        <p class="text-sm opacity-90">
            View and control all registered users
        </p>
    </div>

</section>

<!-- CONTENT -->
<section class="px-6 py-10">

<div class="max-w-6xl mx-auto">

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-[#175BAF]">
                User List
            </h2>
        </div>

        <?php if (mysqli_num_rows($users) > 0): ?>

        <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">

            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Gender</th>
                    <th class="px-6 py-3">Semester</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            <?php while($row = mysqli_fetch_assoc($users)): ?>

            <tr class="hover:bg-gray-50 transition">

                <!-- USER -->
                <td class="px-6 py-4 flex items-center gap-4">

                    <?php if (!empty($row['foto_profil']) && file_exists($row['foto_profil'])): ?>
                        <img src="<?= $row['foto_profil']; ?>" 
                             class="w-10 h-10 rounded-full object-cover">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-full bg-[#B6DCFF] flex items-center justify-center text-[#175BAF] font-bold">
                            <?= strtoupper(substr($row['nama'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <p class="font-medium"><?= $row['nama']; ?></p>
                        <p class="text-xs text-gray-400"><?= $row['email']; ?></p>
                    </div>

                </td>

                <!-- GENDER -->
                <td class="px-6 py-4">
                    <?= !empty($row['gender']) ? ucfirst($row['gender']) : '-' ?>
                </td>

                <!-- SEMESTER -->
                <td class="px-6 py-4">
                    <?= !empty($row['semester']) ? $row['semester'] : '-' ?>
                </td>

                <!-- ROLE -->
                <td class="px-6 py-4">
                    <span class="text-xs px-3 py-1 rounded-full
                    <?= 
                        ($row['role'] == 'admin') ? 'bg-purple-100 text-purple-600' :
                        (($row['role'] == 'mentor') ? 'bg-blue-100 text-blue-600' :
                        'bg-gray-100 text-gray-600')
                    ?>">
                        <?= ucfirst($row['role']); ?>
                    </span>
                </td>

                <!-- ACTION -->
                <td class="px-6 py-4 text-center">

                    <a href="?hapus=<?= $row['id_user']; ?>"
                       onclick="return confirm('Hapus user ini?')"
                       class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs hover:scale-105 transition">
                        Delete
                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

            </tbody>

        </table>
        </div>

        <?php else: ?>

        <div class="p-10 text-center text-gray-500">
            Belum ada user 😢
        </div>

        <?php endif; ?>

    </div>

</div>

</section>

</body>
</html>