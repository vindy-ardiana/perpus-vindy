@include('layout.header')

<div class="space-y-6">
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 rounded-2xl text-white shadow-lg">
        <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h3>
        <p class="text-indigo-100">
            @if(Auth::user()->role === 'admin')
                Kelola data perpustakaan digital dan pengaturan sistem.
            @elseif(Auth::user()->role === 'petugas')
                Kelola data perpustakaan dan konfirmasi peminjaman.
            @else
                Kelola data perpustakaan digital dengan tampilan modern.
            @endif
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Total Buku</p>
            <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalBuku) }}</h4>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Kategori</p>
            <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalKategori) }}</h4>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Penerbit</p>
            <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalPenerbit) }}</h4>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-indigo-100 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">User Aktif</p>
            <h4 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($totalUserAktif) }}</h4>
        </div>
    </div>
</div>

@include('layout.footer')
