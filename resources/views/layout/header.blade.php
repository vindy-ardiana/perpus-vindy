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
                Dashboard
            </a>

            <a href="{{ route('kategori.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('kategori.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                <span class="material-icons text-indigo-500">category</span>
                Kategori
            </a>

            <a href="{{ route('penerbit.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('penerbit.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                <span class="material-icons text-indigo-500">business</span>
                Penerbit
            </a>

            <a href="{{ route('buku.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('buku.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                <span class="material-icons text-indigo-500">menu_book</span>
                Buku
            </a>

            <a href="{{ route('anggota.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('anggota.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                <span class="material-icons text-indigo-500">people</span>
                Anggota
            </a>

            <a href="{{ route('konfirmasi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               text-gray-700 hover:bg-indigo-50 hover:shadow transition-all
               {{ request()->routeIs('peminjaman.*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : '' }}">
                <span class="material-icons text-indigo-500">assignment</span>
                Konfirmasi Peminjaman
            </a>

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
                {{ ucfirst(request()->segment(1) ?? 'Dashboard') }}
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