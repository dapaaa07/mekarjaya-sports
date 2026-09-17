@extends('layouts.admin')

@section('title', 'Detail Pemain - ' . $player->full_name)
@section('page-header', 'Profil & Rapor Performa Pemain')

@section('content')

<div class="space-y-8">

    <!-- Top Profile Banner (DESIGN.md Surface-1 Editorial Tile) -->
    <div class="bg-[#111111] rounded-xl p-6 sm:p-8 text-white border border-[#313130] relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded bg-[#313130] text-white font-bold text-3xl flex items-center justify-center border-2 border-[#ff5600]">
                    {{ strtoupper(substr($player->full_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-bold text-xl text-white">{{ $player->full_name }}</h2>
                        <span class="px-2 py-0.5 rounded bg-[#ff5600] text-white font-semibold text-xs uppercase">
                            {{ $player->position }}
                        </span>
                    </div>
                    <p class="text-xs text-[#9c9fa5] font-mono mt-0.5">NIS: {{ $player->nis }} | Panggilan: {{ $player->nickname ?? '-' }}</p>
                    
                    <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                        <!-- Birth Year Highlight -->
                        <span class="px-2.5 py-1 bg-[#313130] text-white rounded font-mono font-bold">
                            Lahir {{ $player->birth_year }} (Usia {{ $player->age }} Thn)
                        </span>
                        <span class="px-2.5 py-1 bg-[#313130] text-[#9c9fa5] rounded font-medium">
                            KU {{ $player->age_category_badge }}
                        </span>
                        @if($player->spp_status == 'Lunas')
                            <span class="px-2.5 py-1 bg-[#16A34A]/20 text-[#16A34A] border border-[#16A34A]/30 rounded font-semibold">
                                <i class="fa-solid fa-check mr-1"></i> SPP Lunas
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-[#c41c1c]/20 text-[#c41c1c] border border-[#c41c1c]/30 rounded font-semibold">
                                <i class="fa-solid fa-exclamation-circle mr-1"></i> Menunggak SPP
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.players.print-rapor', $player->id) }}" target="_blank" class="bg-[#111111] hover:bg-black border border-[#d3cec6] text-white text-xs py-2 px-3 rounded font-semibold flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-print text-xs"></i> Cetak Rapor
                </a>

                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $player->parent_phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                    $waText = rawurlencode("Halo Bapak/Ibu {$player->parent_name}, kami dari Pengurus SSB Mekar Jaya Subang mengingatkan perihal tagihan SPP bulanan untuk siswa ananda {$player->full_name} (NIS: {$player->nis}). Mohon konfirmasi jika pembayaran telah dilakukan. Terima kasih.");
                @endphp
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" class="bg-[#16A34A] hover:bg-emerald-700 text-white text-xs py-2 px-3 rounded font-semibold flex items-center gap-1.5 transition-colors">
                    <i class="fa-brands fa-whatsapp text-xs"></i> Pengingat SPP WA
                </a>

                <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-fin text-xs py-2 px-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-sliders text-xs"></i> Score Rapor
                </a>
                <a href="{{ route('admin.players.edit', $player->id) }}" class="btn-secondary text-xs py-2 px-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                </a>
            </div>

        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Col: Personal Details & Physical Stats -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="editorial-card p-6 space-y-4">
                <h3 class="font-bold text-[#111111] text-sm border-b border-[#ebe7e1] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-[#ff5600]"></i> Informasi Pribadi & Orang Tua
                </h3>

                <div class="space-y-2.5 text-xs text-[#111111]">
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">Tempat, Tgl Lahir:</span>
                        <span class="font-medium text-[#111111]">{{ $player->birth_place }}, {{ date('d F Y', strtotime($player->birth_date)) }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">Tahun Kelahiran:</span>
                        <span class="font-bold text-[#ff5600] font-mono">{{ $player->birth_year }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">Ukuran Jersey:</span>
                        <span class="font-bold bg-[#111111] text-white px-2 py-0.5 rounded text-[10px]">{{ $player->jersey_size ?? 'M' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">Tinggi / Berat Badan:</span>
                        <span class="font-medium text-[#111111]">{{ $player->height_cm ?? '-' }} cm / {{ $player->weight_kg ?? '-' }} kg</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">Sekolah Asal:</span>
                        <span class="font-medium text-[#111111]">{{ $player->school_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">Nama Orang Tua/Wali:</span>
                        <span class="font-medium text-[#111111]">{{ $player->parent_name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#ebe7e1]">
                        <span class="text-[#626260]">No. WA Orang Tua:</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $player->parent_phone) }}" target="_blank" class="font-semibold text-[#16A34A] hover:underline">
                            <i class="fa-brands fa-whatsapp text-[#16A34A] mr-1"></i> {{ $player->parent_phone }}
                        </a>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-[#626260]">Tahun Bergabung:</span>
                        <span class="font-medium text-[#111111]">{{ $player->joined_year }}</span>
                    </div>
                </div>
            </div>

            <!-- Attendance Summary -->
            <div class="editorial-card p-6 space-y-4">
                <h3 class="font-bold text-[#111111] text-sm border-b border-[#ebe7e1] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-[#16A34A]"></i> Histori Presensi Latihan
                </h3>

                @if($attendances->count() > 0)
                    <div class="space-y-2">
                        @foreach($attendances as $att)
                            <div class="flex justify-between items-center p-2.5 rounded bg-[#f5f1ec] text-xs">
                                <span class="font-medium text-[#111111]">{{ date('d M Y', strtotime($att->date)) }}</span>
                                <span class="px-2 py-0.5 rounded font-semibold uppercase text-[10px] {{ $att->status == 'hadir' ? 'bg-[#16A34A]/20 text-[#16A34A]' : ($att->status == 'izin' ? 'bg-[#ebe7e1] text-[#111111]' : 'bg-[#c41c1c]/20 text-[#c41c1c]') }}">
                                    {{ $att->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-[#626260] py-3 text-center">Belum ada data presensi latihan.</p>
                @endif
            </div>

        </div>

        <!-- Right Col: SPIDER / RADAR CHART RAPOR EVALUASI PERFORMA -->
        <div class="lg:col-span-7 editorial-card p-6 space-y-6">
            
            <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-4">
                <div>
                    <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-[#ff5600]"></i> Diagram Radar Rapor Performa Pemain
                    </h3>
                    <p class="text-xs text-[#626260]">Spesifikasi evaluasi teknik & fisik dari SSB Mekar Jaya.</p>
                </div>
                <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-primary text-xs py-1.5 px-3">
                    Update Nilai
                </a>
            </div>

            <!-- Radar Chart Container -->
            <div class="h-72 relative flex items-center justify-center">
                <canvas id="radarEvaluationChart"></canvas>
            </div>

            <!-- Score breakdown grid -->
            @if($evaluation)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 border-t border-[#ebe7e1] pt-4 text-xs">
                    <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center">
                        <span class="text-[#626260] block text-[11px]">Passing / Operan</span>
                        <span class="text-xl font-bold text-[#111111] font-mono">{{ $evaluation->passing_score }}</span>
                    </div>
                    <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center">
                        <span class="text-[#626260] block text-[11px]">Dribbling / Giring</span>
                        <span class="text-xl font-bold text-[#111111] font-mono">{{ $evaluation->dribbling_score }}</span>
                    </div>
                    <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center">
                        <span class="text-[#626260] block text-[11px]">Shooting / Tendangan</span>
                        <span class="text-xl font-bold text-[#111111] font-mono">{{ $evaluation->shooting_score }}</span>
                    </div>
                    <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center">
                        <span class="text-[#626260] block text-[11px]">Fisik & Ketahanan</span>
                        <span class="text-xl font-bold text-[#111111] font-mono">{{ $evaluation->physical_score }}</span>
                    </div>
                    <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center">
                        <span class="text-[#626260] block text-[11px]">Kedisiplinan</span>
                        <span class="text-xl font-bold text-[#111111] font-mono">{{ $evaluation->discipline_score }}</span>
                    </div>
                    <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center">
                        <span class="text-[#626260] block text-[11px]">Pemahaman Taktik</span>
                        <span class="text-xl font-bold text-[#111111] font-mono">{{ $evaluation->tactical_score }}</span>
                    </div>
                </div>

                @if($evaluation->coach_notes)
                    <div class="bg-[#f5f1ec] border border-[#d3cec6] p-4 rounded-md text-xs text-[#111111] space-y-1">
                        <span class="font-semibold block text-[#111111] uppercase tracking-wider">Catatan Evaluasi Pelatih:</span>
                        <p class="italic text-[#626260]">"{{ $evaluation->coach_notes }}"</p>
                    </div>
                @endif
            @endif

        </div>

    </div>

</div>

<!-- Chart.js Radar Chart Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('radarEvaluationChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Passing', 'Dribbling', 'Shooting', 'Fisik', 'Kedisiplinan', 'Taktik'],
                datasets: [{
                    label: 'Performa {{ $player->nickname ?? $player->full_name }}',
                    data: [
                        {{ $evaluation->passing_score ?? 75 }},
                        {{ $evaluation->dribbling_score ?? 75 }},
                        {{ $evaluation->shooting_score ?? 75 }},
                        {{ $evaluation->physical_score ?? 75 }},
                        {{ $evaluation->discipline_score ?? 80 }},
                        {{ $evaluation->tactical_score ?? 70 }}
                    ],
                    backgroundColor: 'rgba(255, 86, 0, 0.15)',
                    borderColor: '#ff5600',
                    borderWidth: 2,
                    pointBackgroundColor: '#111111',
                    pointBorderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: 'rgba(211, 206, 198, 0.5)' },
                        suggestedMin: 50,
                        suggestedMax: 100,
                        ticks: { stepSize: 10 }
                    }
                }
            }
        });
    });
</script>

@endsection
