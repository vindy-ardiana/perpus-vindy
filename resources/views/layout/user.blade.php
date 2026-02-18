<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 flex">

<!-- SIDEBAR -->
<aside class="w-64 min-h-screen bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-lg">
    <div class="p-6 text-center border-b border-blue-400">
        <h1 class="text-2xl font-bold">Literia</h1>
        <p class="text-sm text-blue-200">Perpustakaan Digital</p>
    </div>

    <nav class="mt-6 space-y-2 px-4">
        <a href=""
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-500 transition">
            🏠 <span>Dashboard</span>
        </a>

         <a href="{{ route('user.daftarbuku') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-500 transition">
            👍 <span>Koleksi Buku</span>
        </a>

        <a href="{{ route('user.koleksi') }}"
          class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-500 transition">
           👍 <span>Koleksi Pribadi</span>
       </a>
        <a href="{{ route('user.riwayat') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-500 transition">
            🕒 <span>Riwayat Peminjaman</span>
        </a>



        <button
            onclick="event.preventDefault();document.getElementById('logout').submit();"
            class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500 transition mt-6">
            🚪 <span>Logout</span>
        </button>
    </nav>
</aside>

<!-- LOGOUT FORM -->
<form id="logout" method="POST" action="{{ route('logout') }}">
    @csrf
</form>

<!-- MAIN CONTENT -->
<main class="flex-1 p-8">
    <div class="bg-white rounded-xl shadow p-6 min-h-[80vh]">
        @yield('content')
    </div>
</main>

</body>
</html>
