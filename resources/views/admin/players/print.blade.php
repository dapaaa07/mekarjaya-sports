<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Pemain - Mekar Jaya Sport Subang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; font-size: 12px; color: #111111; margin: 24px; background: #ffffff; }
        .header { text-align: center; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; font-weight: 800; color: #111111; }
        .header p { margin: 4px 0 0 0; font-size: 11px; color: #666666; }
        .meta { display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: 600; background: #FAFAFA; padding: 12px; border: 1px solid #EAEAEA; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #EAEAEA; padding: 8px 10px; text-align: left; }
        th { background-color: #111111; color: #ffffff; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        tr:nth-child(even) { background-color: #FAFAFA; }
        .badge { background: #FF6B00; color: white; padding: 2px 6px; border-radius: 6px; font-weight: bold; font-family: monospace; font-size: 11px; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; text-align: center; font-size: 12px; }
        .signature { margin-top: 50px; border-top: 1px solid #111111; width: 180px; display: inline-block; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="background: #FF6B00; color: white; padding: 10px 20px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 12px; box-shadow: 0 2px 8px rgba(255, 107, 0, 0.25);">
            🖨️ Cetak / Simpan Ke PDF
        </button>
    </div>

    <div class="header">
        <h1>AKADEMI SEKOLAH SEPAK BOLA (SSB) MEKAR JAYA SUBANG</h1>
        <p>Jl. Arief Rahman Hakim No.18, Cigadung & Lapangan Veteran Dangdeur, Subang, Jawa Barat | Kontak: 0851-3346-3626</p>
    </div>

    <h2 style="text-align: center; font-size: 15px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px;">
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
                    <td style="font-weight: 600;">{{ $player->full_name }}</td>
                    <td style="text-align: center;">
                        <span class="badge">{{ $player->birth_year }}</span>
                    </td>
                    <td style="text-align: center; font-weight: 500;">{{ $player->age }} Thn</td>
                    <td>{{ $player->position }}</td>
                    <td>{{ $player->parent_name }}</td>
                    <td>{{ $player->parent_phone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #666666; padding: 24px;">
                        Tidak ada data pemain untuk kriteria ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>
            <p style="color: #666666;">Mengetahui,</p>
            <p>Head Coach SSB Mekar Jaya</p>
            <div class="signature"></div>
            <p><strong>Coach Hendra Wijaya</strong></p>
        </div>
        <div>
            <p style="color: #666666;">Subang, {{ date('d F Y') }}</p>
            <p>Pengurus / Sekretariat SSB</p>
            <div class="signature"></div>
            <p><strong>Admin Mekar Jaya Sport</strong></p>
        </div>
    </div>

</body>
</html>
