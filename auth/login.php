<?php
session_start();
require 'config.php';

// 1. Cek Cookie: Jika ada cookie, otomatis buat session
if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])) {
    $id = $_COOKIE['user_id'];
    $key = $_COOKIE['user_key'];

    $result = mysqli_query($conn, "SELECT email FROM users WHERE id = $id");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($key === hash('sha256', $row['email'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $id;
            $_SESSION['nama'] = $row['nama'] ?? 'User';
        }
    }
}

// 2. Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// 3. Proses Login ketika tombol 'login' diklik
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];

            // Set Cookie jika Remember Me dicentang
            if (isset($_POST['remember'])) {
                setcookie('user_id', $row['id'], time() + (60 * 60 * 24 * 30), "/");
                setcookie('user_key', hash('sha256', $row['email']), time() + (60 * 60 * 24 * 30), "/");
            }

            // Redirect menggunakan PHP header (lebih aman dari JS window.location)
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Masuk - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2 class="text-2xl font-bold">Sign In</h2>
                <p>continue to your account MentorCampus</p>
            </div>    

            <?php if ($error !== "") : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4 text-sm text-center">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form class="login-form" id="loginForm" method="POST" action="" novalidate>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder=" " required autocomplete="email">
                        <label for="email">email</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" placeholder=" " required autocomplete="current-password">
                        <label for="password">password</label>
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <span class="eye-icon"></span>
                        </button>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-option">
                    <label class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkbox-label">
                            <span class="checkmark"></span>
                            Remember me
                        </span>
                    </label>
                    <a href="#" class="forgot-password text-blue-600">Forgot Password?</a>
                </div>

                <button type="submit" name="login" class="login-btn btn">
                    <span class="btn-text">Sign In</span>
                    <span class="btn-loader"></span>
                </button>
            </form>

            <div class="divider">
                <span>or continue with</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn google-btn">
                    <span class="sosial-icon google-icon"></span> Google
                </button>
                <button type="button" class="social-btn github-btn"> 
                    <span class="social-icon github-icon"></span> Github
                </button>
            </div>

            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php" class="text-blue-600 font-bold">Sign Up</a></p>
            </div>
        </div>
    </div>

    <div id="errorPopup" class="popup-overlay hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="popup-content bg-white p-6 rounded-lg shadow-xl text-center">
            <p id="popupMessage" class="text-red-600 mb-4 font-medium"></p>
            <button id="closePopup" class="bg-red-600 text-white px-4 py-2 rounded">OK</button>
        </div>
    </div>

    <script src="script.js" defer></script>
</body>
</html>