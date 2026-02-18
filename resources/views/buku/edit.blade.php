@include('layout.header')

<h3 class="judul-h3 mb-6">✏️ Edit Buku</h3>

<form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- CARD FORM -->
    <div class="bg-white p-6 rounded-lg shadow-md w-full mb-6">

        <!-- Judul -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Judul Buku</label>
            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Pengarang -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Pengarang</label>
            <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Tahun Terbit -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Tahun Terbit</label>
            <input type="text" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
        </div>

        <!-- Stok -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Penerbit -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Penerbit</label>
            <select name="penerbit_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($penerbit as $p)
                    <option value="{{ $p->id }}" {{ $p->id == $buku->penerbit_id ? 'selected' : '' }}>
                        {{ $p->nama_penerbit }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Kategori -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Kategori</label>
            <select name="kategori_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ $k->id == $buku->kategori_id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Cover -->
        <div class="mb-6">
            <label class="block font-medium text-gray-700 mb-2">Gambar Sampul</label>

            @if ($buku->cover)
                <img src="{{ asset('storage/' . $buku->cover) }}"
                     alt="Cover Lama"
                     class="w-24 mb-3 rounded shadow">
            @endif

            <input type="file" name="file_cover"
                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white">
        </div>

        <input type="hidden" name="cover_lama" value="{{ $buku->cover }}">

        <!-- Tombol -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('buku.index') }}"
               class="px-5 py-2 rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                Kembali
            </a>

            <button type="submit"
                class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition">
                Update
            </button>
        </div>

    </div>
</form>

@include('layout.footer')