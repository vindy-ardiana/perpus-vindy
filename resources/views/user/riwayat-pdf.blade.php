<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Peminjaman - {{ $user->name }}</title>
    <style>
        body { font-family: Helvetica, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #e0e7ff; }
        .text-center { text-align: center; }
        h2 { margin-bottom: 4px; font-size: 14px; }
        .meta { color: #555; margin-bottom: 12px; font-size: 10px; }
        .info-block { margin-bottom: 12px; }
    </style>
</head>
<body>
    <h2>Riwayat Peminjaman Buku</h2>
    <div class="info-block">
        <p><strong>Peminjam:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p class="meta">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width:28px">No</th>
                <th>No. Peminjaman</th>
                <th>Judul Buku</th>
                <th class="text-center">Tgl Pinjam</th>
                <th class="text-center">Tgl Selesai (Batas)</th>
                <th class="text-center">Tgl Kembali</th>
                <th class="text-center">Lama (hari)</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $i => $p)
            @php
                $tglPinjam = $p->tgl_peminjaman;
                $tglBatas = $p->batas_kembali;
                $tglKembali = $p->tgl_kembali;
                $lamaHari = $tglKembali
                    ? $tglPinjam->diffInDays($tglKembali)
                    : $tglPinjam->diffInDays($tglBatas);
                $status = $p->status === 'Proses' ? 'Menunggu Konfirmasi' :
                    ($p->status === 'Tolak' ? 'Ditolak' :
                    ($p->status_pengembalian === 'MenungguPengembalian' ? 'Menunggu Pengembalian' :
                    ($p->status_pengembalian === 'Dikembalikan' ? 'Dikembalikan' : 'Dipinjam')));
            @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $p->no_peminjaman ?? '-' }}</td>
                <td>{{ $p->buku->judul ?? '-' }}</td>
                <td class="text-center">{{ $tglPinjam ? $tglPinjam->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ $tglBatas ? $tglBatas->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ $tglKembali ? $tglKembali->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ $lamaHari }} hari</td>
                <td class="text-center">{{ $status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($riwayat->isEmpty())
        <p style="margin-top:15px">Belum ada riwayat peminjaman.</p>
    @endif
</body>
</html>
