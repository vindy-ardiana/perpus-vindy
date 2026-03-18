<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Peminjaman - {{ $transaksi->no_peminjaman }}</title>
    <style>
        body { font-family: Helvetica, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 4px; font-size: 16px; }
        .meta { color: #555; margin-bottom: 16px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background: #e0e7ff; width: 140px; }
    </style>
</head>
<body>
    <h2>Bukti Peminjaman Buku</h2>
    <p class="meta">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <tr>
            <th>No. Peminjaman</th>
            <td>{{ $transaksi->no_peminjaman }}</td>
        </tr>
        <tr>
            <th>Peminjam</th>
            <td>{{ $transaksi->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Judul Buku</th>
            <td>{{ $transaksi->buku->judul ?? '-' }}</td>
        </tr>
        <tr>
            <th>Penulis</th>
            <td>{{ $transaksi->buku->penulis ?? $transaksi->buku->pengarang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Penerbit</th>
            <td>{{ $transaksi->buku->penerbit->nama_penerbit ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Pinjam</th>
            <td>{{ $transaksi->tgl_peminjaman ? $transaksi->tgl_peminjaman->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Pengembalian</th>
            <td>{{ $transaksi->tgl_pengembalian_rencana ? $transaksi->tgl_pengembalian_rencana->format('d/m/Y') : $transaksi->batas_kembali->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Lama Pinjam</th>
            <td>{{ $transaksi->tgl_peminjaman->diffInDays($transaksi->batas_kembali) }} hari</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Menunggu Konfirmasi</td>
        </tr>
    </table>
</body>
</html>
