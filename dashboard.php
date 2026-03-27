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
                <a class="" href="#">Profile Mentor</a>
                <a class="" href="#">Booking Mentor</a>
                <a class="" href="#">Module</a>
                <a class="" href="#">About Us</a>
                <a class="" href="#">Login</a>
                <a class="" href="#">Sign Up</a>
            </nav>
        </div>
    </div>
    <footer class="">
        <div class="">
            <div>
                <div>
                    <h1></h1>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>