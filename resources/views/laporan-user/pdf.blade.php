<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data User</title>
    <style>
        body { font-family: Helvetica, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #e0e7ff; }
        h2 { margin-bottom: 5px; }
        .meta { color: #666; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Laporan Data User (Peminjam)</h2>
    <p class="meta">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($users->isEmpty())
        <p style="margin-top:15px">Tidak ada data.</p>
    @endif
</body>
</html>
