<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Pemain - Mekar Jaya Sport Subang</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #1e293b; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 800; color: #14532d; }
        .header p { margin: 4px 0 0 0; font-size: 12px; color: #475569; }
        .meta { display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: bold; background: #f8fafc; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th { background-color: #14532d; color: #ffffff; text-transform: uppercase; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { background: #16a34a; color: white; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-family: monospace; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; text-align: center; }
        .signature { margin-top: 50px; border-top: 1px solid #94a3b8; width: 180px; display: inline-block; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="background: #16a34a; color: white; padding: 8px 16px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ Cetak / Simpan Ke PDF
        </button>
    </div>

    <div class="header">
        <h1>AKADEMI SEKOLAH SEPAK BOLA (SSB) MEKAR JAYA SUBANG</h1>
        <p>Jl. Arief Rahman Hakim No.18, Cigadung & Lapangan Veteran Dangdeur, Subang, Jawa Barat | Kontak: 0851-3346-3626</p>
    </div>

    <h2 style="text-align: center; font-size: 16px; text-transform: uppercase; margin-bottom: 10px;">
        DAFTAR NAMA SISWA SSB (ROSTER PEMAIN)
    </h2>

    <div class="meta">
        <div>
            Filter Tahun Lahir: 
            <strong>{{ $selectedYear ? 'Kelahiran ' . $selectedYear : 'Semua Angkatan' }}</strong>
            @if($selectedKu) | KU: <strong>{{ $selectedKu }}</strong> @endif
        </div>
        <div>
            Total Pemain: <strong>{{ $players->count() }} Orang</strong> | Tanggal Cetak: {{ date('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>NIS</th>
                <th>Nama Lengkap Pemain</th>
                <th style="text-align: center;">Tahun Lahir</th>
                <th style="text-align: center;">Usia</th>
                <th>Posisi</th>
                <th>Nama Orang Tua / Wali</th>
                <th>No. Telepon WA</th>
            </tr>
        </thead>
        <tbody>
            @forelse($players as $index => $player)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $player->nis }}</td>
                    <td style="font-weight: bold;">{{ $player->full_name }}</td>
                    <td style="text-align: center;">
                        <span class="badge">{{ $player->birth_year }}</span>
                    </td>
                    <td style="text-align: center;">{{ $player->age }} Thn</td>
                    <td>{{ $player->position }}</td>
                    <td>{{ $player->parent_name }}</td>
                    <td>{{ $player->parent_phone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #94a3b8; padding: 20px;">
                        Tidak ada data pemain untuk kriteria ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>
            <p>Mengetahui,</p>
            <p>Head Coach SSB Mekar Jaya</p>
            <div class="signature"></div>
            <p><strong>Coach Hendra Wijaya</strong></p>
        </div>
        <div>
            <p>Subang, {{ date('d F Y') }}</p>
            <p>Pengurus / Sekretariat SSB</p>
            <div class="signature"></div>
            <p><strong>Admin Mekar Jaya Sport</strong></p>
        </div>
    </div>

</body>
</html>
