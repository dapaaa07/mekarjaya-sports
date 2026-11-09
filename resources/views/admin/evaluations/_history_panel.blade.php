@props(['evaluations', 'evaluationTrend', 'chartId' => 'progressEvaluationChart'])

<div id="evaluation-history" class="space-y-6">
    <!-- Line Chart: Performance Progression Across Time -->
    <div class="editorial-card p-6 border-t-[6px] border-t-[#0000FF] space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b-2 border-[#111111] pb-3.5">
            <div>
                <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-[#0000FF]" aria-hidden="true"></i> Grafik Perkembangan Evaluasi Pemain
                </h3>
                <p class="text-xs text-[#525252] mt-0.5">Tren 6 aspek penilaian teknik, fisik, disiplin, dan taktik antar periode.</p>
            </div>
            <span class="badge-primary font-mono">{{ $evaluations->count() }} Periode Evaluasi</span>
        </div>

        @if($evaluationTrend->count() > 0)
            <div class="h-72 bg-white relative">
                <canvas id="{{ $chartId }}"></canvas>
            </div>
        @else
            <div class="p-8 text-center border-2 border-dashed border-[#111111] bg-[#F4F4F4] text-xs text-[#525252]">
                Belum ada riwayat evaluasi untuk menampilkan grafik perkembangan.
            </div>
        @endif
    </div>

    <!-- Tabular History List (Newest First) -->
    <div class="editorial-card p-6 border-t-[6px] border-t-[#111111] space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b-2 border-[#111111] pb-3.5">
            <div>
                <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-[#CC0000]" aria-hidden="true"></i> Riwayat Evaluasi Pelatih
                </h3>
                <p class="text-xs text-[#525252] mt-0.5">Urutan penilaian terbaru di bagian atas lengkap dengan catatan pelatih.</p>
            </div>
        </div>

        @if($evaluations->count() > 0)
            <div class="overflow-x-auto border-2 border-[#111111]">
                <table class="w-full text-left border-collapse text-xs text-[#111111]">
                    <thead>
                        <tr class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                            <th class="p-3.5">Tanggal</th>
                            <th class="p-3.5 text-center">Passing</th>
                            <th class="p-3.5 text-center">Dribbling</th>
                            <th class="p-3.5 text-center">Shooting</th>
                            <th class="p-3.5 text-center">Fisik</th>
                            <th class="p-3.5 text-center">Disiplin</th>
                            <th class="p-3.5 text-center">Taktik</th>
                            <th class="p-3.5 text-center">Rata-Rata</th>
                            <th class="p-3.5">Catatan Pelatih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#111111] bg-white">
                        @foreach($evaluations as $idx => $ev)
                            @php
                                $avg = round(($ev->passing_score + $ev->dribbling_score + $ev->shooting_score + $ev->physical_score + $ev->discipline_score + $ev->tactical_score) / 6, 1);
                            @endphp
                            <tr class="hover:bg-[#F4F4F4] transition-colors">
                                <td class="p-3.5 font-mono font-bold whitespace-nowrap">
                                    {{ $ev->evaluation_date ? $ev->evaluation_date->format('d M Y') : '-' }}
                                    @if($idx === 0)
                                        <span class="block mt-1"><span class="badge-primary text-[10px] uppercase">Terbaru</span></span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $ev->passing_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $ev->dribbling_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $ev->shooting_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $ev->physical_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold text-[#0000FF]">{{ $ev->discipline_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $ev->tactical_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">
                                    <span class="px-2 py-0.5 bg-[#111111] text-[#FFFF00]">{{ $avg }}</span>
                                </td>
                                <td class="p-3.5 text-[#525252] min-w-[200px]">
                                    {{ $ev->coach_notes ?: '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center border-2 border-dashed border-[#111111] bg-[#F4F4F4] text-xs text-[#525252]">
                Belum ada catatan evaluasi pelatih tersimpan.
            </div>
        @endif
    </div>
</div>

@if($evaluationTrend->count() > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lineCanvas = document.getElementById('{{ $chartId }}');
        if (!lineCanvas) return;

        const labels = @json($evaluationTrend->map(fn ($e) => $e->evaluation_date ? $e->evaluation_date->format('d M y') : '-')->values());
        const datasets = [
            {
                label: 'Passing',
                data: @json($evaluationTrend->pluck('passing_score')->values()),
                borderColor: '#0000FF',
                backgroundColor: '#0000FF',
                borderWidth: 2,
                pointStyle: 'rect',
                pointRadius: 4,
                tension: 0.2,
                fill: false
            },
            {
                label: 'Dribbling',
                data: @json($evaluationTrend->pluck('dribbling_score')->values()),
                borderColor: '#CC0000',
                backgroundColor: '#CC0000',
                borderWidth: 2,
                pointStyle: 'rect',
                pointRadius: 4,
                tension: 0.2,
                fill: false
            },
            {
                label: 'Shooting',
                data: @json($evaluationTrend->pluck('shooting_score')->values()),
                borderColor: '#111111',
                backgroundColor: '#111111',
                borderWidth: 2,
                pointStyle: 'rect',
                pointRadius: 4,
                tension: 0.2,
                fill: false
            },
            {
                label: 'Fisik',
                data: @json($evaluationTrend->pluck('physical_score')->values()),
                borderColor: '#166534',
                backgroundColor: '#166534',
                borderWidth: 2,
                pointStyle: 'rect',
                pointRadius: 4,
                tension: 0.2,
                fill: false
            },
            {
                label: 'Kedisiplinan',
                data: @json($evaluationTrend->pluck('discipline_score')->values()),
                borderColor: '#B45309',
                backgroundColor: '#B45309',
                borderWidth: 2,
                pointStyle: 'rect',
                pointRadius: 4,
                tension: 0.2,
                fill: false
            },
            {
                label: 'Taktik',
                data: @json($evaluationTrend->pluck('tactical_score')->values()),
                borderColor: '#6D28D9',
                backgroundColor: '#6D28D9',
                borderWidth: 2,
                pointStyle: 'rect',
                pointRadius: 4,
                tension: 0.2,
                fill: false
            }
        ];

        new Chart(lineCanvas.getContext('2d'), {
            type: 'line',
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#111111',
                            usePointStyle: true,
                            font: { family: 'Helvetica, Arial, sans-serif', weight: '700', size: 11 }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#111111', font: { family: 'JetBrains Mono, monospace', weight: '700', size: 11 } }
                    },
                    y: {
                        min: 40,
                        max: 100,
                        grid: { color: '#E5E5E5' },
                        ticks: { stepSize: 10, color: '#525252', font: { family: 'JetBrains Mono, monospace', size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endif
