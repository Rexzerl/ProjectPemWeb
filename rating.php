<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id_booking = $_GET['id'] ?? 0;

// ambil data rating kalau sudah ada
$cek = mysqli_query($conn, "
    SELECT * FROM transaksi_review 
    WHERE id_booking = $id_booking
");

$dataRating = mysqli_fetch_assoc($cek);
$sudahRating = $dataRating ? true : false;

// kalau submit
if (isset($_POST['submit'])) {

    $rating = (int) $_POST['rating'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    if ($sudahRating) {

        mysqli_query($conn, "
            UPDATE transaksi_review
            SET rating = $rating, komentar = '$komentar'
            WHERE id_booking = $id_booking
        ");

    } else {

        mysqli_query($conn, "
            INSERT INTO transaksi_review (id_booking, rating, komentar)
            VALUES ($id_booking, $rating, '$komentar')
        ");
    }

    header("Location: rating.php?id=$id_booking");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rating Mentor</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Lexend', sans-serif;
}
</style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="max-w-lg w-full bg-white p-8 rounded-3xl shadow-xl">

    <!-- HEADER -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-[#175BAF]">
            ⭐ Rating Mentor
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Bagikan pengalaman belajarmu
        </p>
    </div>

    <form method="POST" class="space-y-5">

    <!-- RATING -->
    <div>
        <label class="block text-sm mb-2 font-medium">
            Rating
        </label>

        <select name="rating"
        class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#175BAF]">

            <?php for ($i = 5; $i >= 1; $i--): ?>
                <option value="<?= $i; ?>"
                <?= ($sudahRating && $dataRating['rating'] == $i) ? 'selected' : '' ?>>
                    <?= str_repeat('⭐', $i); ?> (<?= $i; ?>)
                </option>
            <?php endfor; ?>

        </select>
    </div>

    <!-- KOMENTAR -->
    <div>
        <label class="block text-sm mb-2 font-medium">
            Komentar
        </label>

        <textarea name="komentar" rows="3"
        class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#175BAF]"
        placeholder="Ceritakan pengalamanmu (opsional)..."><?= $sudahRating ? $dataRating['komentar'] : '' ?></textarea>
    </div>

    <?php if ($sudahRating): ?>
        <p class="text-sm text-green-600">
            Kamu sudah memberi rating, silakan update jika ingin mengubah 😊
        </p>
    <?php endif; ?>

    <!-- BUTTON -->
    <button type="submit" name="submit"
    class="w-full bg-[#175BAF] text-white py-3 rounded-lg font-medium hover:scale-105 transition">

        <?= $sudahRating ? 'Update Rating' : 'Kirim Rating'; ?>

    </button>

    <!-- BACK -->
    <a href="profile.php"
    class="block text-center text-sm text-gray-500 hover:underline">
        ← Kembali
    </a>

</form>

</div>

</body>
</html>