@extends('layouts.app')

@section('title', 'Portal Rapor & Kartu Siswa Digital - Mekar Jaya Sport Subang')

@section('content')

<section class="py-16 bg-[#f5f1ec] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Portal Orang Tua & Wali Siswa</span>
            <h1 class="text-3xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Kartu Siswa Digital & Rapor Evaluasi
            </h1>
            <p class="text-[#626260] mt-2 text-sm">
                Masukkan NIS (Nomor Induk Siswa), nama siswa, atau nomor WhatsApp orang tua untuk melihat Kartu Digital & Rapor Performa Perkembangan Anak.
            </p>
        </div>

        <!-- Search Box Form (DESIGN.md Editorial Form Card) -->
        <div class="editorial-card p-6 mb-8">
            <form action="{{ route('parent.portal') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#626260]">
                        <i class="fa-solid fa-search text-xs"></i>
                    </span>
                    <input type="text" name="nis" value="{{ request('nis') }}" required
                           placeholder="Masukkan NIS (contoh: SSB-MJ-1701) / No. WA Orang Tua / Nama Pemain"
                           class="w-full pl-10 pr-4 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] text-sm">
                </div>
                <button type="submit" class="btn-fin text-xs py-2.5 px-6 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-id-card"></i> Cari Kartu Digital
                </button>
            </form>
        </div>

        <!-- Result Card -->
        @if(request()->has('nis'))
            @if($player)
                <div class="space-y-8">
                    
                    <!-- DIGITAL PLAYER CARD (DESIGN.md Surface-1 Editorial Card) -->
                    <div class="bg-[#111111] rounded-xl p-6 sm:p-8 text-white border border-[#313130] shadow-sm relative overflow-hidden">
                        
                        <div class="flex justify-between items-start border-b border-[#313130] pb-4 mb-6">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-10 w-auto rounded-md object-contain border border-[#313130]">
                                <div>
                                    <span class="font-bold text-white text-base block leading-tight">MEKARJAYA.SPORTS SUBANG</span>
                                    <span class="text-[10px] text-[#9c9fa5] font-mono tracking-widest uppercase block">KARTU ANGGOTA SISWA DIGITAL</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-[#313130] text-[#ff5600] rounded text-[10px] font-mono uppercase">
                                RESMI
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                            
                            <!-- Left Photo Badge -->
                            <div class="md:col-span-4 flex flex-col items-center justify-center">
                                <div class="w-24 h-24 rounded-md bg-[#313130] text-white font-bold text-4xl flex items-center justify-center border-2 border-[#ff5600] mb-3">
                                    {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                </div>
                                <span class="px-3 py-1 rounded bg-[#313130] text-[#9c9fa5] text-xs font-mono">
                                    {{ $player->nis }}
                                </span>
                            </div>

                            <!-- Right Details -->
                            <div class="md:col-span-8 space-y-3 text-xs">
                                <div>
                                    <span class="text-[#9c9fa5] uppercase font-medium block text-[10px]">Nama Lengkap Siswa:</span>
                                    <h2 class="font-bold text-white text-xl">{{ $player->full_name }}</h2>
                                </div>

                                <div class="grid grid-cols-2 gap-3 bg-[#18181b] p-3.5 rounded-md border border-[#313130]">
                                    <div>
                                        <span class="text-[#9c9fa5] block text-[10px]">Tahun Kelahiran:</span>
                                        <span class="font-bold text-[#ff5600] text-sm font-mono">{{ $player->birth_year }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[#9c9fa5] block text-[10px]">Kelompok Umur:</span>
                                        <span class="font-bold text-white text-sm">{{ $player->age_category_badge }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[#9c9fa5] block text-[10px]">Posisi Bermain:</span>
                                        <span class="font-semibold text-white text-xs">{{ $player->position }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[#9c9fa5] block text-[10px]">Status SPP Bulanan:</span>
                                        @if($player->spp_status == 'Lunas')
                                            <span class="font-semibold text-[#16A34A] text-xs"><i class="fa-solid fa-check mr-1"></i> Lunas</span>
                                        @else
                                            <span class="font-semibold text-[#c41c1c] text-xs"><i class="fa-solid fa-exclamation-circle mr-1"></i> Belum Bayar</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-6 pt-4 border-t border-[#313130] flex justify-between items-center text-[11px] text-[#9c9fa5]">
                            <span>Lapangan Veteran Dangdeur Subang</span>
                            <span>Sekretariat: 0851-3346-3626</span>
                        </div>

                    </div>


                    <!-- RADAR CHART PERFORMA PERKEMBANGAN (DESIGN.md Report Surface) -->
                    <div class="editorial-card p-6 sm:p-8 space-y-6">
                        <div class="border-b border-[#ebe7e1] pb-4">
                            <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                                <i class="fa-solid fa-chart-pie text-[#ff5600]"></i> Rapor Evaluasi Performa Teknik & Fisik
                            </h3>
                            <p class="text-xs text-[#626260] mt-0.5">Penilaian periodik dari Tim Pelatih SSB Mekar Jaya Subang.</p>
                        </div>

                        <div class="h-72 relative flex items-center justify-center">
                            <canvas id="parentRadarChart"></canvas>
                        </div>

                        @if($player->latestEvaluation && $player->latestEvaluation->coach_notes)
                            <div class="bg-[#f5f1ec] border border-[#d3cec6] p-4 rounded-md text-xs text-[#111111] space-y-1">
                                <span class="font-semibold block text-[#111111] uppercase tracking-wider">Catatan Pelatih:</span>
                                <p class="italic text-[#626260]">"{{ $player->latestEvaluation->coach_notes }}"</p>
                            </div>
                        @endif
                    </div>

                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('parentRadarChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'radar',
                            data: {
                                labels: ['Passing', 'Dribbling', 'Shooting', 'Fisik', 'Kedisiplinan', 'Taktik'],
                                datasets: [{
                                    label: 'Nilai Evaluasi',
                                    data: [
                                        {{ $player->latestEvaluation->passing_score ?? 75 }},
                                        {{ $player->latestEvaluation->dribbling_score ?? 75 }},
                                        {{ $player->latestEvaluation->shooting_score ?? 75 }},
                                        {{ $player->latestEvaluation->physical_score ?? 75 }},
                                        {{ $player->latestEvaluation->discipline_score ?? 80 }},
                                        {{ $player->latestEvaluation->tactical_score ?? 70 }}
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
                                        suggestedMin: 50,
                                        suggestedMax: 100,
                                    }
                                }
                            }
                        });
                    });
                </script>
            @else
                <div class="editorial-card p-12 text-center">
                    <h3 class="font-bold text-[#111111] text-lg">Data Pemain Tidak Ditemukan</h3>
                    <p class="text-[#626260] text-xs mt-1">Pastikan Anda memasukkan NIS, nama pemain, atau nomor WhatsApp orang tua dengan benar.</p>
                </div>
            @endif
        @endif

    </div>
</section>

@endsection
