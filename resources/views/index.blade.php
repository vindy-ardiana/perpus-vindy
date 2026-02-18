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
                📘 Perpus<span class="text-sky-200">Digital</span>
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

                <a href="/login"
                   class="bg-white/20 px-5 py-2 rounded-xl hover:bg-white/30 transition">
                    Login
                </a>
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

            <h2 class="text-5xl font-extrabold leading-tight mb-6">
                Temukan<br>
                <span class="text-blue-600">Buku Terbaikmu</span><br>
                Hari Ini
            </h2>

            <p class="text-gray-600 text-lg mb-10 max-w-md">
                Jika kamu tidak suka membaca, berarti kamu belum menemukan
                buku yang tepat. Jelajahi ribuan koleksi digital kami.
            </p>

            <div class="flex gap-4">
                <a href="/registrasi"
                   class="bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition shadow">
                    Daftar Gratis
                </a>
                <a href="#koleksi"
                   class="border border-blue-600 text-blue-600 px-8 py-4 rounded-xl hover:bg-blue-100 transition">
                    Lihat Koleksi
                </a>
            </div>
        </div>

        <!-- IMAGE -->
        <div class="relative flex justify-center">
            <div class="absolute -inset-6 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-[3rem] blur opacity-40"></div>
            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794"
                 class="relative rounded-[2.5rem] shadow-2xl w-[360px]"
                 alt="Buku">
        </div>

    </div>
</section>

<!-- ================= KATEGORI ================= -->
<section id="kategori" class="py-24 bg-white/70 backdrop-blur">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-16">📂 Kategori Buku</h3>

        <div class="grid sm:grid-cols-2 md:grid-cols-5 gap-8">

            <div class="bg-gradient-to-br from-blue-500 to-indigo-500 text-white p-8 rounded-3xl shadow-lg hover:-translate-y-2 transition">
                <div class="text-4xl mb-4">📘</div>
                <h4 class="text-xl font-semibold">Fiksi</h4>
                <p class="text-sm opacity-80 mt-2">Cerita & imajinasi</p>
            </div>

            <div class="bg-gradient-to-br from-sky-500 to-blue-500 text-white p-8 rounded-3xl shadow-lg hover:-translate-y-2 transition">
                <div class="text-4xl mb-4">📗</div>
                <h4 class="text-xl font-semibold">Non-Fiksi</h4>
                <p class="text-sm opacity-80 mt-2">Ilmu & fakta</p>
            </div>

            <div class="bg-gradient-to-br from-indigo-500 to-purple-500 text-white p-8 rounded-3xl shadow-lg hover:-translate-y-2 transition">
                <div class="text-4xl mb-4">💻</div>
                <h4 class="text-xl font-semibold">Teknologi</h4>
                <p class="text-sm opacity-80 mt-2">IT & Pemrograman</p>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-cyan-500 text-white p-8 rounded-3xl shadow-lg hover:-translate-y-2 transition">
                <div class="text-4xl mb-4">💼</div>
                <h4 class="text-xl font-semibold">Bisnis</h4>
                <p class="text-sm opacity-80 mt-2">Ekonomi & usaha</p>
            </div>

            <div class="bg-gradient-to-br from-cyan-500 to-teal-500 text-white p-8 rounded-3xl shadow-lg hover:-translate-y-2 transition">
                <div class="text-4xl mb-4">🌱</div>
                <h4 class="text-xl font-semibold">Pengembangan Diri</h4>
                <p class="text-sm opacity-80 mt-2">Motivasi & mindset</p>
            </div>

        </div>
    </div>
</section>

<!-- ================= KOLEKSI ================= -->
<section id="koleksi" class="py-24">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-14">📚 Koleksi Buku</h3>

        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-8">
            @for($i=1; $i<=4; $i++)
            <div class="bg-white rounded-3xl shadow hover:scale-105 transition overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-blue-200 to-indigo-200 flex items-center justify-center text-5xl">
                    📖
                </div>
                <div class="p-5">
                    <h4 class="font-semibold text-lg">Judul Buku</h4>
                    <p class="text-sm text-gray-500">Kategori Buku</p>
                    <p class="text-sm mt-2">⭐ ⭐ ⭐ ⭐ ☆</p>
                </div>
            </div>
            @endfor
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
