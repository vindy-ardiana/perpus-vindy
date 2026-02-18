@extends('layout.user')

@section('content')
<h2 class="text-2xl font-bold mb-6">
    👋 Selamat Datang, {{ auth()->user()->name }}
</h2>

<!-- STATISTIK -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-gray-500 text-sm">Total Peminjaman</h3>
        <p class="text-3xl font-bold text-blue-600">{{ 12 }}</p>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-gray-500 text-sm">Sedang Dipinjam</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ 22 }}</p>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-gray-500 text-sm">Sudah Dikembalikan</h3>
        <p class="text-3xl font-bold text-green-600">{{23 }}</p>
    </div>
</div>

<!-- AKSES CEPAT -->
<div class="grid md:grid-cols-2 gap-6 mb-10">
    <a href=""
       class="bg-blue-600 text-white p-6 rounded shadow hover:bg-blue-700">
        <h4 class="text-xl font-semibold">📖 Pinjam Buku</h4>
        <p class="text-sm">Mulai peminjaman buku baru</p>
    </a>

    <a href=""
       class="bg-gray-800 text-white p-6 rounded shadow hover:bg-gray-900">
        <h4 class="text-xl font-semibold">📑 Riwayat Peminjaman</h4>
        <p class="text-sm">Lihat riwayat peminjamanmu</p>
    </a>
</div>

<!-- RIWAYAT TERAKHIR -->
{{-- <div class="bg-white shadow rounded">
    <div class="p-4 border-b font-semibold">📚 Peminjaman Terakhir</div>

    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Buku</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $p)
            <tr class="border-t">
                <td class="p-2">{{ $p->tgl_peminjaman }}</td>
                <td class="p-2">
                    <ul class="list-disc ml-4">
                        @foreach($p->buku as $b)
                            <li>{{ $b->judul }}</li>
                        @endforeach
                    </ul>
                </td>
                <td class="p-2">
                    @if($p->status_pengembalian == 'Dipinjam')
                        <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">
                            Dipinjam
                        </span>
                    @else
                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">
                            Dikembalikan
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center p-4 text-gray-500">
                    Belum ada peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div> --}}
@endsection