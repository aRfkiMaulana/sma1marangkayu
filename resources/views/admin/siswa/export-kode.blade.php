<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kode Unik - {{ $data['nama_kelas'] ?? 'Kelas' }}</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .code { font-family: monospace; font-weight: bold; color: #2563eb; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; cursor: pointer;">Cetak Halaman</button>
    </div>

    <div class="header">
        <h2>Buku Tahunan — Daftar Kode Unik Siswa</h2>
        <p>Kelas: <strong>{{ $data['nama_kelas'] ?? '-' }}</strong> | Angkatan: <strong>{{ $data['nama_angkatan'] ?? '-' }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kode Unik</th>
                <th>Berlaku Sampai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['siswa'] ?? [] as $i => $s)
            <tr>
                <td>{{ $s['no'] }}</td>
                <td>{{ $s['nisn'] }}</td>
                <td>{{ $s['nama'] }}</td>
                <td class="code">{{ $s['kode_unik'] }}</td>
                <td>{{ $s['kode_expired_at'] ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada siswa di kelas ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
