<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Performa Siswa - {{ $player->full_name }} ({{ $player->nis }})</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: #111111; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body class="p-8 max-w-4xl mx-auto">

    <!-- Action Bar -->
    <div class="no-print mb-6 flex items-center justify-between bg-[#f5f1ec] p-4 rounded-lg border border-[#d3cec6]">
        <span class="text-xs font-semibold text-[#111111]">Dokumen Rapor Performa Resmi SSB Mekar Jaya Subang</span>
        <button onclick="window.print()" class="bg-[#ff5600] hover:bg-[#e04c00] text-white px-4 py-2 rounded-md text-xs font-bold transition-colors">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <!-- Official Header -->
    <div class="border-b-2 border-[#111111] pb-6 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Logo SSB Mekar Jaya" class="w-16 h-16 rounded-full object-cover border border-[#111111]">
            <div>
                <h1 class="text-xl font-extrabold uppercase tracking-wide">SSB MEKAR JAYA SUBANG</h1>
                <p class="text-xs text-gray-600 font-medium">Sekolah Sepak Bola Usia Dini & Akademi Talenta Muda Subang</p>
                <p class="text-[10px] text-gray-500">Sekretariat: Lapangan Veteran Dangdeur Subang | Telp/WA: 0851-3346-3626</p>
            </div>
        </div>
        <div class="text-right">
            <span class="inline-block bg-[#111111] text-white text-xs font-bold px-3 py-1 rounded uppercase tracking-wider">RAPOR PERIODIK</span>
            <span class="block text-[10px] text-gray-500 mt-1">Tanggal Cetak: {{ date('d F Y') }}</span>
        </div>
    </div>

    <!-- Player Profile Info -->
    <div class="grid grid-cols-2 gap-6 bg-[#f5f1ec] p-4 rounded-lg border border-[#d3cec6] mb-6 text-xs">
        <div class="space-y-1.5">
            <div class="flex"><span class="w-32 text-gray-500">Nama Lengkap</span>: <strong class="ml-1 text-gray-900">{{ $player->full_name }}</strong></div>
            <div class="flex"><span class="w-32 text-gray-500">NIS Siswa</span>: <span class="ml-1 font-mono font-bold">{{ $player->nis }}</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Tahun Lahir / KU</span>: <span class="ml-1 font-semibold">{{ $player->birth_year }} ({{ $player->age_category_badge }})</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Ukuran Jersey</span>: <span class="ml-1 font-bold bg-[#111111] text-white px-2 py-0.5 rounded text-[10px]">{{ $player->jersey_size ?? 'M' }}</span></div>
        </div>
        <div class="space-y-1.5">
            <div class="flex"><span class="w-32 text-gray-500">Posisi Bermain</span>: <span class="ml-1 font-semibold">{{ $player->position }}</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Tinggi / Berat</span>: <span class="ml-1">{{ $player->height_cm ?? '-' }} cm / {{ $player->weight_kg ?? '-' }} kg</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Tingkat Kehadiran</span>: <span class="ml-1 font-bold text-[#ff5600]">{{ $attendanceRate }}% Sesi Latihan</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Status SPP</span>: <span class="ml-1 font-bold text-green-700">{{ $player->spp_status }}</span></div>
        </div>
    </div>

    <!-- Performance Evaluation Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Radar Chart Container -->
        <div class="border border-[#d3cec6] p-4 rounded-lg flex flex-col items-center justify-center bg-white">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Diagram Radar Skill Atribut</h3>
            <div class="w-64 h-64">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

        <!-- Scores Table -->
        <div class="border border-[#d3cec6] rounded-lg overflow-hidden flex flex-col justify-between">
            <div class="bg-[#111111] text-white px-4 py-2 text-xs font-bold uppercase tracking-wider">
                Nilai Evaluasi Performa Teknis
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50"><td class="py-2.5 px-4 font-semibold">Passing & Control</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->passing_score ?? 75 }}/100</td></tr>
                    <tr class="hover:bg-gray-50"><td class="py-2.5 px-4 font-semibold">Dribbling & Ball Handling</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->dribbling_score ?? 75 }}/100</td></tr>
                    <tr class="hover:bg-gray-50"><td class="py-2.5 px-4 font-semibold">Shooting & Finishing</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->shooting_score ?? 75 }}/100</td></tr>
                    <tr class="hover:bg-gray-50"><td class="py-2.5 px-4 font-semibold">Physical & Endurance</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->physical_score ?? 75 }}/100</td></tr>
                    <tr class="hover:bg-gray-50"><td class="py-2.5 px-4 font-semibold">Tactical Awareness</td><td class="py-2.5 px-4 text-right font-bold font-mono">{{ $evaluation->tactical_score ?? 70 }}/100</td></tr>
                    <tr class="hover:bg-gray-50"><td class="py-2.5 px-4 font-semibold">Disiplin & Etika Latihan</td><td class="py-2.5 px-4 text-right font-bold font-mono text-[#ff5600]">{{ $evaluation->discipline_score ?? 80 }}/100</td></tr>
                </tbody>
            </table>
            <div class="p-3 bg-[#f5f1ec] text-[11px] border-t border-[#d3cec6]">
                <strong class="block text-gray-700 mb-0.5">Catatan Pelatih Head Coach:</strong>
                <p class="text-gray-600 italic">"{{ $evaluation->coach_notes ?? 'Pemain menunjukkan dedikasi dan semangat latihan yang baik.' }}"</p>
            </div>
        </div>
    </div>

    <!-- Signature Signoff Footer -->
    <div class="mt-12 grid grid-cols-2 text-center text-xs pt-6 border-t border-gray-300">
        <div>
            <p class="text-gray-500 mb-12">Orang Tua / Wali Siswa</p>
            <p class="font-bold border-b border-gray-400 inline-block px-8 pb-1">{{ $player->parent_name }}</p>
        </div>
        <div>
            <p class="text-gray-500 mb-12">Head Coach SSB Mekar Jaya</p>
            <p class="font-bold border-b border-gray-400 inline-block px-8 pb-1">Coach Hendra Wijaya</p>
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
                        backgroundColor: 'rgba(255, 86, 0, 0.25)',
                        borderColor: '#ff5600',
                        borderWidth: 2,
                        pointBackgroundColor: '#111111',
                    }]
                },
                options: {
                    scales: {
                        r: {
                            angleLines: { color: '#d3cec6' },
                            grid: { color: '#ebe7e1' },
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
