@include('layout.header')

<div class="space-y-6">
    @if(session('success'))<div class="p-4 rounded-lg bg-green-100 text-green-700">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="p-4 rounded-lg bg-red-100 text-red-700">{{ session('error') }}</div>@endif
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h3 class="text-2xl font-bold text-indigo-700">Laporan Data Buku</h3>
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul/pengarang..." class="px-3 py-2 border rounded-lg text-sm w-48">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Cari</button>
            </form>
            <a href="{{ route('laporan.buku.pdf') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                <span class="material-icons text-sm">picture_as_pdf</span>
                Cetak PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-12">No</th>
                    <th class="px-6 py-4 text-left">Judul</th>
                    <th class="px-6 py-4 text-left">Pengarang</th>
                    <th class="px-6 py-4 text-left">Penerbit</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($buku as $i => $b)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $buku->firstItem() + $i }}</td>
                    <td class="px-6 py-4 font-medium">{{ $b->judul }}</td>
                    <td class="px-6 py-4">{{ $b->pengarang ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $b->penerbit->nama_penerbit ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $b->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $b->stok }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $buku->links('vendor.pagination.tailwind') }}</div>
    </div>
</div>

@include('layout.footer')
