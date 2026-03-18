@include('layout.header')

<div class="space-y-6">
    <h3 class="text-2xl font-bold text-indigo-700">Ulasan User</h3>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-100 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="px-6 py-4 text-left w-12">No</th>
                    <th class="px-6 py-4 text-left">User</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-left">Rating</th>
                    <th class="px-6 py-4 text-left">Ulasan</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($ulasan as $u)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration + ($ulasan->currentPage() - 1) * $ulasan->perPage() }}</td>
                    <td class="px-6 py-4 font-medium">{{ $u->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $u->transaksiPeminjaman->buku->judul ?? '-' }}</td>
                    <td class="px-6 py-4">@if($u->rating ?? 0) ★ {{ $u->rating }}/5 @else - @endif</td>
                    <td class="px-6 py-4 max-w-xs">{{ Str::limit($u->isi_ulasan, 100) }}</td>
                    <td class="px-6 py-4">{{ $u->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('ulasan.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus ulasan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-red-100 text-red-700 hover:bg-red-200">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12 text-gray-500">Belum ada ulasan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $ulasan->links('vendor.pagination.tailwind') }}
</div>

@include('layout.footer')
