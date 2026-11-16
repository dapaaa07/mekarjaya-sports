@extends('layouts.admin')

@section('title', 'Statistik Pemain - ' . $player->full_name)
@section('page-header', 'Akumulasi Statistik & Penilaian Laga')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Header & Navigation -->
    <div class="editorial-card p-6 border-l-[6px] border-l-[#0000FF] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1 flex-wrap">
                <span class="bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs px-2.5 py-0.5 border border-[#111111]">
                    {{ $player->nis }}
                </span>
                <span class="badge-secondary font-mono">{{ $player->age_category_badge }}</span>
                <span class="bg-[#F4F4F4] text-[#111111] font-mono font-bold text-xs px-2 py-0.5 border border-[#111111]">
                    Posisi: {{ $player->position }}
                </span>
            </div>
            <h2 class="font-bold text-[#111111] text-lg sm:text-xl">{{ $player->full_name }}</h2>
            <p class="text-xs text-[#525252] mt-0.5">
                Statistik performa resmi diakumulasikan otomatis dari seluruh catatan pertandingan.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.matches.index') }}" class="btn-primary text-xs py-2.5 px-4 min-h-[44px]">
                <i class="fa-solid fa-trophy mr-1 text-xs" aria-hidden="true"></i> Nilai di Match Center
            </a>
            @php
                $backUrl = Auth::user()->isAdmin()
                    ? route('admin.players.show', $player->id)
                    : route('admin.evaluations.index');
                $backLabel = Auth::user()->isAdmin() ? 'Ke Profil Pemain' : 'Ke Daftar Evaluasi';
            @endphp
            <a href="{{ $backUrl }}" class="btn-secondary text-xs py-2.5 px-4 min-h-[44px]">
                &larr; {{ $backLabel }}
            </a>
        </div>
    </div>

    <!-- Rule Explanation Banner -->
    <div class="bg-[#FFFF00] border-2 border-[#111111] p-4 text-xs text-[#111111] flex items-start gap-3">
        <i class="fa-solid fa-circle-info text-lg mt-0.5 text-[#111111]" aria-hidden="true"></i>
        <div class="space-y-1">
            <p class="font-bold text-sm">Prinsip Akumulasi Statistik Pemain</p>
            <p class="text-xs text-[#262626] leading-relaxed">
                Pelatih tidak mengubah statistik pemain secara langsung. Setiap nilai performa dihitung otomatis dari rata-rata (akumulasi) penilaian yang diberikan pelatih per pertandingan. Untuk memperbarui atau menambah nilai, lakukan penilaian pada laga terkait di Match Center.
            </p>
        </div>
    </div>

    <!-- Accumulated Stats Radar & Metric Breakdown -->
    <div class="editorial-card p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
            <div>
                <h3 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-[#0000FF]" aria-hidden="true"></i> Diagram Radar Akumulasi Performa
                </h3>
                <p class="text-xs text-[#525252]">Rata-rata 6 aspek statistik dari {{ $accumulated->matches_count ?? 0 }} pertandingan resmi.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs border border-[#111111]">
                    Rata-Rata Total: {{ $accumulated->average_score ?? 75 }}/100
                </span>
                <span class="px-2.5 py-1 bg-[#0000FF] text-white font-mono font-bold text-xs border border-[#111111]">
                    {{ $accumulated->matches_count ?? 0 }} Laga Dinilai
                </span>
            </div>
        </div>

        <div class="h-72 relative flex items-center justify-center bg-white">
            <canvas id="radarEvaluationChart"></canvas>
        </div>

        <!-- 6 Metrics Display (Read-Only Accumulated Values) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 border-t-2 border-[#111111] pt-5 text-xs">
            <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                <span class="text-[#525252] block text-[11px] font-bold uppercase">Passing</span>
                <span class="text-2xl font-bold text-[#111111] font-mono">{{ $accumulated->passing_score }}</span>
            </div>
            <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                <span class="text-[#525252] block text-[11px] font-bold uppercase">Dribbling</span>
                <span class="text-2xl font-bold text-[#111111] font-mono">{{ $accumulated->dribbling_score }}</span>
            </div>
            <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                <span class="text-[#525252] block text-[11px] font-bold uppercase">Shooting</span>
                <span class="text-2xl font-bold text-[#111111] font-mono">{{ $accumulated->shooting_score }}</span>
            </div>
            <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                <span class="text-[#525252] block text-[11px] font-bold uppercase">Fisik</span>
                <span class="text-2xl font-bold text-[#111111] font-mono">{{ $accumulated->physical_score }}</span>
            </div>
            <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                <span class="text-[#525252] block text-[11px] font-bold uppercase">Disiplin</span>
                <span class="text-2xl font-bold text-[#0000FF] font-mono">{{ $accumulated->discipline_score }}</span>
            </div>
            <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                <span class="text-[#525252] block text-[11px] font-bold uppercase">Taktik</span>
                <span class="text-2xl font-bold text-[#111111] font-mono">{{ $accumulated->tactical_score }}</span>
            </div>
        </div>

        @if($accumulated->coach_notes)
            <div class="bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] p-4 text-xs text-[#111111] space-y-1">
                <span class="font-mono font-bold block text-[#111111] uppercase tracking-wider">Catatan Evaluasi Terakhir</span>
                <p class="text-[#525252] text-sm">"{{ $accumulated->coach_notes }}"</p>
            </div>
        @endif
    </div>

    <!-- Per-Match Evaluation History Breakdown Table -->
    <div class="editorial-card p-6 border-t-[6px] border-t-[#111111] space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-3.5">
            <div>
                <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                    <i class="fa-solid fa-futbol text-[#0000FF]" aria-hidden="true"></i> Rincian Nilai Statistik Per Pertandingan
                </h3>
                <p class="text-xs text-[#525252] mt-0.5">Daftar pertandingan yang diikuti {{ $player->full_name }} beserta rincian nilai performanya.</p>
            </div>
            <a href="{{ route('admin.matches.index') }}" class="btn-secondary text-xs py-2 px-3">
                <i class="fa-solid fa-plus text-xs mr-1" aria-hidden="true"></i> Catat Pertandingan Baru
            </a>
        </div>

        @if($matchEvaluations->count() > 0)
            <div class="overflow-x-auto border-2 border-[#111111]">
                <table class="w-full text-left border-collapse text-xs text-[#111111]">
                    <thead>
                        <tr class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                            <th class="p-3.5">Tanggal &amp; Laga</th>
                            <th class="p-3.5">Lawan &amp; Skor</th>
                            <th class="p-3.5 text-center">Pass</th>
                            <th class="p-3.5 text-center">Drib</th>
                            <th class="p-3.5 text-center">Shoot</th>
                            <th class="p-3.5 text-center">Fisik</th>
                            <th class="p-3.5 text-center">Disiplin</th>
                            <th class="p-3.5 text-center">Taktik</th>
                            <th class="p-3.5 text-center">Rata-Rata</th>
                            <th class="p-3.5">Catatan Laga</th>
                            <th class="p-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#111111] bg-white">
                        @foreach($matchEvaluations as $me)
                            <tr class="hover:bg-[#F4F4F4] transition-colors">
                                <td class="p-3.5">
                                    <span class="font-bold font-mono text-[#111111] block">
                                        {{ $me->evaluation_date ? $me->evaluation_date->format('d M Y') : '-' }}
                                    </span>
                                    <span class="font-bold text-xs text-[#111111]">
                                        {{ $me->match?->match_title ?? 'Pertandingan' }}
                                    </span>
                                    @if($me->match)
                                        <span class="bg-[#0000FF] text-white text-[10px] font-mono px-1.5 py-0.2 mt-0.5 inline-block">
                                            {{ $me->match->match_type }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 font-mono text-xs">
                                    <span class="font-bold block text-[#111111]">{{ $me->match?->opponent_name ?? '-' }}</span>
                                    <span class="bg-[#111111] text-[#FFFF00] font-bold px-1.5 py-0.5 mt-0.5 inline-block">
                                        {{ $me->match?->score_result ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $me->passing_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $me->dribbling_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $me->shooting_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $me->physical_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold text-[#0000FF]">{{ $me->discipline_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">{{ $me->tactical_score }}</td>
                                <td class="p-3.5 text-center font-mono font-bold">
                                    <span class="px-2 py-0.5 bg-[#FFFF00] text-[#111111] border border-[#111111]">
                                        {{ $me->average_score }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-[#525252] text-[11px] max-w-xs">
                                    {{ $me->coach_notes ?? '-' }}
                                </td>
                                <td class="p-3.5 text-right whitespace-nowrap">
                                    @if($me->match_id)
                                        <a href="{{ route('admin.matches.evaluations', $me->match_id) }}"
                                           class="btn-primary text-[11px] py-1.5 px-3 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-pen text-[10px]" aria-hidden="true"></i> Edit di Laga
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center border-2 border-dashed border-[#111111] bg-[#F4F4F4] text-xs text-[#525252] space-y-3">
                <i class="fa-solid fa-futbol text-2xl text-[#111111]" aria-hidden="true"></i>
                <p class="font-bold text-sm text-[#111111]">Belum Ada Catatan Nilai Pertandingan</p>
                <p class="max-w-md mx-auto text-[#525252]">
                    Pemain ini belum dimasukkan atau dinilai dalam catatan pertandingan Match Center. Daftarkan pemain ke Starting XI atau Cadangan lalu berikan penilaian setelah laga.
                </p>
                <a href="{{ route('admin.matches.index') }}" class="btn-primary text-xs py-2 px-4 inline-flex items-center gap-1.5 mt-2">
                    <i class="fa-solid fa-trophy text-xs" aria-hidden="true"></i> Buka Match Center
                </a>
            </div>
        @endif
    </div>

    <!-- Trend Chart Panel -->
    @include('admin.evaluations._history_panel', [
        'evaluations' => $evaluations,
        'evaluationTrend' => $evaluationTrend,
        'chartId' => 'progressEvaluationChart',
    ])

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('radarEvaluationChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Passing', 'Dribbling', 'Shooting', 'Fisik & Stamina', 'Kedisiplinan', 'Taktik'],
                datasets: [{
                    label: 'Skor Akumulasi (0-100)',
                    data: [
                        {{ $accumulated->passing_score ?? 75 }},
                        {{ $accumulated->dribbling_score ?? 75 }},
                        {{ $accumulated->shooting_score ?? 75 }},
                        {{ $accumulated->physical_score ?? 75 }},
                        {{ $accumulated->discipline_score ?? 80 }},
                        {{ $accumulated->tactical_score ?? 70 }}
                    ],
                    backgroundColor: 'rgba(0, 0, 255, 0.15)',
                    borderColor: '#0000FF',
                    borderWidth: 2,
                    pointBackgroundColor: '#FF0000',
                    pointBorderColor: '#111111',
                    pointBorderWidth: 1.5,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        min: 0,
                        max: 100,
                        ticks: { stepSize: 20, font: { family: 'monospace', size: 10 } },
                        grid: { color: '#E5E5E5' },
                        angleLines: { color: '#E5E5E5' },
                        pointLabels: { font: { size: 11, weight: 'bold' }, color: '#111111' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
