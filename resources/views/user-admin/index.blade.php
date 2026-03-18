@include('layout.header')

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h3 class="text-2xl font-bold text-indigo-700">Kelola User (Peminjam)</h3>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-100 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <div class="p-4 border-b border-indigo-100">
            <form method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email..." class="px-3 py-2 border rounded-lg text-sm w-64">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Cari</button>
            </form>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-12">No</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($users as $index => $u)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium">{{ $u->name }}</td>
                    <td class="px-6 py-4">{{ $u->email }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('user.destroy', ['user' => $u]) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus user ini? Semua data peminjaman user akan terpengaruh.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 text-xs font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $users->links('vendor.pagination.tailwind') }}</div>
    </div>
</div>

@include('layout.footer')
