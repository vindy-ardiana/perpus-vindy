@extends('layout.user')

@section('title', 'Koleksi Pribadi')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6">Sedang Dipinjam</h2>

@if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div>
@endif

@if($buku->isEmpty())
    <div class="text-center py-12 bg-slate-50 rounded-xl border border-slate-200 text-slate-500">
        <p class="text-lg">Belum ada buku yang sedang dipinjam.</p>
        <a href="{{ route('user.daftarbuku') }}" class="inline-block mt-3 text-indigo-600 font-medium hover:underline">Lihat koleksi buku</a>
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
                <th class="px-4 py-3 text-left">Tgl Pinjam</th>
                <th class="px-4 py-3 text-left">Batas Kembali</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $item)
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
                <td class="px-4 py-3">{{ $item->tgl_peminjaman->format('d/m/Y') }}</td>
                <td class="px-4 py-3">{{ $item->batas_kembali->format('d/m/Y') }}</td>
                <td class="px-4 py-3">
                    <button type="button" onclick="bukaModalPengembalian({{ $item->id }}, '{{ addslashes($item->buku->judul) }}', '{{ addslashes($item->buku->penulis ?? $item->buku->pengarang ?? '-') }}', '{{ addslashes($item->buku->penerbit->nama_penerbit ?? '-') }}', '{{ $item->tgl_peminjaman->format('d/m/Y') }}', '{{ $item->batas_kembali->format('d/m/Y') }}')"
                        class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600">
                        Dikembalikan
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Pengembalian --}}
<div id="modal-pengembalian" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4">Detail Buku yang Akan Dikembalikan</h3>
        <div class="space-y-2 text-sm mb-4" id="detail-pengembalian"></div>
        <form id="form-pengembalian" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2.5 rounded-lg font-medium">
                Ajukan Pengembalian
            </button>
        </form>
        <button type="button" onclick="document.getElementById('modal-pengembalian').classList.add('hidden')" class="w-full mt-2 border rounded-lg py-2">
            Batal
        </button>
    </div>
</div>

<script>
    function bukaModalPengembalian(id, judul, penulis, penerbit, tglPinjam, tglKembali) {
        document.getElementById('detail-pengembalian').innerHTML = `
            <p><span class="text-slate-500">Judul:</span> ${judul}</p>
            <p><span class="text-slate-500">Penulis:</span> ${penulis}</p>
            <p><span class="text-slate-500">Penerbit:</span> ${penerbit}</p>
            <p><span class="text-slate-500">Tanggal Pinjam:</span> ${tglPinjam}</p>
            <p><span class="text-slate-500">Tanggal Pengembalian:</span> ${tglKembali}</p>
        `;
        document.getElementById('form-pengembalian').action = '{{ route("user.ajukan.pengembalian", ["transaksi" => "__ID__"]) }}'.replace('__ID__', id);
        document.getElementById('modal-pengembalian').classList.remove('hidden');
    }
</script>
@endif
@endsection
