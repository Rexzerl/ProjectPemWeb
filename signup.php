<?php
require 'config.php';

if (isset($_POST['signup'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['repeat-password'];

    // Cek email sudah ada atau belum
    $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>alert('Email sudah digunakan!');</script>";
    } else {
        if ($password === $confirm_password) {
            // Hashing Password
            $password_safe = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password_safe')";
            
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registrasi Berhasil! Silahkan Login.'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Mentor Campus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <div class="signup-header">
                <h2 class="text-2xl font-bold">Sign Up</h2>
                <p>Create Mentor Campus account</p>
            </div>

            <form class="signup-form" action="" method="POST">
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="name" name="name" required placeholder=" ">
                        <label for="name">Name</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required placeholder=" ">
                        <label for="email">Email</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required placeholder=" ">
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle"><span class="eye-icon"></span></button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="repeat-password" name="repeat-password" required placeholder=" ">
                        <label for="repeat-password">Repeat password</label>
                        <button type="button" class="password-toggle"><span class="eye-icon"></span></button>
                    </div>
                </div>

                <button type="submit" name="signup" class="signup-btn btn">Sign Up</button>
            </form>

            <div class="signup-link">
                <p>Already have an account? <a href="index.php">Sign In</a></p>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>