<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Performa Siswa - {{ $player->full_name }} ({{ $player->nis }})</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body class="p-6 sm:p-8 max-w-4xl mx-auto bg-white text-[#111111] font-sans">

    <!-- Action Bar -->
    <div class="no-print mb-6 flex flex-wrap items-center justify-between gap-3 bg-[#F4F4F4] p-4 border-2 border-[#111111]">
        <span class="text-xs font-mono font-bold text-[#111111] uppercase">Dokumen Rapor Performa Resmi SSB Mekar Jaya Subang</span>
        <button type="button" onclick="window.print()" class="btn-primary px-5 py-2.5 text-xs font-bold">
            <i class="fa-solid fa-print" aria-hidden="true"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- Mondrian Top Ribbon -->
    <div class="grid grid-cols-12 h-2.5 border-2 border-[#111111] mb-6" aria-hidden="true">
        <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
        <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
        <div class="col-span-3 bg-[#FFFF00]"></div>
    </div>

    <!-- Official Header -->
    <div class="border-b-2 border-[#111111] pb-6 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Logo SSB Mekar Jaya" class="w-16 h-16 object-cover border-2 border-[#111111]">
            <div>
                <h1 class="text-xl font-bold uppercase tracking-tight text-[#111111]">SSB MEKAR JAYA SUBANG</h1>
                <p class="text-xs text-[#525252] font-medium">Sekolah Sepak Bola Usia Dini & Akademi Talenta Muda Subang</p>
                <p class="text-[11px] font-mono text-[#525252]">Sekretariat: Lapangan Veteran Dangdeur Subang | Telp/WA: 0851-3346-3626</p>
            </div>
        </div>
        <div class="flex items-center gap-4 sm:text-right">
            <div>
                <span class="inline-block bg-[#111111] text-[#FFFF00] text-xs font-mono font-bold px-3 py-1.5 border border-[#111111] uppercase tracking-wider">RAPOR PERIODIK</span>
                <span class="block text-[11px] font-mono text-[#525252] mt-1">Tanggal Cetak: {{ date('d F Y') }}</span>
                <span class="block text-[10px] font-mono text-[#525252]">Scan QR &rarr; Portal Ortu</span>
            </div>
            <div class="w-20 h-20 bg-white p-1 border-2 border-[#111111] qr-code-frame shrink-0" aria-label="QR Code Portal Orang Tua {{ $player->nis }}">
                {!! $player->generatePortalQrSvg(80) !!}
            </div>
        </div>
    </div>

    <!-- Player Profile Info -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-[#F4F4F4] p-5 border-2 border-[#111111] mb-6 text-xs">
        <div class="space-y-2">
            <div class="flex"><span class="w-36 text-[#525252] font-bold">Nama Lengkap</span>: <strong class="ml-1.5 text-[#111111]">{{ $player->full_name }}</strong></div>
            <div class="flex"><span class="w-36 text-[#525252] font-bold">NIS Siswa</span>: <span class="ml-1.5 font-mono font-bold">{{ $player->nis }}</span></div>
            <div class="flex"><span class="w-36 text-[#525252] font-bold">Tahun Lahir / KU</span>: <span class="ml-1.5 font-bold">{{ $player->birth_year }} ({{ $player->age_category_badge }})</span></div>
            <div class="flex items-center"><span class="w-36 text-[#525252] font-bold">Ukuran Jersey</span>: <span class="ml-1.5 font-mono font-bold bg-[#111111] text-white px-2 py-0.5 text-[11px]">{{ $player->jersey_size ?? 'M' }}</span></div>
        </div>
        <div class="space-y-2">
            <div class="flex"><span class="w-36 text-[#525252] font-bold">Posisi Bermain</span>: <span class="ml-1.5 font-bold">{{ $player->position }}</span></div>
            <div class="flex"><span class="w-36 text-[#525252] font-bold">Tinggi / Berat</span>: <span class="ml-1.5 font-mono">{{ $player->height_cm ?? '-' }} cm / {{ $player->weight_kg ?? '-' }} kg</span></div>
            <div class="flex"><span class="w-36 text-[#525252] font-bold">Tingkat Kehadiran</span>: <span class="ml-1.5 font-mono font-bold text-[#0000FF]">{{ $attendanceRate }}% Sesi Latihan</span></div>
            <div class="flex"><span class="w-36 text-[#525252] font-bold">Status SPP</span>: <span class="ml-1.5 font-bold {{ $player->current_spp_status == 'Lunas' ? 'text-[#14532D]' : 'text-[#991B1B]' }}">{{ $player->current_spp_status }}</span></div>
        </div>
    </div>

    <!-- Performance Evaluation Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Radar Chart Container -->
        <div class="border-2 border-[#111111] p-5 flex flex-col items-center justify-center bg-white">
            <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-[#111111] mb-3">Diagram Radar Skill Atribut</h3>
            <div class="w-64 h-64">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

        <!-- Scores Table -->
        <div class="border-2 border-[#111111] overflow-hidden flex flex-col justify-between bg-white">
            <div class="bg-[#111111] text-[#FFFF00] px-4 py-3 text-xs font-mono font-bold uppercase tracking-wider">
                Nilai Evaluasi Performa Teknis
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <tbody class="divide-y-2 divide-[#111111]">
                    <tr><td class="py-2.5 px-4 font-bold text-[#111111]">Passing & Control</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->passing_score ?? 75 }}/100</td></tr>
                    <tr><td class="py-2.5 px-4 font-bold text-[#111111]">Dribbling & Ball Handling</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->dribbling_score ?? 75 }}/100</td></tr>
                    <tr><td class="py-2.5 px-4 font-bold text-[#111111]">Shooting & Finishing</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->shooting_score ?? 75 }}/100</td></tr>
                    <tr><td class="py-2.5 px-4 font-bold text-[#111111]">Physical & Endurance</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->physical_score ?? 75 }}/100</td></tr>
                    <tr><td class="py-2.5 px-4 font-bold text-[#111111]">Tactical Awareness</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->tactical_score ?? 70 }}/100</td></tr>
                    <tr><td class="py-2.5 px-4 font-bold text-[#111111]">Disiplin & Etika Latihan</td><td class="py-2.5 px-4 text-right font-bold font-mono text-[#0000FF]">{{ $evaluation->discipline_score ?? 80 }}/100</td></tr>
                </tbody>
            </table>
            <div class="p-3.5 bg-[#F4F4F4] text-xs border-t-2 border-[#111111]">
                <strong class="block text-[#111111] font-mono uppercase mb-0.5">Catatan Pelatih Head Coach:</strong>
                <p class="text-[#525252]">"{{ $evaluation->coach_notes ?? 'Pemain menunjukkan dedikasi dan semangat latihan yang baik.' }}"</p>
            </div>
        </div>
    </div>

    <!-- Signature Signoff Footer -->
    <div class="mt-12 grid grid-cols-2 text-center text-xs pt-6 border-t-2 border-[#111111]">
        <div>
            <p class="text-[#525252] mb-12">Orang Tua / Wali Siswa</p>
            <p class="font-bold border-b-2 border-[#111111] inline-block px-8 pb-1">{{ $player->parent_name }}</p>
        </div>
        <div>
            <p class="text-[#525252] mb-12">Head Coach SSB Mekar Jaya</p>
            <p class="font-bold border-b-2 border-[#111111] inline-block px-8 pb-1">Coach Hendra Wijaya</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('radarChart').getContext('2d');
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Passing', 'Dribbling', 'Shooting', 'Physical', 'Tactical', 'Disiplin'],
                    datasets: [{
                        label: 'Skor Atribut Siswa',
                        data: [
                            {{ $evaluation->passing_score ?? 75 }},
                            {{ $evaluation->dribbling_score ?? 75 }},
                            {{ $evaluation->shooting_score ?? 75 }},
                            {{ $evaluation->physical_score ?? 75 }},
                            {{ $evaluation->tactical_score ?? 70 }},
                            {{ $evaluation->discipline_score ?? 80 }}
                        ],
                        backgroundColor: 'rgba(0, 0, 255, 0.16)',
                        borderColor: '#0000FF',
                        borderWidth: 2,
                        pointBackgroundColor: '#FF0000',
                        pointBorderColor: '#111111',
                    }]
                },
                options: {
                    scales: {
                        r: {
                            angleLines: { color: '#D4D4D4' },
                            grid: { color: '#E5E5E5' },
                            pointLabels: { color: '#111111', font: { weight: '700' } },
                            suggestedMin: 50,
                            suggestedMax: 100,
                            ticks: { display: false }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</body>
</html>
