@extends('layout.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<h2 class="text-2xl font-bold mb-6">📜 Riwayat Peminjaman Buku</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow">
    <table class="w-full border-collapse">
        <thead class="bg-slate-100 text-slate-700">
            <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Cover</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Tgl Pinjam</th>
                <th class="px-4 py-3 text-left">Tgl Kembali</th>
                <th class="px-4 py-3 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $item)
            <tr class="border-t hover:bg-slate-50">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>

                <td class="px-4 py-3">
                    @if ($item->buku->cover)
                        <img src="{{ asset('storage/'.$item->buku->cover) }}"
                             class="w-12 h-16 object-cover rounded">
                    @else
                        <span class="text-slate-400 text-sm">No Cover</span>
                    @endif
                </td>

                <td class="px-4 py-3 font-medium">
                    {{ $item->buku->judul }}
                </td>

                <td class="px-4 py-3 text-slate-600">
                    {{ $item->buku->kategori->nama_kategori ?? '-' }}
                </td>

                <td class="px-4 py-3">
                    {{ $item->tgl_peminjaman }}
                </td>

                <td class="px-4 py-3">
                    {{ $item->tgl_kembali }}
                </td>

                <td class="px-4 py-3">
                    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                        {{ $item->status_pengembalian }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-6 text-slate-500">
                    Belum ada riwayat peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
