@include('layout.header')

<h3 class="judul-h3 mb-6">📘 Detail Buku</h3>

<div class="bg-white p-6 rounded-lg shadow-md w-full mb-6">

    {{-- Cover Buku --}}
    @if ($buku->cover)
        <div class="flex justify-center mb-6">
            <img src="{{ asset('storage/' . $buku->cover) }}"
                 alt="Cover Buku"
                 class="w-40 rounded-md shadow">
        </div>
    @endif

    {{-- Detail Buku --}}
    <table class="w-full text-gray-700">
        <tbody>
            <tr class="border-b">
                <td class="py-2 w-48 font-medium">Judul Buku</td>
                <td class="py-2 w-4">:</td>
                <td class="py-2">{{ $buku->judul }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-2 font-medium">Pengarang</td>
                <td class="py-2">:</td>
                <td class="py-2">{{ $buku->pengarang }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-2 font-medium">Tahun Terbit</td>
                <td class="py-2">:</td>
                <td class="py-2">{{ $buku->tahun_terbit }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-2 font-medium">Penerbit</td>
                <td class="py-2">:</td>
                <td class="py-2">{{ $buku->penerbit->nama_penerbit }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-2 font-medium">Kategori</td>
                <td class="py-2">:</td>
                <td class="py-2">{{ $buku->kategori->nama_kategori }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-2 font-medium align-top">Deskripsi</td>
                <td class="py-2 align-top">:</td>
                <td class="py-2">{{ $buku->deskripsi }}</td>
            </tr>

            <tr>
                <td class="py-2 font-medium">Sisa Stok</td>
                <td class="py-2">:</td>
                <td class="py-2">{{ $buku->stok }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Tombol --}}
    <div class="flex justify-end mt-6">
        <a href="{{ route('buku.index') }}"
           class="px-5 py-2 rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
            Kembali
        </a>
    </div>

</div>

@include('layout.footer')