@extends('layout.user')

@section('content')
<h2 class="text-2xl font-bold mb-6">
    👋 Selamat Datang, {{ auth()->user()->name }}
</h2>

<!-- STATISTIK -->
<!-- STATISTIK -->
<div class="grid md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-gray-500 text-sm">Total Peminjaman</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $total }}</p>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-gray-500 text-sm">Sedang Dipinjam</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ $dipinjam }}</p>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-gray-500 text-sm">Sudah Dikembalikan</h3>
        <p class="text-3xl font-bold text-green-600">{{ $kembali }}</p>
    </div>

</div>

<!-- AKSES CEPAT -->
<div class="grid md:grid-cols-2 gap-6 mb-6">
    <a href="{{ route('user.daftarbuku') }}"
       class="bg-blue-600 text-white p-6 rounded shadow hover:bg-blue-700 transition">
        <h4 class="text-xl font-semibold">📖 Pinjam Buku</h4>
        <p class="text-sm opacity-90">Mulai peminjaman buku baru</p>
    </a>

    <a href="{{ route('user.riwayat') }}"
       class="bg-gray-800 text-white p-6 rounded shadow hover:bg-gray-900 transition">
        <h4 class="text-xl font-semibold">📑 Riwayat Peminjaman</h4>
        <p class="text-sm opacity-90">Lihat riwayat dan beri ulasan & rating</p>
    </a>
</div>

@if(isset($jumlahBelumUlasan) && $jumlahBelumUlasan > 0)
<div class="mb-8 p-4 bg-amber-50 border border-amber-200 rounded-xl">
    <h3 class="font-semibold text-amber-800 mb-1 flex items-center gap-2">
        <span class="material-icons">rate_review</span>
        Beri Ulasan & Rating
    </h3>
    <p class="text-sm text-amber-700 mb-3">Anda punya <strong>{{ $jumlahBelumUlasan }}</strong> peminjaman yang sudah disetujui dan belum diberi ulasan.</p>
    <a href="{{ route('user.riwayat') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition">
        <span class="material-icons text-lg">star</span>
        Ke Riwayat → Tulis Ulasan
    </a>
</div>
@endif


@endsection