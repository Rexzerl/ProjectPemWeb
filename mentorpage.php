<?php
session_start();
if (!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Lexend', sans-serif;
        }
        body {background-color: #f8f9fa; }
        .sidebar {min-height: 100vh; background: #003366; color: white; }
        .sidebar a { color: white; text-decoation: none; padding: 15px; display: block; }
        .sidebar a:hover {background: #004080; }
        .content {padding: 20px; }
        .card-stat {border: none; border-radius: 10px; transition: 0.3s; }
        .card-stst:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-[#F5F7FA] pt-24">
    <?php include 'navbar.php'; ?>
</body>
</html>