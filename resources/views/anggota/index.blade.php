@include('layout.header')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-bold text-indigo-700">
            Anggota
        </h3>

        <a href="{{ route('anggota.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2
                  bg-indigo-600 text-white rounded-xl
                  hover:bg-indigo-700 shadow-md transition">
            <span class="material-icons text-sm">add</span>
            Tambah Anggota
        </a>
    </div>

    <!-- CARD TABLE -->
    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold w-16">No</th>
                    <th class="px-6 py-4 text-left font-semibold">Nama Anggota</th>
                    <th class="px-6 py-4 text-left font-semibold">Alamat</th>
                    <th class="px-6 py-4 text-left font-semibold">No. Telpon</th>
                    <th class="px-6 py-4 text-center font-semibold w-64">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($allAnggota as $key => $r)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 text-gray-600">
                        {{ $key + 1 }}
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $r->nama_anggota }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->alamat }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->no_telpon }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">

                            <!-- DETAIL -->
                            <a href="{{ route('anggota.show', $r->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                      bg-emerald-100 text-emerald-700 text-xs font-medium
                                      hover:bg-emerald-200 hover:shadow transition">
                                <span class="material-icons text-sm">visibility</span>
                                Detail
                            </a>

                            <!-- EDIT -->
                            <a href="{{ route('anggota.edit', $r->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                      bg-amber-100 text-amber-700 text-xs font-medium
                                      hover:bg-amber-200 hover:shadow transition">
                                <span class="material-icons text-sm">edit</span>
                                Edit
                            </a>

                            <!-- HAPUS -->
                            <form action="{{ route('anggota.destroy', $r->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus anggota ini?')">
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

        @if ($allAnggota->count() == 0)
        <div class="text-center py-12 text-gray-500">
            Belum ada data anggota
        </div>
        @endif

    </div>
</div>

@include('layout.footer')