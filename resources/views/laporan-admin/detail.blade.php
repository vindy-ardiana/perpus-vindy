@include('layout.header')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-bold text-indigo-700">Detail Laporan Peminjaman</h3>
    </div>


    <!-- CARD TABLE -->
    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-16">No</th>
                    <th class="px-6 py-4 text-left w-16">Judul Buku</th>      
                    <th class="px-6 py-4 text-left">Pengarang Buku</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $key => $p)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4">
                            {{ $no++ }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $p->buku->judul ?? '-' }}
                        </td>
                        <td class="px-6 py-4 font-medium">
                            {{ $p->buku->pengarang ?? '-' }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($data->count() == 0)
            <div class="text-center py-12 text-gray-500">
                Data detail tidak ditemukan
            </div>
        @endif
    </div>

    <!-- PAGINATION -->
    <div>
        {{ $data->links('vendor.pagination.tailwind') }}
    </div>

</div>

@include('layout.footer')
