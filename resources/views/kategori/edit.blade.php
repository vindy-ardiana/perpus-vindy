@include('layout.header')

<h3 class="judul-h3 mb-6">✏️ Edit Kategori</h3>

<form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- FORM CARD -->
    <div class="bg-white p-6 rounded-lg shadow-md w-full mb-6">
        
        <!-- Input -->
        <div class="mb-6">
            <label class="block font-medium text-gray-700 mb-2">
                Nama Kategori
            </label>

            <input
                type="text"
                name="nama_kategori"
                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-blue-400
                       focus:border-blue-400"
                placeholder="Masukkan nama kategori"
            >

            @error('nama_kategori')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('kategori.index') }}"
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