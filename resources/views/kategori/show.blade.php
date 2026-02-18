@include('layout.header')

<div class="max-w-3xl bg-white rounded-2xl shadow border border-indigo-100 p-6">

    <h3 class="text-2xl font-bold text-indigo-700 mb-6">
        Detail Kategori
    </h3>

    <table class="w-full text-sm">
        <tbody class="divide-y">

            <tr>
                <td class="py-3 text-gray-500 w-40">Nama Kategori</td>
                <td class="py-3 font-medium text-gray-800">
                    {{ $kategori->nama_kategori }}
                </td>
            </tr>

            <tr>
                <td class="py-3 text-gray-500">Dibuat</td>
                <td class="py-3 text-gray-700">
                    {{ $kategori->created_at->format('d M Y, H:i') }}
                </td>
            </tr>

            <tr>
                <td class="py-3 text-gray-500">Terakhir Diubah</td>
                <td class="py-3 text-gray-700">
                    {{ $kategori->updated_at->format('d M Y, H:i') }}
                </td>
            </tr>

        </tbody>
    </table>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('kategori.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
           Kembali
        </a>

        <a href="{{ route('kategori.edit', $kategori->id) }}"
           class="px-4 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200">
           Edit
        </a>
    </div>

</div>

@include('layout.footer')