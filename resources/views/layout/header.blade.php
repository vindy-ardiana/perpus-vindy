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
<div class="flex min-h-screen bg-gray-50">

    @include('layout.sidebar')

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col min-h-screen">

        <!-- HEADER -->
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
                @php
                    $nama = explode(' ', Auth::user()->name);
                    $inisial = strtoupper(substr($nama[0],0,1) . (isset($nama[1]) ? substr($nama[1],0,1) : ''));
                @endphp
/
                <button class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl shadow-sm hover:shadow transition">

                    <div class="w-9 h-9 rounded-full bg-indigo-500 text-white flex items-center justify-center font-semibold text-sm">
                        {{ $inisial }}
                    </div>

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

        <!-- MAIN -->
        <main class="flex-1 p-6">