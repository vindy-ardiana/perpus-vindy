@include('layout.header')

<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('penerbit.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition text-sm">
            <span class="material-icons text-lg">arrow_back</span> Kembali
        </a>
        <h2 class="text-xl font-bold text-indigo-700">Tambah Penerbit</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 max-w-xl">
        <form action="{{ route('penerbit.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nama_penerbit" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penerbit <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_penerbit" id="nama_penerbit" value="{{ old('nama_penerbit') }}" required
                        placeholder="Nama penerbit"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('nama_penerbit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('penerbit.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('layout.footer')
