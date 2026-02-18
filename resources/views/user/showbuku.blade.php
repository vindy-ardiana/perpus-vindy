@extends('layout.user')

@section('title', 'Detail Buku')

@section('content')

<!-- BREADCRUMB -->
<div class="text-sm text-slate-500 mb-6">
    Beranda / Koleksi Buku / <span class="text-slate-700 font-medium">{{ $buku->judul }}</span>
</div>

<div class="bg-white rounded-xl p-6 shadow grid md:grid-cols-3 gap-8">

    <!-- COVER -->
    <div class="md:col-span-1">
        <div class="w-full h-[420px] bg-slate-200 rounded-xl flex items-center justify-center overflow-hidden">
            @if ($buku->cover)
                <img src="{{ asset('storage/'.$buku->cover) }}"
                     class="w-full h-full object-cover">
            @else
                <span class="text-slate-500 text-xl">Book Cover</span>
            @endif
        </div>
    </div>

    <!-- DETAIL -->
    <div class="md:col-span-2">
        <h2 class="text-xl font-semibold mb-4">Detail Buku</h2>

        <table class="text-sm w-full mb-6">
            <tr>
                <td class="py-1 w-28 text-slate-500">Judul</td>
                <td>: {{ $buku->judul }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Penulis</td>
                <td>: {{ $buku->penulis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Penerbit</td>
                <td>: {{ $buku->penerbit->nama_penerbit ?? '-' }}</td>

            </tr>
            <tr>
                <td class="py-1 text-slate-500">Kategori</td>
                <td>: {{ $buku->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Deskripsi</td>
                <td>: {{ $buku->deskripsi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Stock</td>
                <td>: <b>{{ $buku->stok }}</b></td>
            </tr>
        </table>

        <h3 class="font-semibold mb-2">Peminjaman</h3>

       <form action="{{ route('pinjam.buku', $buku->id) }}" method="POST">
    @csrf
    <button
        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium">
        Pinjam Buku
    </button>
</form>

    </div>

</div>

@endsection
