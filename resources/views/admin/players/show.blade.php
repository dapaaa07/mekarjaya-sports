@extends('layouts.admin')

@section('title', 'Detail Pemain - ' . $player->full_name)
@section('page-header', 'Profil & Rapor Performa Pemain')

@section('content')

<div class="space-y-8">

    <!-- Top Profile Banner (Cooking App 16px Rounded Banner) -->
    <div class="bg-[#111111] rounded-2xl p-6 sm:p-8 text-white border border-[#222222] shadow-[0_4px_20px_rgba(0,0,0,0.1)] relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-[#1c1c1e] text-white font-bold text-3xl flex items-center justify-center border-2 border-[#FF6B00] shadow-inner">
                    {{ strtoupper(substr($player->full_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-extrabold text-xl text-white">{{ $player->full_name }}</h2>
                        <span class="px-2.5 py-0.5 rounded-lg bg-[#FF6B00] text-white font-bold text-xs uppercase">
                            {{ $player->position }}
                        </span>
                    </div>
                    <p class="text-xs text-[#888888] font-mono mt-0.5">NIS: {{ $player->nis }} | Panggilan: {{ $player->nickname ?? '-' }}</p>
                    
                    <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                        <!-- Birth Year Highlight -->
                        <span class="px-3 py-1 bg-[#222222] text-white rounded-xl font-mono font-bold border border-[#333333]">
                            Lahir {{ $player->birth_year }} (Usia {{ $player->age }} Thn)
                        </span>
                        <span class="px-3 py-1 bg-[#222222] text-[#888888] rounded-xl font-medium border border-[#333333]">
                            KU {{ $player->age_category_badge }}
                        </span>
                        @if($player->spp_status == 'Lunas')
                            <span class="px-3 py-1 bg-[#16A34A]/20 text-[#16A34A] border border-[#16A34A]/30 rounded-xl font-semibold">
                                <i class="fa-solid fa-check mr-1"></i> SPP Lunas
                            </span>
                        @else
                            <span class="px-3 py-1 bg-[#EF4444]/20 text-[#EF4444] border border-[#EF4444]/30 rounded-xl font-semibold">
                                <i class="fa-solid fa-exclamation-circle mr-1"></i> Menunggak SPP
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.players.print-rapor', $player->id) }}" target="_blank" class="bg-[#222222] hover:bg-[#333333] border border-[#333333] text-white text-xs py-2.5 px-3.5 rounded-xl font-medium flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-print text-xs"></i> Cetak Rapor
                </a>

                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $player->parent_phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                    $waText = rawurlencode("Halo Bapak/Ibu {$player->parent_name}, kami dari Pengurus SSB Mekar Jaya Subang mengingatkan perihal tagihan SPP bulanan untuk siswa ananda {$player->full_name} (NIS: {$player->nis}). Mohon konfirmasi jika pembayaran telah dilakukan. Terima kasih.");
                @endphp
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" class="bg-[#16A34A] hover:bg-emerald-700 text-white text-xs py-2.5 px-3.5 rounded-xl font-medium flex items-center gap-1.5 transition-colors shadow-sm">
                    <i class="fa-brands fa-whatsapp text-xs"></i> Pengingat SPP WA
                </a>

                <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-primary text-xs py-2.5 px-3.5 flex items-center gap-1.5 rounded-xl font-medium shadow-sm">
                    <i class="fa-solid fa-sliders text-xs"></i> Score Rapor
                </a>
                <a href="{{ route('admin.players.edit', $player->id) }}" class="btn-secondary text-xs py-2.5 px-3.5 flex items-center gap-1.5 rounded-xl font-medium">
                    <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                </a>
            </div>

        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Col: Personal Details & Physical Stats -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="editorial-card p-6 space-y-4">
                <h3 class="font-extrabold text-[#111111] text-sm border-b border-[#EAEAEA] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-[#FF6B00]"></i> Informasi Pribadi & Orang Tua
                </h3>

                <div class="space-y-3 text-xs text-[#111111]">
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">Tempat, Tgl Lahir:</span>
                        <span class="font-medium text-[#111111]">{{ $player->birth_place }}, {{ date('d F Y', strtotime($player->birth_date)) }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">Tahun Kelahiran:</span>
                        <span class="font-bold text-[#FF6B00] font-mono">{{ $player->birth_year }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">Ukuran Jersey:</span>
                        <span class="font-bold bg-[#111111] text-white px-2 py-0.5 rounded text-[10px]">{{ $player->jersey_size ?? 'M' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">Tinggi / Berat Badan:</span>
                        <span class="font-medium text-[#111111]">{{ $player->height_cm ?? '-' }} cm / {{ $player->weight_kg ?? '-' }} kg</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">Sekolah Asal:</span>
                        <span class="font-medium text-[#111111]">{{ $player->school_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">Nama Orang Tua/Wali:</span>
                        <span class="font-medium text-[#111111]">{{ $player->parent_name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#EAEAEA]">
                        <span class="text-[#666666]">No. WA Orang Tua:</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $player->parent_phone) }}" target="_blank" class="font-semibold text-[#16A34A] hover:underline">
                            <i class="fa-brands fa-whatsapp text-[#16A34A] mr-1"></i> {{ $player->parent_phone }}
                        </a>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-[#666666]">Tahun Bergabung:</span>
                        <span class="font-medium text-[#111111]">{{ $player->joined_year }}</span>
                    </div>
                </div>
            </div>

            <!-- Attendance Summary -->
            <div class="editorial-card p-6 space-y-4">
                <h3 class="font-extrabold text-[#111111] text-sm border-b border-[#EAEAEA] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-[#16A34A]"></i> Histori Presensi Latihan
                </h3>

                @if($attendances->count() > 0)
                    <div class="space-y-2">
                        @foreach($attendances as $att)
                            <div class="flex justify-between items-center p-3 rounded-xl bg-[#FAFAFA] border border-[#EAEAEA] text-xs">
                                <span class="font-medium text-[#111111]">{{ date('d M Y', strtotime($att->date)) }}</span>
                                <span class="px-2.5 py-0.5 rounded-lg font-semibold uppercase text-[10px] {{ $att->status == 'hadir' ? 'bg-[#16A34A]/20 text-[#16A34A]' : ($att->status == 'izin' ? 'bg-[#FAFAFA] text-[#111111] border border-[#EAEAEA]' : 'bg-[#EF4444]/20 text-[#EF4444]') }}">
                                    {{ $att->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-[#666666] py-4 text-center">Belum ada data presensi latihan.</p>
                @endif
            </div>

        </div>

        <!-- Right Col: RADAR CHART RAPOR EVALUASI PERFORMA -->
        <div class="lg:col-span-7 editorial-card p-6 space-y-6">
            
            <div class="flex items-center justify-between border-b border-[#EAEAEA] pb-4">
                <div>
                    <h3 class="font-extrabold text-[#111111] text-base flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-[#FF6B00]"></i> Diagram Radar Rapor Performa Pemain
                    </h3>
                    <p class="text-xs text-[#666666]">Spesifikasi evaluasi teknik & fisik dari SSB Mekar Jaya.</p>
                </div>
                <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-primary text-xs py-2 px-3.5 rounded-xl font-medium shadow-sm">
                    Update Nilai
                </a>
            </div>

            <!-- Radar Chart Container -->
            <div class="h-72 relative flex items-center justify-center">
                <canvas id="radarEvaluationChart"></canvas>
            </div>

            <!-- Score breakdown grid -->
            @if($evaluation)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 border-t border-[#EAEAEA] pt-4 text-xs">
                    <div class="bg-[#FAFAFA] p-3.5 rounded-xl border border-[#EAEAEA] text-center">
                        <span class="text-[#666666] block text-[11px]">Passing / Operan</span>
                        <span class="text-xl font-extrabold text-[#111111] font-mono">{{ $evaluation->passing_score }}</span>
                    </div>
                    <div class="bg-[#FAFAFA] p-3.5 rounded-xl border border-[#EAEAEA] text-center">
                        <span class="text-[#666666] block text-[11px]">Dribbling / Giring</span>
                        <span class="text-xl font-extrabold text-[#111111] font-mono">{{ $evaluation->dribbling_score }}</span>
                    </div>
                    <div class="bg-[#FAFAFA] p-3.5 rounded-xl border border-[#EAEAEA] text-center">
                        <span class="text-[#666666] block text-[11px]">Shooting / Tendangan</span>
                        <span class="text-xl font-extrabold text-[#111111] font-mono">{{ $evaluation->shooting_score }}</span>
                    </div>
                    <div class="bg-[#FAFAFA] p-3.5 rounded-xl border border-[#EAEAEA] text-center">
                        <span class="text-[#666666] block text-[11px]">Fisik & Ketahanan</span>
                        <span class="text-xl font-extrabold text-[#111111] font-mono">{{ $evaluation->physical_score }}</span>
                    </div>
                    <div class="bg-[#FAFAFA] p-3.5 rounded-xl border border-[#EAEAEA] text-center">
                        <span class="text-[#666666] block text-[11px]">Kedisiplinan</span>
                        <span class="text-xl font-extrabold text-[#111111] font-mono">{{ $evaluation->discipline_score }}</span>
                    </div>
                    <div class="bg-[#FAFAFA] p-3.5 rounded-xl border border-[#EAEAEA] text-center">
                        <span class="text-[#666666] block text-[11px]">Pemahaman Taktik</span>
                        <span class="text-xl font-extrabold text-[#111111] font-mono">{{ $evaluation->tactical_score }}</span>
                    </div>
                </div>

                @if($evaluation->coach_notes)
                    <div class="bg-[#FAFAFA] border border-[#EAEAEA] p-4 rounded-xl text-xs text-[#111111] space-y-1">
                        <span class="font-semibold block text-[#111111] uppercase tracking-wider">Catatan Evaluasi Pelatih:</span>
                        <p class="italic text-[#666666]">"{{ $evaluation->coach_notes }}"</p>
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
                    backgroundColor: 'rgba(255, 107, 0, 0.15)',
                    borderColor: '#FF6B00',
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
                        angleLines: { color: 'rgba(234, 234, 234, 0.8)' },
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
