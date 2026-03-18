@include('layout.header')

<div class="space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                <span class="material-icons text-lg">arrow_back</span>
                Kembali
            </a>
            <h3 class="text-2xl font-bold text-indigo-700">Konfirmasi Pengembalian</h3>
        </div>

        <form method="GET" class="flex items-center gap-3">
            <input type="date" name="dari" value="{{ $dari ?? '' }}"
                class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-300">
            <span class="text-gray-500 text-sm">s/d</span>
            <input type="date" name="sampai" value="{{ $sampai ?? '' }}"
                class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-300">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Filter
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-100 text-green-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-lg bg-red-100 text-red-700">{{ session('error') }}</div>
    @endif
    @if(session('warning'))
        <div class="p-4 rounded-lg bg-amber-100 text-amber-700">{{ session('warning') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-12">No</th>
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-center">Batas Kembali</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @php $no = 1; @endphp
                @foreach ($pengembalian as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $no++ }}</td>
                        <td class="px-6 py-4 font-medium">{{ $p->user->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $p->buku->judul ?? '-' }}</td>
                        <td class="px-6 py-4 text-center text-slate-600">{{ $p->tgl_peminjaman->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-center text-slate-600">{{ $p->batas_kembali->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('konfirmasi.show', $p) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition">
                                    <span class="material-icons text-sm">visibility</span>
                                    Detail
                                </a>
                                <a href="{{ route('konfirmasi.setujui.pengembalian', $p) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-green-500 text-white hover:bg-green-600 transition"
                                    onclick="return confirm('Setujui pengembalian buku?');">
                                    Setujui
                                </a>
                                <a href="{{ route('konfirmasi.tolak.pengembalian', $p) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-500 text-white hover:bg-red-600 transition"
                                    onclick="return confirm('Tolak pengajuan pengembalian? User harus mengajukan kembali.');">
                                    Tolak
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($pengembalian->count() == 0)
            <div class="text-center py-12 text-gray-500">
                Tidak ada pengajuan pengembalian yang menunggu konfirmasi.
            </div>
        @endif
    </div>

    <div>{{ $pengembalian->links('vendor.pagination.tailwind') }}</div>
</div>

@include('layout.footer')
