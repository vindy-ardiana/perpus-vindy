@include('layout.header')

<div class="space-y-6">
    <div class="flex items-center gap-4">
        @php
            $backRoute = $TransaksiPeminjaman->status === 'Proses'
                ? route('konfirmasi.peminjaman')
                : ($TransaksiPeminjaman->status === 'Setuju' && $TransaksiPeminjaman->status_pengembalian === 'MenungguPengembalian'
                    ? route('konfirmasi.pengembalian')
                    : route('konfirmasi.index'));
        @endphp
        <a href="{{ $backRoute }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
            <span class="material-icons text-lg">arrow_back</span>
            Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-100 text-green-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-100 text-red-700">{{ session('error') }}</div>
    @endif
    @if(session('warning'))
        <div class="p-4 rounded-xl bg-amber-100 text-amber-700">{{ session('warning') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-indigo-100 bg-indigo-50/50">
            <h2 class="text-xl font-bold text-indigo-700">Detail Peminjaman #{{ $TransaksiPeminjaman->no_peminjaman }}</h2>
        </div>

        <div class="p-6 md:p-8 grid md:grid-cols-2 gap-8">
            <!-- Info Peminjam -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Peminjam</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex">
                        <dt class="w-36 text-slate-500">Nama</dt>
                        <dd class="font-medium">{{ $TransaksiPeminjaman->user->name ?? '-' }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="w-36 text-slate-500">Email</dt>
                        <dd>{{ $TransaksiPeminjaman->user->email ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Info Transaksi -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Transaksi</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex">
                        <dt class="w-36 text-slate-500">No. Peminjaman</dt>
                        <dd class="font-mono">{{ $TransaksiPeminjaman->no_peminjaman }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="w-36 text-slate-500">Tanggal Pinjam</dt>
                        <dd>{{ $TransaksiPeminjaman->tgl_peminjaman->format('d/m/Y') }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="w-36 text-slate-500">Batas Kembali</dt>
                        <dd>{{ $TransaksiPeminjaman->batas_kembali->format('d/m/Y') }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="w-36 text-slate-500">Tanggal Kembali</dt>
                        <dd>{{ $TransaksiPeminjaman->tgl_kembali ? $TransaksiPeminjaman->tgl_kembali->format('d/m/Y') : '-' }}</dd>
                    </div>
                    <div class="flex items-center gap-2">
                        <dt class="w-36 text-slate-500">Status</dt>
                        <dd>
                            @php
                                $label = $TransaksiPeminjaman->status === 'Proses' ? 'Diajukan' : ($TransaksiPeminjaman->status === 'Tolak' ? 'Ditolak' : ($TransaksiPeminjaman->status_pengembalian === 'MenungguPengembalian' ? 'Menunggu Pengembalian' : ($TransaksiPeminjaman->status_pengembalian === 'Dikembalikan' ? 'Sudah Dikembalikan' : 'Dipinjam')));
                                $class = $TransaksiPeminjaman->status === 'Proses' ? 'bg-amber-100 text-amber-700' : ($TransaksiPeminjaman->status === 'Tolak' ? 'bg-red-100 text-red-700' : ($TransaksiPeminjaman->status_pengembalian === 'MenungguPengembalian' ? 'bg-blue-100 text-blue-700' : ($TransaksiPeminjaman->status_pengembalian === 'Dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700')));
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $class }}">{{ $label }}</span>
                            @if($TransaksiPeminjaman->isTerlambat() && $TransaksiPeminjaman->status_pengembalian === 'Dipinjam')
                                <span class="ml-1 px-2 py-0.5 rounded text-xs bg-red-100 text-red-700">Terlambat</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Info Buku -->
        <div class="border-t border-indigo-100 p-6 md:p-8">
            <h3 class="text-sm font-semibold uppercase tracking-wide text-indigo-600 mb-4">Buku yang dipinjam</h3>
            <div class="flex flex-wrap gap-6 items-start">
                @if($TransaksiPeminjaman->buku->cover)
                    <img src="{{ asset('storage/'.$TransaksiPeminjaman->buku->cover) }}"
                        class="w-24 h-32 object-cover rounded-lg border border-indigo-100 shadow" alt="">
                @else
                    <div class="w-24 h-32 rounded-lg bg-slate-200 flex items-center justify-center text-slate-500 text-xs">No cover</div>
                @endif
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-lg text-slate-800">{{ $TransaksiPeminjaman->buku->judul }}</h4>
                    <p class="text-sm text-slate-500">{{ $TransaksiPeminjaman->buku->penulis ?? '-' }}</p>
                    <p class="text-sm text-slate-500">{{ $TransaksiPeminjaman->buku->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }} · {{ $TransaksiPeminjaman->buku->penerbit->nama_penerbit ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Aksi Konfirmasi -->
        <div class="border-t border-indigo-100 px-6 py-4 bg-slate-50/50 flex flex-wrap gap-3">
            @if($TransaksiPeminjaman->status === 'Proses')
                <a href="{{ route('setuju', $TransaksiPeminjaman) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-500 text-white font-medium hover:bg-green-600 transition shadow-sm">
                    <span class="material-icons text-lg">check_circle</span>
                    Setujui Peminjaman
                </a>
                <a href="{{ route('tolak', $TransaksiPeminjaman) }}"
                    onclick="return confirm('Yakin menolak pengajuan ini?');"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-500 text-white font-medium hover:bg-red-600 transition shadow-sm">
                    <span class="material-icons text-lg">cancel</span>
                    Tolak
                </a>
            @elseif($TransaksiPeminjaman->status === 'Setuju' && $TransaksiPeminjaman->status_pengembalian === 'MenungguPengembalian')
                <a href="{{ route('konfirmasi.setujui.pengembalian', $TransaksiPeminjaman) }}"
                    onclick="return confirm('Setujui pengembalian buku?');"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-500 text-white font-medium hover:bg-green-600 transition shadow-sm">
                    <span class="material-icons text-lg">check_circle</span>
                    Setujui Pengembalian
                </a>
                <a href="{{ route('konfirmasi.tolak.pengembalian', $TransaksiPeminjaman) }}"
                    onclick="return confirm('Tolak pengajuan pengembalian? User harus mengajukan kembali.');"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-500 text-white font-medium hover:bg-red-600 transition shadow-sm">
                    <span class="material-icons text-lg">cancel</span>
                    Tolak Pengembalian
                </a>
            @else
                <span class="text-slate-500 text-sm">Tidak ada aksi untuk status ini.</span>
            @endif
        </div>
    </div>
</div>

@include('layout.footer')
