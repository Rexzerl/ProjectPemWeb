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
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#a93802",
                        "on-surface": "#191c1e",
                        "primary-container": "#0056d2",
                        "surface-container-lowest": "#ffffff",
                        "secondary": "#4a5d8e",
                        "on-primary-container": "#ccd8ff",
                        "on-primary-fixed-variant": "#0040a1",
                        "on-surface-variant": "#424654",
                        "secondary-fixed": "#dae2ff",
                        "surface-container-high": "#e6e8ea",
                        "on-secondary": "#ffffff",
                        "surface-container-highest": "#e0e3e5",
                        "on-error": "#ffffff",
                        "surface-container": "#eceef0",
                        "surface": "#f7f9fb",
                        "on-primary-fixed": "#001847",
                        "inverse-surface": "#2d3133",
                        "error-container": "#ffdad6",
                        "inverse-primary": "#b2c5ff",
                        "surface-dim": "#d8dadc",
                        "primary-fixed-dim": "#b2c5ff",
                        "surface-tint": "#0056d2",
                        "error": "#ba1a1a",
                        "tertiary": "#822800",
                        "surface-container-low": "#f2f4f6",
                        "on-secondary-fixed-variant": "#324575",
                        "surface-variant": "#e0e3e5",
                        "primary-fixed": "#dae2ff",
                        "inverse-on-surface": "#eff1f3",
                        "on-tertiary-fixed": "#380d00",
                        "outline": "#737785",
                        "on-primary": "#ffffff",
                        "on-background": "#191c1e",
                        "tertiary-fixed": "#ffdbcf",
                        "outline-variant": "#c3c6d6",
                        "on-tertiary-container": "#ffcebd",
                        "on-secondary-container": "#3e5181",
                        "secondary-container": "#b3c5fd",
                        "primary": "#0040a1",
                        "tertiary-fixed-dim": "#ffb59b",
                        "background": "#f7f9fb",
                        "surface-bright": "#f7f9fb",
                        "on-secondary-fixed": "#001847",
                        "secondary-fixed-dim": "#b3c5fd",
                        "on-tertiary-fixed-variant": "#812800",
                        "on-error-container": "#93000a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        body {font-family: 'Inter', sans-serif; background-color: #f7f9fb;; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .profile-gradient { background: linear-gradient(135deg, #0040a1 0%, #0056d2 100%); }
    </style>
</head>
<body class="text-on-surface antialiased">
    <?php include 'navbar.php'; ?>
    <main class="pt-20 pb-20">
        <section class="profile-gradient pt-12 pb-16 px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-5 flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="relative group">
                        <div class="w-40 h-40 rounded-full overflow-hidden ring-4 ring-white/20">
                            <img class= "w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDfHdj7ev8FO1XzEsB1gvJ7VrnUHv_zszIyBoVGdZM-_PBt_A-F0r9uTsGYMf8R50QQ3P4Mv-0r132OJeax-dhcWezKl3QeruQx1S9IGdxoFMb6L4bftycke_FcVCMFywuK8lw4yJqK7NNfvsB8tnsPWbdkbjsgj_QxmORXzGskE18KzjF9Epc2BKtZS-EDID3A0DEZlY_SAj0dIaBn66u6W-PlRf1rsX7GOQmji_1HJrxtSrhg4xbWtgmzyhPSpbx-SEK6LF73YvfM" alt="Mentor Profile">
                        </div>
                        <button class="absolute bottom-2 right-2 bg-white/80 text-primary p-2 rounded-full shadow-lg hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </button>
                    </div>
                    <div class="space-y-3 text-center md:text-left pt-2">
                        <div class="fles fles-col md:flex-row items-center gap-2">
                            <h1 class="text-white/100 font-bold"><?= $_SESSION['nama']; ?>
                            <span class="material-symbols-outlined text-blue-400 bg-transparent rounded-full p-0.5" style="font-variation-settings: 'FILL' 1">verified</span>
                            </h1>
                        </div>
                        <div class="space-y-1">
                            <p class="text-white/90 font-medium text-lg">Sistem Informasi - Semester 4</p> <!-- prodi -->
                            <p class="text-white/70 font-medium">UPN "Veteran" Jawa Timur</p> <!-- kampus -->
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-7 grid grid-cols-2 gap-6">
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/10 flex flex-col justify-between h-40">
                        <span class="material-symbols-outlined text-white/60">calendar_month</span>
                        <div>
                            <p class="text-4xl font-headline font-extrabold text-white">12</p>
                            <p class="text-xs uppercase tracking-widest text-white/60">Booking Aktif</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/10 flex flex-col justify-between h-40">
                        <span class="material-symbols-outlined text-white/60">task_alt</span>
                        <div>
                            <p class="text-4xl font-headline font-extrabold text-white">148</p>
                            <p class="text-xs font-label uppercase tracking-widest text-white/60">selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="max-w-7xl mx-auto px-6 space-y-12 mt-8">
            <section class="bg-surface-container-lowest rounded-x1 shadow-x1 shadow-black/5 overflow-hidden p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4">
                    <h2 class="text-2xl font-headline font-bold text-primary">Atur Jadwal</h2>
                    <button class="bg-primary text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:bg-blue-800 transition-all">
                        <span class="material-symbols-outlined text-xl">add_circle</span>Tambah Jadwal
                    </button>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-4 bg-surface-container-low rounded-xl p-5">
                        <div class="flex items-center justify-between mb-6">
                            <h3 id=currentMonthYear class="font-headline font-bold text-lg text-on-surface"></h3>
                            <div class="flex gap-1">
                                <button onclick="changeMonth(-1)" class="p-1.5 hover:bg-surface-container-high rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-base">chevron_left</span>
                                </button>
                                <button onclick="changeMonth(1)" class="p-1.5 hover:bg-surface-container-high rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-base">chevron_right</span>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-on-surface-variant mb-4">
                            <span>MIN</span><span>SEN</span><span>SEL</span><span>RAB</span><span>KAM</span><span>JUM</span><span>SAB</span>
                        </div>
                        <div id="calendarDays" class="grid grid-cols-7 gap-1"></div>
                        <div class="mt-8 pt-6 border-t border-outline-variant/30">
                            <div class="flex justify-between items-center mb-4">    
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-4">
                                    Slot Waktu (<span id="selectedDateDisplay">Pilih Tanggal</span>)
                                </p>
                            </div>
                            <div id="timeSlotContainer" class="flex flex-col gap-2 max-h-60 overflow-y-auto no-scrollbar">
                                <p class="text-xs text-on-surface-variant italic py-2 text-center">Belum ada jam operasional></p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-8 space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-bold text-on-surface uppercase tracksing-widest">Sesi Mendatang</p>
                            <span class="text-xs text-on-surface-variant font-medium">3 Sesi Terjadwal</span>
                        </div>
                        <div class="space-y-4">
                            <div class="p-5 bg-white border border-surface-container-high rounded-xl shadow-sm hover:shadow-md transition-all group">
                                <div class="flex flex-col md:flex-row justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 bg-secondary-fixed">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Budi" alt="student">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-on-surface">Budi Santoso</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="material-symbols-outlined text-primary text-sm">Schedule</span>
                                                <p class="text-xs font-semibold text-primary">Hari ini • 09:00 - 10:00</p>
                                            </div>
                                            <p class="text-xs text-on-surface-variant mt-2">Pemrograman Web</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 self-end md:self-center">
                                        <button class="text-xs font-bold text-error px-3 py-2 hover:bg-error/5 rounded-lg transition-colors">Batalkan</button>
                                        <button class="bg-primary text-white px-5 py-2 rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform flex items-center gap-2">
                                            <span>Mulai</span>
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                <div onclick="addNewTimeSlot()" class="p-6 border-2 border-primary bg-primary/5 rounded-xl shadow-inner space-y-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1">add_circle</span>
                                            <h4 class="font-bold text-primary uppercase text-xs tracking-widest">Tambah Jam Operasional</h4>
                                        </div>
                                            <button class="text-on-surface-variant hover:text-error transition-colors">
                                                <span class="material-symbols-outlined text-xl">close</span>
                                            </button>    
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-headline font-bold text-primary">Histori Mentoring</h2>
                    <button class="text-primary font-bold font-label text-sm flex items-center gap-1 hover:underline">
                        Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="group bg-white p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 shadow-sm hover:shadow-md transition-all border-l-4 border-transparent hover:border-primary">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden ring-2 ring-primary/5">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Siti" alt="student">
                        </div>
                        <div class="flex-grow space-y-1 text-center md:text-left">
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                                <h4 class="font-headline font-bold text-lg text-on-surface">Siti Aminah</h4>
                                <span class="px-2.5 py-0.5 bg-primary/10 text-primary rounded-full text-[10px] font-bold uppercase tracking-wider">Pemrograman Mobile</span>
                            </div>
                            <p class="text-sm text-on-surface-variant">Belajar dasar flutter</p>
                        </div>
                        <div class="flex flex-col items-center md:items-end text-center md:text-right">
                            <p class="text-sm font-bold text-primary">10 Okt 2025</p>
                            <p class="text-xs text-on-surface-variant font-medium">45 Menit • On-Campus</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        let currentDate = new Date();
        let selectedFullDate = "";

        function renderCalendar() {
            const monthYearText = document.getElementById('currentMonthYear');
            const daysContainer = document.getElementById('calendarDays');
            const selectedLabel = document.getElementById('selectedDateDisplay');
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            
            // Update header bulan & tahun
            monthYearText.innerHTML = `${months[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            // Kalkulasi hari
            const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
            const lastDateOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
            const today = new Date();

            daysContainer.innerHTML = "";

            // Buat slot kosong untuk hari sebelum tanggal 1
            for (let i = 0; i < firstDayOfMonth; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = "h-9";
                daysContainer.appendChild(emptyDiv);
            }
            // Isi tanggal
            for (let i = 1; i <= lastDateOfMonth; i++) {
                const daySquare = document.createElement('div');
                const isToday = i === today.getDate() && currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear();
                
                daySquare.className = `h-9 flex items-center justify-center text-xs cursor-pointer rounded-lg transition-all 
                                    ${isToday ? 'bg-primary text-white font-bold shadow-sm' : 'font-medium hover:bg-primary/10 text-on-surface'}`;
                daySquare.innerText = i;
                
                if (isToday && selectedFullDate === "") {
                    selectDate(i, months[currentDate.getMonth()], currentDate.getFullYear(), daySquare);
                }

                daySquare.onclick = () => {
                    selectDate(i, months[currentDate.getMonth()], currentDate.getFullYear(), daySquare);
                };

                daysContainer.appendChild(daySquare);
            }
        }

        function changeMonth(offset) {
            currentDate.setMonth(currentDate.getMonth() + offset);
            renderCalendar();
        }

        // Inisialisasi awal
        renderCalendar();

        let currentDt = new Date();

        //Fungsi Tambah Jam (Slot Waktu)
        function addNewTimeSlot() {
            const container = document.getElementById('timeSlotContainer');
            
           if (container.querySelector('p.italic')) {
                container.innerHTML = "";
            }

            // Meminta input user (Simulasi, bisa diganti dengan Modal)
            const start = prompt("Jam Mulai (HH:MM):", "09:00");
            const end = prompt("Jam Selesai (HH:MM):", "10:00");

            if (start && end) {
                const slotDiv = document.createElement('div');
                slotDiv.className = "flex items-center justify-between p-3 bg-white border border-outline-variant text-on-surface rounded-lg text-xs font-medium hover:bg-gray-50 transition-all";
                slotDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                        <span class="text-sm font-bold text-on-surface">${start} - ${end}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-error hover:bg-error/10 p-1 rounded-full transition-colors">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                `;
                container.appendChild(slotDiv);
            }
        }

        function saveFinalJadwal() {
            const slots = document.querySelectorAll('#timeSlotContainer div');
            if (slots.length === 0) {
                alert("Silakan tambah jam operasional terlebih dahulu!");
                return;
            }

            let jamList = [];
            slots.forEach(slot => {
                jamList.push(slot.querySelector('span.text-on-surface').innerText);
            });

            alert(`Jadwal Berhasil Disimpan!\nTanggal: ${selectedFullDate}\nJam: ${jamList.join(", ")}`);
            // Di sini Anda bisa mengirim data via AJAX ke backend PHP Anda
        }

        renderCalendar();
        </script>
</body>
</html>