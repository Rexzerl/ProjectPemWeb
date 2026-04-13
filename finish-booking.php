<?php
session_start();
require 'config.php';

$id_booking = $_GET['id'];

// update status jadi completed
mysqli_query($conn, "
    UPDATE booking 
    SET status = 'completed'
    WHERE id_booking = $id_booking
");

// BALIK KE PROFILE 
header("Location: profile.php?done=1");
exit;