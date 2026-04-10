<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
?>

<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- WAJIB DI SINI -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

<?php include 'navbar-admin.php'; ?>

<h1 class="mt-24 text-center text-2xl font-bold">Admin Dashboard</h1>

</body>
</html>