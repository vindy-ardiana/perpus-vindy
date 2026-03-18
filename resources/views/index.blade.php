<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-sky-100 text-gray-800 overflow-x-hidden">

<!-- ================= NAVBAR ================= -->
<nav class="fixed w-full z-50">
    <div class="bg-gradient-to-r from-blue-600/80 via-indigo-600/70 to-sky-500/80 backdrop-blur-xl shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <!-- LOGO -->
            <h1 class="text-xl font-extrabold text-white tracking-wide">
                Literia
            </h1>

            <!-- MENU -->
            <div class="hidden md:flex items-center space-x-8 font-medium text-white">
                <a href="#home" class="relative group">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-sky-200 transition-all group-hover:w-full"></span>
                </a>

                <a href="#kategori" class="relative group">
                    Kategori
                    <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-sky-200 transition-all group-hover:w-full"></span>
                </a>

                <a href="#koleksi" class="relative group">
                    Koleksi
                    <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-sky-200 transition-all group-hover:w-full"></span>
                </a>

                <a href="/login" class="px-5 py-2 rounded-xl ">Login</a>
            </div>

        </div>
    </div>
</nav>


<!-- ================= HERO ================= -->
<section id="home" class="relative pt-32 pb-28">

    <!-- BLUR GRADIENT -->
    <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-blue-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute top-20 -right-40 w-[500px] h-[500px] bg-indigo-300 rounded-full blur-3xl opacity-30"></div>

    <div class="relative max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

        <!-- TEXT -->
        <div>
<div class="-mt-10  ml-10">
    <h2 class="text-5xl font-extrabold leading-tight mb-6">
        Temukan<br>
        <span class="text-blue-600">Buku Terbaikmu</span><br>
        Hari Ini
    </h2>

    <p class="text-gray-600 text-lg mb-10 max-w-md">
        Jika kamu tidak suka membaca, berarti kamu belum menemukan
        buku yang tepat. Jelajahi ribuan koleksi digital kami.
    </p>

</div>

            <div class="flex gap-4 ml-10" >
                <a href="/registrasi"
                    class="border border-blue-600 text-blue-600 px-8 py-4 rounded-xl hover:bg-blue-300 transition">
                    Daftar 
                </a>
                <a href="#koleksi"
                   class="border border-blue-600 text-blue-600 px-8 py-4 rounded-xl hover:bg-blue-300 transition">
                    Lihat Koleksi
                </a>
            </div>
        </div>

        <!-- IMAGE -->
        <div class="relative flex justify-center -mt-20">
    <img src="{{ asset('img/buku_landing.png') }}" class="w-90" alt="Buku">
</div>

    </div>
</section>

<!-- ================= KATEGORI BUKU ================= -->
<section id="kategori" class="py-24 bg-gradient-to-b from-white to-blue-50">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">
            Kategori Buku
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10">

            <!-- Fiksi -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 flex items-center justify-center bg-blue-100 rounded-full mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Fiksi</h3>
            </div>

            <!-- Non Fiksi -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 flex items-center justify-center bg-blue-100 rounded-full mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Non Fiksi</h3>
            </div>

            <!-- Pengembangan Diri -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 flex items-center justify-center bg-blue-100 rounded-full mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 20c0-4 12-4 12 0"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Pengembangan Diri</h3>
            </div>

            <!-- Teknologi -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 flex items-center justify-center bg-blue-100 rounded-full mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="12" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Teknologi</h3>
            </div>

            <!-- Bisnis -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 flex items-center justify-center bg-blue-100 rounded-full mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M6.75 7.5v10.5M17.25 7.5v10.5"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Bisnis</h3>
            </div>

        </div>

    </div>
</section>

<!-- ================= KOLEKSI BUKU ================= -->
<section id="koleksi" class="py-24 bg-blue-50">

    <div class="max-w-7xl mx-auto px-10">

        <!-- Judul -->
        <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Koleksi  Buku</h2>

        <!-- Grid Buku -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-10">

            <!-- ================= CARD BUKU ================= -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-4 text-center group">

                <!-- Cover Buku -->
                <div class="flex items-center justify-center h-72 bg-gray-50 rounded-lg overflow-hidden">
                    <img src="{{ asset('img/fiksi1.png') }}"
                         class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                </div>

                <!-- Judul -->
                <h4 class="mt-4 font-semibold text-gray-800">
                    Bu, Aku Ingin Pelukmu
                </h4>

                <!-- Rating -->
                <div class="flex justify-center mt-1 text-yellow-400 text-sm">
                    ⭐⭐⭐⭐☆
                </div>

                <!-- Stok -->
                <p class="text-xs text-gray-500 mt-1">
                    Stok: 12 buku
                </p>

                <!-- Kategori -->

            </div>


            <!-- ================= CARD BUKU ================= -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-4 text-center group">

                <div class="flex items-center justify-center h-72 bg-gray-50 rounded-lg overflow-hidden">
                    <img src="{{ asset('img/nonfiksi1.jpg') }}"
                         class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                </div>

                <h4 class="mt-4 font-semibold text-gray-800">
                    4 Masa 1 Mimpi
                </h4>

                <div class="flex justify-center mt-1 text-yellow-400 text-sm">
                    ⭐⭐⭐⭐⭐
                </div>

                <p class="text-xs text-gray-500 mt-1">
                    Stok: 8 buku
                </p>

            </div>


            <!-- ================= CARD BUKU ================= -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-4 text-center group">

                <div class="flex items-center justify-center h-72 bg-gray-50 rounded-lg overflow-hidden">
                    <img src="{{ asset('img/pd1.jpg') }}"
                         class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                </div>

                <h4 class="mt-4 font-semibold text-gray-800">
                    The Psychology Of Money
                </h4>

                <div class="flex justify-center mt-1 text-yellow-400 text-sm">
                    ⭐⭐⭐⭐☆
                </div>

                <p class="text-xs text-gray-500 mt-1">
                    Stok: 5 buku
                </p>

            </div>


            <!-- ================= CARD BUKU ================= -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-4 text-center group">

                <div class="flex items-center justify-center h-72 bg-gray-50 rounded-lg overflow-hidden">
                    <img src="{{ asset('img/tekno1.jpg') }}"
                         class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                </div>

                <h4 class="mt-4 font-semibold text-gray-800">
                    Panduan Lengkap Coding Web
                </h4>

                <div class="flex justify-center mt-1 text-yellow-400 text-sm">
                    ⭐⭐⭐☆☆
                </div>

                <p class="text-xs text-gray-500 mt-1">
                    Stok: 10 buku
                </p>
            </div>


            <!-- ================= CARD BUKU ================= -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-4 text-center group">

                <div class="flex items-center justify-center h-72 bg-gray-50 rounded-lg overflow-hidden">
                    <img src="{{ asset('img/bisnis1.jpg') }}"
                         class="max-h-full object-contain group-hover:scale-105 transition duration-300">
                </div>

                <h4 class="mt-4 font-semibold text-gray-800">
                    The Visual MBA
                </h4>

                <div class="flex justify-center mt-1 text-yellow-400 text-sm">
                    ⭐⭐⭐⭐⭐
                </div>

                <p class="text-xs text-gray-500 mt-1">
                    Stok: 7 buku
                </p>
            </div>

        </div>

    </div>

</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-blue-700 text-white py-6">
    <p class="text-center">
        © {{ date('Y') }} Perpustakaan Digital • UKK PPLG
    </p>
</footer>

</body>
</html>
