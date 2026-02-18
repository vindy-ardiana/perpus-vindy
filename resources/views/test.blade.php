<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-gray-50 via-indigo-50 to-gray-100">

    <div class="flex h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-indigo-100 flex flex-col shadow-xl">

            <!-- LOGO -->
            <div class="p-6 border-b border-indigo-100">
                <h1 class="text-xl font-bold text-indigo-600">Perpus Digital</h1>
                {{-- <p class="text-sm text-gray-500">Admin Panel</p> --}}
            </div>

            <!-- MENU -->
            <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                    <span class="material-icons text-indigo-500">dashboard</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('kategori.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('kategori.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                    <span class="material-icons text-indigo-500">category</span>
                    <span>Kategori</span>
                </a>

                <a href="{{ route('penerbit.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('penerbit.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                    <span class="material-icons text-indigo-500">business</span>
                    <span>Penerbit</span>
                </a>

                <a href="{{ route('buku.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('buku.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                    <span class="material-icons text-indigo-500">menu_book</span>
                    <span>Buku</span>
                </a>

            </nav>

            <!-- LOGOUT -->
            @if (Auth::check())
                <div class="p-4 border-t border-indigo-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2
                    border border-indigo-300 text-indigo-600
                    hover:bg-indigo-50 hover:shadow py-2 rounded-xl transition-all">
                            <span class="material-icons text-sm">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            @endif
        </aside>

        <!-- CONTENT -->
        <div class="flex-1 flex flex-col">

            <!-- HEADER -->
            <header
                class="bg-white/80 backdrop-blur border-b border-indigo-100
                       flex items-center justify-between px-6 py-4 shadow-sm">
                <h2 class="text-lg font-semibold text-indigo-700">Dashboard</h2>

                <div class="relative group">
                    <button
                        class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl shadow-sm hover:shadow transition">
                        <img src="https://via.placeholder.com/40" class="w-9 h-9 rounded-full border border-indigo-200">
                        <span class="text-gray-700 font-medium">
                            {{ Auth::user()->name }}
                        </span>
                    </button>

                    <div
                        class="absolute right-0 mt-2 w-44 bg-white border border-indigo-100 rounded-xl shadow-lg hidden group-hover:block">
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-indigo-50">Edit Profil</a>
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-indigo-50">Pengaturan</a>
                    </div>
                </div>
            </header>

            <!-- MAIN -->
            <main class="flex-1 p-6 space-y-6">

                <!-- WELCOME -->
                <div
                    class="bg-gradient-to-r from-indigo-500 to-indigo-600
                        p-6 rounded-2xl text-white shadow-lg">
                    <h3 class="text-2xl font-bold mb-1">
                        Selamat Datang, {{ Auth::user()->name }} 👋
                    </h3>
                    <p class="text-indigo-100">
                        Kelola data perpustakaan digital dengan tampilan modern dan profesional.
                    </p>
                </div>

                <!-- STAT -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
                        <p class="text-sm text-gray-500">Total Buku</p>
                        <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalBuku) }}</h4>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
                        <p class="text-sm text-gray-500">Kategori</p>
                        <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalKategori) }}</h4>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
                        <p class="text-sm text-gray-500">Penerbit</p>
                        <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalPenerbit) }}</h4>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
                        <p class="text-sm text-gray-500">User Aktif</p>
                        <h4 class="text-2xl font-bold text-indigo-600 mt-1">-</h4>
                    </div>

                </div>

            </main>
        </div>
    </div>

</body>

</html>
