@include('layout.header')

<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition text-sm">
            <span class="material-icons text-lg">arrow_back</span> Kembali
        </a>
        <h2 class="text-xl font-bold text-indigo-700">Edit Buku</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul', $buku->judul) }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="pengarang" class="block text-sm font-medium text-gray-700 mb-1.5">Pengarang <span class="text-red-500">*</span></label>
                        <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('pengarang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Terbit <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required min="1900" max="2100"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('tahun_terbit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="penerbit_id" class="block text-sm font-medium text-gray-700 mb-1.5">Penerbit <span class="text-red-500">*</span></label>
                        <select name="penerbit_id" id="penerbit_id" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($penerbit as $p)
                                <option value="{{ $p->id }}" {{ old('penerbit_id', $buku->penerbit_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_penerbit }}</option>
                            @endforeach
                        </select>
                        @error('penerbit_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500 mb-2">Pilih satu atau lebih kategori (centang yang sesuai)</p>
                    <div class="flex flex-wrap gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        @foreach($kategori as $k)
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori_ids[]" value="{{ $k->id }}"
                                    {{ in_array($k->id, old('kategori_ids', $buku->kategoris->pluck('id')->toArray())) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">{{ $k->nama_kategori }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('kategori_ids')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700 mb-1.5">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok', $buku->stok) }}" required min="0"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('stok')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="file_cover" class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Sampul</label>
                        @if($buku->cover)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover saat ini" class="w-20 h-28 object-cover rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500 mt-1">Cover saat ini. Kosongkan jika tidak ganti.</p>
                            </div>
                        @endif
                        <input type="file" name="file_cover" id="file_cover" accept="image/jpeg,image/jpg,image/png"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-white file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700">
                        <input type="hidden" name="cover_lama" value="{{ $buku->cover }}">
                        @error('file_cover')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('buku.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@include('layout.footer')
