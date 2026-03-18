@include('layout.header')

<div class="space-y-6">
    @if(session('success'))<div class="p-4 rounded-lg bg-green-100 text-green-700">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="p-4 rounded-lg bg-red-100 text-red-700">{{ session('error') }}</div>@endif
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h3 class="text-2xl font-bold text-indigo-700">Laporan Riwayat Peminjaman & Pengembalian Buku</h3>
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="dari" value="{{ $dari }}" class="px-3 py-2 border rounded-lg text-sm">
                <span class="text-gray-500">s/d</span>
                <input type="date" name="sampai" value="{{ $sampai }}" class="px-3 py-2 border rounded-lg text-sm">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Filter</button>
            </form>
            <a href="{{ route('laporan.transaksi.pdf', request()->only(['dari','sampai'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                <span class="material-icons text-sm">picture_as_pdf</span>
                Download PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-12">No</th>
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-center">Tgl Kembali</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($items as $i => $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $items->firstItem() + $i }}</td>
                    <td class="px-6 py-4 font-medium">{{ $p->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $p->buku->judul ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $p->tgl_peminjaman->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-center">{{ $p->tgl_kembali ? $p->tgl_kembali->format('d/m/Y') : '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($p->status === 'Proses') Diajukan
                        @elseif($p->status === 'Tolak') Ditolak
                        @else {{ $p->status_pengembalian === 'Dikembalikan' ? 'Dikembalikan' : 'Dipinjam' }}
                        @endif
                     
                        <td class="px-6 py-4 text-center">
    <form action="{{ route('laporan.transaksi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini?')">
        @csrf
        @method('DELETE')
        <button class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs hover:bg-red-700">
            Hapus
        </button>
    </form>
</td>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $items->links('vendor.pagination.tailwind') }}</div>
    </div>
</div>

@include('layout.footer')
