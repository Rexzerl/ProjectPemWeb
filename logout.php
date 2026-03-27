<?php
session_start();
session_unset();
session_destroy();

// Hapus Cookie
setcookie('user_email', '', time() - 3600, "/");

header("Location: login.php");
exit;
?>