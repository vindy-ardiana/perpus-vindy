@include('layout.header')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-bold text-indigo-700">Laporan Peminjaman</h3>

        <!-- FILTER TANGGAL -->
        <form method="GET" class="flex items-center gap-3">
            <input type="date" name="dari" value="{{ $dari }}"
                class="px-3 py-2 border rounded-lg text-sm
                       focus:ring-2 focus:ring-indigo-300">

            <span class="text-gray-500 text-sm">s/d</span>

            <input type="date" name="sampai" value="{{ $sampai }}"
                class="px-3 py-2 border rounded-lg text-sm
                       focus:ring-2 focus:ring-indigo-300">

            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg
                       hover:bg-indigo-700 transition">
                Filter
            </button>
        </form>
    </div>


    <!-- CARD TABLE -->
    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-16">No</th>
                    <th class="px-6 py-4 text-left">Nama Peminjam</th>
                    <th class="px-6 py-4 text-center">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-center">Tanggal Kembali</th>
                    <th class="px-6 py-4 text-center">Total Pinjam Buku</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @php
                    $no = 1;
                @endphp
                @foreach ($peminjaman as $key => $p)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4">
                            {{ $no++ }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $p->user->name ?? '-' }}
                        </td>



                        <td class="px-6 py-4 text-center">
                            {{ $p->tgl_peminjaman }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $p->tgl_kembali ?? '-' }}
                        </td>
                      
                        <td class="px-6 py-4 text-center">
                            {{ $p->peminjaman_bukus_count }} Buku
                        </td>

                      

                        <td class="px-6 py-4 text-center">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $p->status_pengembalian == 'Dipinjam'
                                ? 'bg-yellow-100 text-yellow-700'
                                : ($p->status == 'kembali'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($p->status_pengembalian) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('setuju', $p) }}"
                                class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                     bg-green-500 text-white hover:bg-green-600 transition">
                                Setujui
                            </a>
                            <a href="{{ route('tolak', $p) }}"
                                class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                     bg-red-500 text-white hover:bg-red-600 transition">
                                Tolak
                            </a>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($peminjaman->count() == 0)
            <div class="text-center py-12 text-gray-500">
                Data peminjaman tidak ditemukan
            </div>
        @endif
    </div>

    <!-- PAGINATION -->
    <div>
        {{ $peminjaman->links('vendor.pagination.tailwind') }}
    </div>

</div>

@include('layout.footer')
