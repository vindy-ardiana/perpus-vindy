<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />
    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-gray-50 via-indigo-50 to-gray-100">

    <div class="flex h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-indigo-100 flex flex-col shadow-xl">

            <!-- LOGO -->
            <div class="p-6 border-b border-indigo-100">
                <h1 class="text-xl font-bold text-indigo-600">Literia</h1>
                <p class="text-sm text-gray-500">Perpustakaan Digital</p>
            </div>

            <!-- MENU -->
            <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

                <a href="{{ route('user.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:shadow transition-all {{ request()->routeIs('user.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                    <span class="material-icons text-indigo-500">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('user.daftarbuku') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:shadow transition-all {{ request()->routeIs('user.daftarbuku') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                    <span class="material-icons text-indigo-500">menu_book</span>
                    <span>Koleksi Buku</span>
                </a>
                <a href="{{ route('user.koleksi-pribadi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:shadow transition-all {{ request()->routeIs('user.koleksi-pribadi') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                    <span class="material-icons text-indigo-500">bookmark</span>
                    <span>Koleksi Pribadi</span>
                </a>
                <a href="{{ route('user.riwayat') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:shadow transition-all {{ request()->routeIs('user.riwayat') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                    <span class="material-icons text-indigo-500">history</span>
                    <span>Riwayat <span class="text-slate-500 font-normal">· beri ulasan</span></span>
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
            <header class="bg-white/80 backdrop-blur border-b border-indigo-100 flex items-center justify-between px-6 py-4 shadow-sm">
                <h2 class="text-lg font-semibold text-indigo-700">@yield('title', 'Dashboard')</h2>

                <div class="relative group">
                    <button
                        class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl shadow-sm hover:shadow transition">
                        <img src="https://via.placeholder.com/40"
                            class="w-9 h-9 rounded-full border border-indigo-200">
                        <span class="text-gray-700 font-medium">
                            {{ Auth::user()->name }}
                        </span>
                    </button>
                </div>
            </header>

            <!-- MAIN -->
            <main class="flex-1 p-6 space-y-6">

                <!-- WELCOME -->
                {{-- <div
                    class="bg-gradient-to-r from-indigo-500 to-indigo-600
                        p-6 rounded-2xl text-white shadow-lg">
                    <h3 class="text-2xl font-bold mb-1">
                        Selamat Datang, {{ Auth::user()->name }} 👋
                    </h3>
                    <p class="text-indigo-100">
                        Jelajahi koleksi buku dan kelola peminjaman Anda dengan tampilan modern.
                    </p>
                </div> --}}

                <!-- KONTEN UTAMA USER -->
                <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow transition">
                    @yield('content')
                </div>

            </main>
        </div>
    </div>

</body>

</html>
