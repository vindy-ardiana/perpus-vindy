@extends('layout.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<h2 class="text-2xl font-bold mb-2">Riwayat Peminjaman Buku</h2>
<p class="text-slate-600 text-sm mb-4">Anda bisa memberi <strong>ulasan dan rating</strong> untuk peminjaman yang sudah disetujui dengan menekan tombol <strong>Tulis Ulasan</strong> di kolom Aksi, atau dari kartu di bawah ini.</p>

<div class="flex flex-wrap items-center gap-3 mb-4">
    <a href="{{ route('user.riwayat.pdf') }}" target="_blank"
        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
        <span class="material-icons text-lg">picture_as_pdf</span>
        Cetak PDF
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div>
@endif

@php
    $belumUlasan = $riwayat->filter(fn($item) => $item->status === 'Setuju' && !$item->ulasan);
@endphp
@if($belumUlasan->isNotEmpty())
<div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
    <h3 class="font-semibold text-amber-800 mb-2 flex items-center gap-2">
        <span class="material-icons text-lg">rate_review</span>
        Beri Ulasan & Rating
    </h3>
    <p class="text-sm text-amber-700 mb-3">Anda punya {{ $belumUlasan->count() }} peminjaman yang sudah disetujui dan belum diberi ulasan.</p>
    <div class="flex flex-wrap gap-2">
        @foreach($belumUlasan as $item)
        <button type="button" onclick="bukaModalUlasan({{ $item->id }})"
            class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium">
            <span class="material-icons text-lg">star</span>
            Tulis Ulasan: {{ Str::limit($item->buku->judul, 25) }}
        </button>
        @endforeach
    </div>
</div>
@endif

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
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $item)
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
                <td class="px-4 py-3 text-slate-600">
                    {{ $item->buku->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}
                </td>
                <td class="px-4 py-3">{{ $item->tgl_peminjaman->format('d/m/Y') }}</td>
                <td class="px-4 py-3">{{ $item->tgl_kembali ? $item->tgl_kembali->format('d/m/Y') : '-' }}</td>
                <td class="px-4 py-3">
                    @php
                        $label = match(true) {
                            $item->status === 'Proses' => 'Menunggu Konfirmasi',
                            $item->status === 'Tolak' => 'Ditolak',
                            $item->status_pengembalian === 'MenungguPengembalian' => 'Menunggu Konfirmasi Pengembalian',
                            $item->status_pengembalian === 'Dipinjam' => 'Dipinjam',
                            default => 'Sudah Dikembalikan',
                        };
                        $class = match(true) {
                            $item->status === 'Proses' => 'bg-amber-100 text-amber-700',
                            $item->status === 'Tolak' => 'bg-red-100 text-red-700',
                            $item->status_pengembalian === 'MenungguPengembalian' => 'bg-blue-100 text-blue-700',
                            $item->status_pengembalian === 'Dipinjam' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-green-100 text-green-700',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm {{ $class }}">{{ $label }}</span>
                </td>
                <td class="px-4 py-3">
                    @php
                        $bisaUlasan = $item->status === 'Setuju' && !$item->ulasan;
                        $sudahUlasan = $item->ulasan;
                    @endphp
                    @if($item->status === 'Setuju' && $item->status_pengembalian === 'Dipinjam')
                        <button type="button" onclick="bukaModalPengembalian({{ $item->id }}, '{{ addslashes($item->buku->judul) }}', '{{ addslashes($item->buku->penulis ?? $item->buku->pengarang ?? '-') }}', '{{ addslashes($item->buku->penerbit->nama_penerbit ?? '-') }}', '{{ $item->tgl_peminjaman->format('d/m/Y') }}', '{{ $item->batas_kembali->format('d/m/Y') }}')"
                            class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600">
                            Ajukan Pengembalian
                        </button>
                    @elseif($bisaUlasan)
                        <button type="button" onclick="bukaModalUlasan({{ $item->id }})"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-500 text-white rounded-lg text-sm font-medium hover:bg-indigo-600">
                            <span class="material-icons text-base">rate_review</span>
                            Tulis Ulasan
                        </button>
                    @elseif($sudahUlasan)
                        <span class="text-slate-500 text-sm">Ulasan terkirim</span>
                    @else
                        <span class="text-slate-400 text-xs">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-6 text-slate-500">Belum ada riwayat peminjaman</td>
            </tr>
            @endforelse
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
        <button type="button" onclick="tutupModalPengembalian()" class="w-full mt-2 border rounded-lg py-2">
            Batal
        </button>
    </div>
</div>

{{-- Modal Ulasan --}}
<div id="modal-ulasan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4">Tulis Ulasan & Rating</h3>
        <form id="form-ulasan" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-slate-600 mb-2">Rating (1-5 bintang)</label>
                <select name="rating" required class="border rounded-lg px-3 py-2 w-full">
                    <option value="1">1 bintang</option>
                    <option value="2">2 bintang</option>
                    <option value="3">3 bintang</option>
                    <option value="4">4 bintang</option>
                    <option value="5" selected>5 bintang</option>
                </select>
            </div>
            <div class="mb-4">
                <textarea name="isi_ulasan" rows="4" class="w-full border rounded-lg px-3 py-2" placeholder="Bagaimana pengalaman Anda meminjam buku ini?" required></textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-2.5 rounded-lg font-medium">
                Kirim Ulasan
            </button>
        </form>
        <button type="button" onclick="document.getElementById('modal-ulasan').classList.add('hidden')" class="w-full mt-2 border rounded-lg py-2">
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
    function tutupModalPengembalian() {
        document.getElementById('modal-pengembalian').classList.add('hidden');
    }
    function bukaModalUlasan(id) {
        document.getElementById('form-ulasan').action = '{{ route("user.ulasan.store", ["transaksi" => "__ID__"]) }}'.replace('__ID__', id);
        document.getElementById('modal-ulasan').classList.remove('hidden');
    }
</script>
@endsection
