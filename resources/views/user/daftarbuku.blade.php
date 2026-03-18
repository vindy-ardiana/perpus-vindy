@extends('layout.user')

@section('title','Koleksi Buku')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Koleksi Buku
</h2>

<!-- GRID BUKU -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-5">

    @forelse($bukus as $buku)

    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-3 text-center group flex flex-col">

        <!-- COVER -->
        <div class="flex items-center justify-center h-56 bg-gray-50 rounded-lg overflow-hidden">
            @if($buku->cover)
            <img src="{{ asset('storage/'.$buku->cover) }}"
                 class="max-h-full object-contain group-hover:scale-105 transition duration-300">
            @else
            <span class="text-gray-400 text-xs">No Cover</span>
            @endif
        </div>

        <!-- JUDUL -->
        <h4 class="mt-3 font-semibold text-gray-800 text-sm line-clamp-2 min-h-[40px]">
            {{ $buku->judul }}
        </h4>

        <!-- RATING -->
        <div class="flex justify-center mt-1 text-yellow-400 text-xs">
            @if(($buku->ulasans_avg_rating ?? 0) > 0)
                ⭐ {{ number_format($buku->ulasans_avg_rating,1) }}
            @else
                ☆☆☆☆☆
            @endif
        </div>

        <!-- STOK -->
        <p class="text-xs text-gray-500 mt-1">
            Stok: {{ $buku->stok }}
        </p>

        <!-- BUTTON -->
        <a href="{{ route('user.buku.detail',$buku->id) }}"
           class="mt-auto mt-3 bg-indigo-600 text-white text-xs py-2 rounded-lg hover:bg-indigo-700 transition">
           Detail
        </a>

    </div>

    @empty

    <div class="col-span-5 text-center text-gray-400 py-20">
        Belum ada buku tersedia
    </div>

    @endforelse

</div>

</div>

@endsection
