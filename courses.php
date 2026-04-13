<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

// Ambil input dari filter
$search   = $_GET['search'] ?? '';
$subject  = $_GET['subject'] ?? '';
$kampus   = $_GET['kampus'] ?? '';
$semester = $_GET['semester'] ?? '';
$gender   = $_GET['gender'] ?? '';

// Ambil data untuk dropdown filter
$kampusList = mysqli_query($conn, "
    SELECT DISTINCT k.nama_kampus
    FROM mentor_profiles mp
    JOIN kampus k ON mp.id_kampus = k.id_kampus
    ORDER BY k.nama_kampus ASC
");
$subjectList = mysqli_query($conn, "SELECT DISTINCT spesialisasi FROM mentor_profiles WHERE spesialisasi IS NOT NULL");
$genderList = mysqli_query($conn, "SELECT DISTINCT gender FROM users WHERE gender IS NOT NULL");

// QUERY DATABASE (Base)
$query = "
SELECT 
    ms.id_schedule, ms.tanggal, ms.jam, ms.harga,
    mp.id_mentor, mp.jurusan, mp.spesialisasi,
    u.nama, u.semester, u.foto_profil,
    k.nama_kampus,
    rating_data.avg_rating, rating_data.total_review
FROM mentor_schedule ms
JOIN mentor_profiles mp ON ms.id_mentor = mp.id_mentor
JOIN users u ON mp.id_user = u.id_user
JOIN kampus k ON mp.id_kampus = k.id_kampus
LEFT JOIN (
    SELECT 
        mp.id_mentor,
        AVG(tr.rating) as avg_rating,
        COUNT(tr.id_review) as total_review
    FROM mentor_profiles mp
    LEFT JOIN mentor_schedule ms ON mp.id_mentor = ms.id_mentor
    LEFT JOIN booking b ON ms.id_schedule = b.id_schedule
    LEFT JOIN transaksi_review tr ON b.id_booking = tr.id_booking
    GROUP BY mp.id_mentor
) as rating_data ON mp.id_mentor = rating_data.id_mentor
WHERE ms.status = 'available' AND ms.harga > 0
";

// Tambahkan Filter ke Query
if (!empty($search)) {
    $query .= " AND (u.nama LIKE '%$search%' OR mp.spesialisasi LIKE '%$search%' OR mp.jurusan LIKE '%$search%')";
}
if (!empty($subject)) {
    $query .= " AND mp.spesialisasi LIKE '%$subject%'";
}
if (!empty($kampus)) {
    $query .= " AND k.nama_kampus = '$kampus'";
}
if (!empty($semester)) {
    list($min, $max) = explode('-', $semester);
    $query .= " AND u.semester BETWEEN $min AND $max";
}
if (!empty($gender)) {
    $query .= " AND u.gender = '$gender'";
}

$query .= " GROUP BY ms.id_schedule ORDER BY ms.tanggal ASC, ms.jam ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Lexend', sans-serif; }</style>
</head>
<body class="bg-gray-100 pt-24">

<?php include 'navbar.php'; ?>

<section class="relative h-[400px] overflow-hidden">
    <img src="./image/wanita-belajar.jpg" class="absolute w-full h-full object-cover z-0">
    <div class="absolute inset-0 bg-black/30 z-10"></div>
    <div class="relative z-20 px-12 pt-28 text-white">
        <h1 class="text-3xl font-semibold mb-6">Find Your Mentor & Start Learning</h1>
        <form method="GET">
            <div class="flex items-center bg-white rounded-full shadow-lg px-4 py-2 w-[600px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                </svg>
                <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>" placeholder="Search mentor, skill..." class="w-full outline-none text-sm text-gray-600 bg-transparent">
                <button type="submit" class="bg-[#175BAF] text-white text-sm px-4 py-1.5 rounded-full hover:scale-105 transition">Search</button>
            </div>
        </form>
    </div>
</section>

<section class="px-12 py-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Recommended Mentors</h2>
            <select class="border rounded-lg px-3 py-1 text-sm">
                <option>Sort by</option>
                <option>Highest Rating</option>
                <option>Lowest Price</option>
            </select>
        </div>

        <div class="space-y-6">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($mentor = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white rounded-xl shadow p-5 flex gap-5 items-center hover:shadow-lg transition relative">
                        <?php if (!empty($mentor['foto_profil']) && $mentor['foto_profil'] != 'default.jpg'): ?>
                            <img src="<?= $mentor['foto_profil'] ?>" class="w-32 h-32 object-cover rounded-full">
                        <?php else: ?>
                            <div class="w-32 h-32 rounded-full bg-[#B6DCFF] flex items-center justify-center text-3xl font-bold text-[#175BAF]">
                                <?= strtoupper(substr($mentor['nama'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex-1 pb-10">
                            <p class="text-sm text-gray-500"><?= $mentor['nama_kampus']; ?> • Semester <?= $mentor['semester']; ?></p>
                            <h3 class="font-semibold text-lg"><?= $mentor['nama']; ?></h3>
                            <p class="text-[#175BAF] font-semibold mt-2">Rp <?= number_format($mentor['harga'] ?? 0, 0, ',', '.') ?> <span class="text-xs text-gray-400">/45 Menit</span></p>
                            <div class="text-sm text-gray-500 mt-1"><?= $mentor['jurusan']; ?> • <?= $mentor['spesialisasi']; ?></div>
                            <p class="text-sm text-gray-500 mt-1"><?= date('d M Y', strtotime($mentor['tanggal'])) ?> • <?= date('H:i', strtotime($mentor['jam'])) ?> WIB</p>
                            
                            <?php if ($mentor['avg_rating']): ?>
                                <span class="text-yellow-500 font-semibold">⭐ <?= number_format($mentor['avg_rating'], 1); ?></span>
                                <span class="text-gray-500 text-xs">(<?= $mentor['total_review']; ?> review)</span>
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">Belum ada rating</span>
                            <?php endif; ?>

                            <div class="flex gap-2 mt-3">
                                <a href="mentor-detail.php?id=<?= $mentor['id_mentor']; ?>" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">Detail</a>
                                <a href="booking.php?id_schedule=<?= $mentor['id_schedule']; ?>&action=book" class="bg-[#175BAF] text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-md hover:scale-105 transition">Book</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center text-gray-500 py-10">Mentor not found 😢</div>
            <?php endif; ?>
        </div> 
    </div> 

    <div class="bg-white rounded-xl shadow p-6 self-start h-fit">
        <form method="GET">
            <h3 class="font-semibold mb-4 text-lg border-b pb-2">Filter Mentor</h3>

            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700">Subject</label>
                <input type="text" name="subject" list="subjectList" value="<?= $_GET['subject'] ?? '' ?>" placeholder="Algoritma, PHP..." class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                <datalist id="subjectList">
                    <?php while($s = mysqli_fetch_assoc($subjectList)): ?>
                        <option value="<?= $s['spesialisasi']; ?>">
                    <?php endwhile; ?>
                </datalist>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700">Campus</label>
                <select name="kampus" class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">All Campus</option>
                    <?php mysqli_data_seek($kampusList, 0); while($k = mysqli_fetch_assoc($kampusList)): ?>
                        <option value="<?= $k['nama_kampus']; ?>" <?= ($kampus == $k['nama_kampus']) ? 'selected' : '' ?>>
                            <?= $k['nama_kampus']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700">Semester</label>
                <select name="semester" class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">All Semester</option>
                    <option value="1-2" <?= ($semester == '1-2') ? 'selected' : '' ?>>1 - 2</option>
                    <option value="3-4" <?= ($semester == '3-4') ? 'selected' : '' ?>>3 - 4</option>
                    <option value="5-6" <?= ($semester == '5-6') ? 'selected' : '' ?>>5 - 6</option>
                    <option value="7-8" <?= ($semester == '7-8') ? 'selected' : '' ?>>7 - 8</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">All Gender</option>
                    <?php mysqli_data_seek($genderList, 0); while($g = mysqli_fetch_assoc($genderList)): ?>
                        <option value="<?= $g['gender']; ?>" <?= ($gender == $g['gender']) ? 'selected' : '' ?>>
                            <?= ucfirst($g['gender']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-[#175BAF] text-white py-2.5 rounded-lg text-sm font-bold shadow-lg hover:bg-blue-700 transition">
                Apply Filters
            </button>
            
           <?php if(!empty($_GET['search']) || !empty($_GET['subject']) || !empty($_GET['kampus']) || !empty($_GET['semester']) || !empty($_GET['gender'])): ?>
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" 
       class="block text-center text-xs text-red-500 mt-4 font-semibold hover:underline cursor-pointer">
        Reset All Filters
    </a>
<?php endif; ?>
        </form>
    </div>

</section>

</body>
</html>