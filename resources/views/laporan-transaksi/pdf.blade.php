<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Peminjaman</title>
    <style>
        body { font-family: Helvetica, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #e0e7ff; }
        .text-center { text-align: center; }
        h2 { margin-bottom: 5px; }
        .meta { color: #666; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Laporan Riwayat Peminjaman Buku</h2>
    <p class="meta">
        @if(!empty($dari) && !empty($sampai))
            Periode: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
        @else
            Semua data
        @endif
        &middot; Dicetak: {{ now()->format('d/m/Y H:i') }}
    </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th class="text-center">Tgl Pinjam</th>
                <th class="text-center">Tgl Kembali</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->buku->judul ?? '-' }}</td>
                <td class="text-center">{{ $p->tgl_peminjaman ? \Carbon\Carbon::parse($p->tgl_peminjaman)->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                <td class="text-center">
                    @if($p->status === 'Proses') Diajukan
                    @elseif($p->status === 'Tolak') Ditolak
                    @else {{ $p->status_pengembalian === 'Dikembalikan' ? 'Dikembalikan' : 'Dipinjam' }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($items->isEmpty())
        <p style="margin-top:15px">Tidak ada data.</p>
    @endif
</body>
</html>
