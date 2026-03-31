@extends('layout.user')

@section('title', 'Koleksi Pribadi')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6">Koleksi Pribadi</h2>

@if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div>
@endif
@if(session('info'))
    <div class="mb-4 p-4 rounded-lg bg-blue-100 text-blue-700 text-sm">{{ session('info') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div>
@endif

@if($koleksi->isEmpty())
    <div class="text-center py-12 bg-slate-50 rounded-xl border border-slate-200 text-slate-500">
        <p class="text-lg">Belum ada buku di koleksi pribadi Anda.</p>
        <a href="{{ route('user.daftarbuku') }}" class="inline-block mt-3 text-indigo-600 font-medium hover:underline">Jelajahi koleksi buku</a>
    </div>
@else
<div class="overflow-x-auto bg-white rounded-xl shadow">
    <table class="w-full">
        <thead class="bg-slate-100 text-slate-700">
            <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Cover</th>
                <th class="px-4 py-3 text-left">Judul</th>
                <th class="px-4 py-3 text-left">Penulis</th>
                <th class="px-4 py-3 text-left">Penerbit</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Stok</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($koleksi as $item)
            <tr class="border-t hover:bg-slate-50">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                <td class="px-4 py-3">
                    @if ($item->buku->cover)
                        <img src="{{ asset('storage/'.$item->buku->cover) }}" class="w-12 h-16 object-cover rounded">
                    @else
                        <span class="text-slate-400 text-sm">No Cover</span>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium">{{ $item->buku->judul }}</td>
                <td class="px-4 py-3">{{ $item->buku->penulis ?? $item->buku->pengarang ?? '-' }}</td>
                <td class="px-4 py-3">{{ $item->buku->penerbit->nama_penerbit ?? '-' }}</td>
                <td class="px-4 py-3 text-slate-600">{{ $item->buku->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 bg-slate-100 rounded text-sm">{{ $item->buku->stok }}</span></td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('user.buku.detail', $item->buku->id) }}" class="px-3 py-1.5 bg-indigo-500 text-white rounded-lg text-sm font-medium hover:bg-indigo-600">
                        Detail
                    </a>
                    <form action="{{ route('koleksi.hapus', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus buku ini dari koleksi?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
