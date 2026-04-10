<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Buku</title>
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

    <h2>Laporan Data Buku</h2>
    <p class="meta">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Kategori</th>
                <th class="text-center">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $i => $b)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $b->judul }}</td>
                <td>{{ $b->pengarang ?? '-' }}</td>
                <td>{{ $b->penerbit->nama_penerbit ?? '-' }}</td>
                <td>{{ $b->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}</td>
                <td class="text-center">{{ $b->stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($buku->isEmpty())
        <p style="margin-top:15px">Tidak ada data.</p>
    @endif

    <div style="margin-top:50px; width:100%; text-align:right;">
        <p>Bandung, {{ now()->format('d F Y') }}</p>
        <p>Petugas Perpustakaan</p>
        <br><br><br>
        <p>(__________________)</p>
    </div>

</body>
</html> 