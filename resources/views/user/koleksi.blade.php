@extends('layout.user')

@section('title', 'Daftar Buku')

@section('content')
<h2 class="text-2xl font-bold mb-6">📚 Daftar Koleksi Buku</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

@foreach ($buku as $buku)
<div class="bg-white border rounded-xl p-4 hover:shadow transition">

    <div class="h-40 bg-slate-200 rounded mb-3 overflow-hidden">
        @if ($buku->buku->cover)
            <img src="{{ asset('storage/'.$buku->buku->cover) }}"
                 class="w-full h-full object-cover">
        @else
            <div class="h-full flex items-center justify-center text-slate-500">
                No Cover
            </div>
        @endif
    </div>

    <h3 class="font-semibold">{{ $buku->buku->judul }}</h3>
    <p class="text-sm text-slate-500">
        {{ $buku->kategori->nama_kategori ?? '-' }}
    </p>
    <div>
        <a href="{{ route('user.buku.detail', $buku->buku->id) }}"
    
           class="block text-center mt-3 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">
            Detail Buku
        </a>
        <a href="{{ route('user.kembalikan', $buku->id) }}"
    
           class="block text-center mt-3 bg-red-600 text-white py-2 rounded-lg text-sm hover:bg-red-700">
            Kembalikan Buku
        </a>

    </div>

</div>
@endforeach

</div>
@endsection
