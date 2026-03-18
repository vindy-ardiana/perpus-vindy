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
                <td>: {{ $buku->penulis ?? $buku->pengarang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Penerbit</td>
                <td>: {{ $buku->penerbit->nama_penerbit ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Kategori</td>
                <td>: {{ $buku->kategoris->pluck('nama_kategori')->join(', ') ?: 'Tidak ada kategori' }}</td>
            </tr>
            <tr>
                <td class="py-1 text-slate-500">Rating</td>
                <td>: @if($buku->rata_rata_rating > 0) ★ {{ number_format($buku->rata_rata_rating, 1) }} @else - @endif</td>
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

        @if(session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success') && !session('pinjam_success_id'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div>
        @endif

        <div class="flex flex-wrap gap-3">
            @if($canBorrow ?? true)
                <button type="button" onclick="document.getElementById('modal-form-pinjam').classList.remove('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium flex items-center gap-2 transition shadow-sm">
                    <span class="material-icons text-lg">menu_book</span>
                    Pinjam
                </button>
            @else
                <button type="button" data-pinjam-msg="{{ e($pinjamBlockMessage ?? 'Anda tidak dapat meminjam saat ini.') }}"
                    class="pinjam-blocked bg-gray-400 cursor-not-allowed text-white px-6 py-2.5 rounded-lg font-medium flex items-center gap-2 shadow-sm">
                    <span class="material-icons text-lg">block</span>
                    Pinjam
                </button>
                <p class="text-sm text-amber-600 flex items-center gap-1 w-full">
                    <span class="material-icons text-lg shrink-0">info</span>
                    {{ $pinjamBlockMessage }}
                </p>
                <script>
                    document.querySelectorAll('.pinjam-blocked').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            alert(this.getAttribute('data-pinjam-msg'));
                        });
                    });
                </script>
            @endif

            <!-- Tombol Bookmark / Simpan Koleksi -->
            <form action="{{ route('koleksi.simpan', $buku->id) }}" method="POST">
                @csrf
                <button
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg font-medium flex items-center gap-2">
                    <span class="material-icons">bookmark</span>
                    Simpan
                </button>
            </form>
        </div>

    </div>

</div>

{{-- Modal Form Peminjaman --}}
<div id="modal-form-pinjam" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Form Peminjaman</h3>
        </div>
        <form action="{{ route('pinjam.buku', $buku->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-slate-600 mb-1">Judul</label>
                <input type="text" value="{{ $buku->judul }}" readonly class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Penulis</label>
                <input type="text" value="{{ $buku->penulis ?? $buku->pengarang ?? '-' }}" readonly class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Penerbit</label>
                <input type="text" value="{{ $buku->penerbit->nama_penerbit ?? '-' }}" readonly class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-50">
            </div>
            <div>
                <label for="tgl_peminjaman" class="block text-sm text-slate-600 mb-1">Tanggal Pinjam <span class="text-red-500">*</span></label>
                <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" value="{{ date('Y-m-d') }}" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label for="tgl_pengembalian_rencana" class="block text-sm text-slate-600 mb-1">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                <input type="date" name="tgl_pengembalian_rencana" id="tgl_pengembalian_rencana" required
                    min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}"
                    value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium">
                    Ajukan Pinjam
                </button>
                <button type="button" onclick="document.getElementById('modal-form-pinjam').classList.add('hidden')"
                    class="px-4 py-2.5 border border-slate-300 rounded-lg font-medium hover:bg-slate-50">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Bukti Peminjaman (setelah berhasil ajukan) --}}
@if(isset($transaksiBukti))
<div id="modal-bukti-pinjam" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div id="bukti-cetak" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-lg font-semibold">Bukti Peminjaman</h3>
            <div class="flex gap-2">
                <a href="{{ route('user.bukti.peminjaman.pdf', $transaksiBukti) }}" target="_blank"
                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium inline-flex items-center gap-1">
                    <span class="material-icons text-sm">picture_as_pdf</span>
                    Cetak PDF
                </a>
                <button type="button" onclick="document.getElementById('modal-bukti-pinjam').classList.add('hidden')"
                    class="px-3 py-1.5 border rounded-lg text-sm">Tutup</button>
            </div>
        </div>
        <div class="space-y-2 text-sm border-t pt-4">
            <p><span class="text-slate-500">No. Peminjaman:</span> {{ $transaksiBukti->no_peminjaman }}</p>
            <p><span class="text-slate-500">Judul:</span> {{ $transaksiBukti->buku->judul }}</p>
            <p><span class="text-slate-500">Penulis:</span> {{ $transaksiBukti->buku->penulis ?? $transaksiBukti->buku->pengarang ?? '-' }}</p>
            <p><span class="text-slate-500">Penerbit:</span> {{ $transaksiBukti->buku->penerbit->nama_penerbit ?? '-' }}</p>
            <p><span class="text-slate-500">Tanggal Pinjam:</span> {{ $transaksiBukti->tgl_peminjaman->format('d/m/Y') }}</p>
            <p><span class="text-slate-500">Tanggal Pengembalian:</span> {{ $transaksiBukti->tgl_pengembalian_rencana ? $transaksiBukti->tgl_pengembalian_rencana->format('d/m/Y') : $transaksiBukti->batas_kembali->format('d/m/Y') }}</p>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modal-bukti-pinjam').classList.remove('hidden');
    });
</script>
@endif

<script>
    // Set max tanggal pengembalian 7 hari dari tanggal pinjam
    document.getElementById('tgl_peminjaman')?.addEventListener('change', function() {
        const pinjam = this.value;
        const pengembalian = document.getElementById('tgl_pengembalian_rencana');
        if (pinjam) {
            const minDate = new Date(pinjam);
            const maxDate = new Date(pinjam);
            maxDate.setDate(maxDate.getDate() + 7);
            pengembalian.min = pinjam;
            pengembalian.max = maxDate.toISOString().split('T')[0];
        }
    });
</script>

@endsection
