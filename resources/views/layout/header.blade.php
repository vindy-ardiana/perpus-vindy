<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Manajemen Data Buku</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-gray-50 via-indigo-50 to-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-indigo-100 flex flex-col shadow-xl">

        <!-- LOGO -->
        <div class="p-4 border-b border-indigo-100">
            <h1 class="text-xl font-bold text-indigo-600">Literia</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ Auth::check() && Auth::user()->role === 'admin' ? 'Admin' : 'Petugas' }}</p>
        </div>

        <!-- MENU -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            @php
                $navClass = 'flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 transition text-sm';
                $navActive = 'bg-indigo-50 text-indigo-600 font-medium';
            @endphp

            <a href="{{ route('dashboard') }}"
               class="{{ $navClass }} {{ request()->routeIs('dashboard') ? $navActive : '' }}">
                <span class="material-icons text-lg text-indigo-500">dashboard</span>
                Dashboard
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Master Data</p>
            <div class="space-y-0.5">
                <a href="{{ route('kategori.index') }}" class="{{ $navClass }} {{ request()->routeIs('kategori.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">category</span> Kategori
                </a>
                <a href="{{ route('penerbit.index') }}" class="{{ $navClass }} {{ request()->routeIs('penerbit.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">business</span> Penerbit
                </a>
                <a href="{{ route('buku.index') }}" class="{{ $navClass }} {{ request()->routeIs('buku.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">menu_book</span> Buku
                </a>
                
            </div>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Transaksi</p>
            <div class="space-y-0.5">
                <a href="{{ route('konfirmasi.peminjaman') }}" class="{{ $navClass }} {{ request()->routeIs('konfirmasi.peminjaman') || request()->routeIs('setuju') || request()->routeIs('tolak') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">menu_book</span> Approve Peminjaman
                </a>
                <a href="{{ route('konfirmasi.pengembalian') }}" class="{{ $navClass }} {{ request()->routeIs('konfirmasi.pengembalian') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">assignment_return</span> Approve Pengembalian
                </a>
                <a href="{{ route('ulasan.index') }}" class="{{ $navClass }} {{ request()->routeIs('ulasan.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">rate_review</span> Ulasan
                </a>
            </div>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Laporan</p>
            <div class="space-y-0.5">
                <a href="{{ route('laporan.buku') }}" class="{{ $navClass }} {{ request()->routeIs('laporan.buku*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">menu_book</span> Data Buku
                </a>
                <a href="{{ route('laporan.transaksi') }}" class="{{ $navClass }} {{ request()->routeIs('laporan.transaksi*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">assignment</span> Peminjaman
                </a>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('laporan.user') }}" class="{{ $navClass }} {{ request()->routeIs('laporan.user*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">people</span> Data User
                </a>
                @endif
            </div>

            @if(Auth::check() && Auth::user()->role === 'admin')
            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan</p>
            <div class="space-y-0.5">
                <a href="{{ route('petugas.index') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">badge</span> Petugas
                </a>
                <a href="{{ route('user.index') }}" class="{{ $navClass }} {{ request()->routeIs('user.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">person</span> User
                </a>
            </div>
            @endif
        </nav>

        <!-- LOGOUT -->
        @if(Auth::check())
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

        <!-- HEADER TOP -->
        <header class="bg-white/80 backdrop-blur border-b border-indigo-100
                       flex items-center justify-between px-6 py-4 shadow-sm">
            <h2 class="text-lg font-semibold text-indigo-700">
                @if(request()->routeIs('dashboard')) Dashboard
                @elseif(request()->routeIs('kategori.*')) Kategori
                @elseif(request()->routeIs('penerbit.*')) Penerbit
                @elseif(request()->routeIs('buku.*')) Buku
                @elseif(request()->routeIs('anggota.*')) Anggota
                @elseif(request()->routeIs('konfirmasi.*') || request()->routeIs('setuju') || request()->routeIs('tolak')) Konfirmasi
                @elseif(request()->routeIs('ulasan.*')) Ulasan
                @elseif(request()->routeIs('petugas.*')) Petugas
                @elseif(request()->routeIs('user.*')) User
                @elseif(request()->routeIs('laporan.*')) Laporan
                @else {{ ucfirst(request()->segment(1) ?: 'Dashboard') }}
                @endif
            </h2>

            <div class="relative group">
                <button class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl shadow-sm hover:shadow transition">
                    <img src="https://via.placeholder.com/40"
                         class="w-9 h-9 rounded-full border border-indigo-200">
                    <span class="text-gray-700 font-medium">
                        {{ Auth::user()->name }}
                    </span>
                </button>

                <div class="absolute right-0 mt-2 w-44 bg-white border border-indigo-100 rounded-xl shadow-lg hidden group-hover:block">
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-indigo-50">Edit Profil</a>
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-indigo-50">Pengaturan</a>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT OPEN -->
        <main class="flex-1 p-6">