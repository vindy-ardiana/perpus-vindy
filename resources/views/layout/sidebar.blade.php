! <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-indigo-100 flex flex-col shadow-xl">

        <!-- LOGO -->
        <div class="p-4 border-b border-indigo-100">
            <h1 class="text-xl font-bold text-indigo-600">Literia</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ Auth::check() && Auth::user()->role === 'admin' ? 'Admin' : 'Petugas' }}</p>
        </div>

        <!-- MENU -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            @php
                $navClass = 'flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 transition text-sm';
                $navActive = 'bg-indigo-50 text-indigo-600 font-medium';
            @endphp

            <a href="{{ route('dashboard') }}"
               class="{{ $navClass }} {{ request()->routeIs('dashboard') ? $navActive : '' }}">
                <span class="material-icons text-lg text-indigo-500">dashboard</span>
                Dashboard
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Master Data</p>
            <div class="space-y-0.5">
                <a href="{{ route('kategori.index') }}" class="{{ $navClass }} {{ request()->routeIs('kategori.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">category</span> Kategori
                </a>
                <a href="{{ route('penerbit.index') }}" class="{{ $navClass }} {{ request()->routeIs('penerbit.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">business</span> Penerbit
                </a>
                <a href="{{ route('buku.index') }}" class="{{ $navClass }} {{ request()->routeIs('buku.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">menu_book</span> Buku
                </a>
                
            </div>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Transaksi</p>
            <div class="space-y-0.5">
                <a href="{{ route('konfirmasi.peminjaman') }}" class="{{ $navClass }} {{ request()->routeIs('konfirmasi.peminjaman') || request()->routeIs('setuju') || request()->routeIs('tolak') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">menu_book</span> Approve Peminjaman
                </a>
                <a href="{{ route('konfirmasi.pengembalian') }}" class="{{ $navClass }} {{ request()->routeIs('konfirmasi.pengembalian') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">assignment_return</span> Approve Pengembalian
                </a>
                <a href="{{ route('ulasan.index') }}" class="{{ $navClass }} {{ request()->routeIs('ulasan.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">rate_review</span> Ulasan
                </a>
            </div>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Laporan</p>
            <div class="space-y-0.5">
                <a href="{{ route('laporan.buku') }}" class="{{ $navClass }} {{ request()->routeIs('laporan.buku*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">menu_book</span> Data Buku
                </a>
                <a href="{{ route('laporan.transaksi') }}" class="{{ $navClass }} {{ request()->routeIs('laporan.transaksi*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">assignment</span> Peminjaman
                </a>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('laporan.user') }}" class="{{ $navClass }} {{ request()->routeIs('laporan.user*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">people</span> Data User
                </a>
                @endif
            </div>

            @if(Auth::check() && Auth::user()->role === 'admin')
            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">Pengaturan</p>
            <div class="space-y-0.5">
                <a href="{{ route('petugas.index') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">badge</span> Petugas
                </a>
                <a href="{{ route('user.index') }}" class="{{ $navClass }} {{ request()->routeIs('user.*') ? $navActive : '' }}">
                    <span class="material-icons text-lg text-indigo-500">person</span> User
                </a>
            </div>
            @endif
        </nav>

        <!-- LOGOUT -->
        @if(Auth::check())
        <div class="p-4 border-t border-indigo-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2
                    border border-indigo-300 text-indigo-600
                    hover:bg-indigo-50 hover:shadow py-2 rounded-xl transition-all">
                    <span class="material-icons text-sm">logout</span>
                    Logout
                </button>
            </form>
        </div>
        @endif

    </aside>