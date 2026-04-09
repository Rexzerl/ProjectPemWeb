<?php
session_start();
<<<<<<< HEAD
session_unset();
session_destroy();

// Hapus Cookie
setcookie('user_email', '', time() - 3600, "/");

header("Location: login.php");
=======

session_unset();
session_destroy();

setcookie('user_id', '', time() - 3600, "/");
setcookie('user_key', '', time() - 3600, "/");

header("Location: index.php"); // atau login.php
>>>>>>> main
exit;
?>