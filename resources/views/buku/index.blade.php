@include('layout.header')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-bold text-indigo-700">Buku</h3>

        <div class="flex items-center gap-3">
            <!-- SEARCH -->
            <form action="{{ route('buku.index') }}" method="get" class="flex items-center gap-2">
                <input type="text" name="q"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-300"
                       placeholder="Cari buku...">
                <button type="submit"
                        class="px-4 py-2 bg-emerald-500 text-white rounded-lg text-sm
                               hover:bg-emerald-600 transition">
                    Cari
                </button>
            </form>

            <!-- TAMBAH -->
            <a href="{{ route('buku.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2
                      bg-indigo-600 text-white rounded-xl
                      hover:bg-indigo-700 shadow transition">
                <span class="material-icons text-sm">add</span>
                Tambah Buku
            </a>
        </div>
    </div>

    <!-- CARD TABLE -->
    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold w-16">No</th>
                    <th class="px-6 py-4 text-left font-semibold w-24">Cover</th>
                    <th class="px-6 py-4 text-left font-semibold">Judul</th>
                    <th class="px-6 py-4 text-left font-semibold">Pengarang</th>
                    <th class="px-6 py-4 text-center font-semibold w-24">Tahun</th>
                    <th class="px-6 py-4 text-left font-semibold">Penerbit</th>
                    <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                    <th class="px-6 py-4 text-center font-semibold w-64">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($allBuku as $key => $r)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 text-gray-600">
                        {{ $key + $allBuku->firstItem() }}
                    </td>

                    <td class="px-6 py-4">
                        @if ($r->cover)
                            <img src="{{ asset('storage/' . $r->cover) }}"
                                 class="w-16 h-20 object-cover rounded-lg shadow">
                        @else
                            <span class="text-gray-400 text-xs">No Cover</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $r->judul }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->pengarang }}
                    </td>

                    <td class="px-6 py-4 text-center text-gray-700">
                        {{ $r->tahun_terbit }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->penerbit->nama_penerbit }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">

                            <!-- DETAIL -->
                            <a href="{{ route('buku.show', $r->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                      bg-emerald-100 text-emerald-700 text-xs font-medium
                                      hover:bg-emerald-200 hover:shadow transition">
                                <span class="material-icons text-sm">visibility</span>
                                Detail
                            </a>

                            <!-- EDIT -->
                            <a href="{{ route('buku.edit', $r->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                      bg-amber-100 text-amber-700 text-xs font-medium
                                      hover:bg-amber-200 hover:shadow transition">
                                <span class="material-icons text-sm">edit</span>
                                Edit
                            </a>

                            <!-- HAPUS -->
                            <form action="{{ route('buku.destroy', $r->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                           bg-red-100 text-red-700 text-xs font-medium
                                           hover:bg-red-200 hover:shadow transition">
                                    <span class="material-icons text-sm">delete</span>
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        @if ($allBuku->count() == 0)
        <div class="text-center py-12 text-gray-500">
            Belum ada data buku
        </div>
        @endif

    </div>

    <!-- PAGINATION -->
    <div>
        {{ $allBuku->links('vendor.pagination.tailwind') }}
    </div>

</div>

@include('layout.footer')