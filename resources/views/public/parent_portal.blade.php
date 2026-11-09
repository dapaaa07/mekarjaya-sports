@extends('layouts.app')

@section('title', 'Portal Rapor & Kartu Siswa Digital - Mekar Jaya Sport Subang')

@section('content')

<section class="py-12 sm:py-16 bg-[#FFFFFF] min-h-[100dvh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-8">

        <!-- Section Header (De Stijl Editorial) -->
        <div class="border-b-2 border-[#111111] pb-6 space-y-2">
            <span class="inline-block bg-[#0000FF] text-white text-xs font-mono font-bold uppercase tracking-wider px-2.5 py-1 border border-[#111111]">
                Portal Orang Tua & Wali Siswa
            </span>
            <h1 class="text-3xl sm:text-4xl font-bold text-[#111111] tracking-tight pt-1">
                Kartu Siswa Digital & Rapor Evaluasi
            </h1>
            <p class="text-[#525252] text-sm sm:text-base max-w-[72ch] leading-relaxed">
                Masukkan NIS (Nomor Induk Siswa), nama siswa, atau nomor WhatsApp orang tua untuk melihat Kartu Digital dan Rapor Performa Perkembangan Anak.
            </p>
        </div>

        <!-- Search Box Form + Contoh Pencarian Cepat -->
        <div class="editorial-card p-5 sm:p-6 space-y-4">
            <form id="parent-search-form" action="{{ route('parent.portal') }}" method="GET" class="space-y-3">
                <label for="parent-nis-input" class="block text-xs font-bold uppercase tracking-wider text-[#111111]">
                    NIS / Nama Lengkap Siswa / No. WhatsApp Orang Tua
                </label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#525252] pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-sm" aria-hidden="true"></i>
                        </span>
                        <input id="parent-nis-input" type="text" name="nis" value="{{ request('nis') }}" required
                               autocorrect="off" autocapitalize="off" spellcheck="false"
                               placeholder="Masukkan NIS (contoh: SSB-MJ-1701) / No. WA / Nama"
                               class="ds-input pl-10">
                    </div>
                    <button type="submit" class="btn-primary text-xs sm:text-sm py-3 px-6 shrink-0">
                        <i class="fa-solid fa-id-card" aria-hidden="true"></i> Cari Kartu Digital
                    </button>
                </div>
            </form>

            <!-- Quick Example Chips (UX Enhancement) -->
            @php
                $samplePlayers = \App\Models\Player::where('status', 'aktif')
                    ->orderByRaw("CASE WHEN nis = 'SSB-MJ-1701' THEN 0 ELSE 1 END")
                    ->orderBy('birth_date', 'desc')
                    ->take(3)
                    ->get(['nis', 'full_name', 'birth_date']);
            @endphp
            @if($samplePlayers->count() > 0)
                <div class="pt-3 border-t border-[#D4D4D4] flex flex-wrap items-center gap-2">
                    <span class="text-xs font-mono font-bold text-[#525252] uppercase">Contoh Pencarian Cepat:</span>
                    @foreach($samplePlayers as $sample)
                        <a href="{{ route('parent.portal', ['nis' => $sample->nis]) }}"
                           class="min-h-[44px] px-3 py-2 bg-[#F4F4F4] hover:bg-[#FFFF00] text-[#111111] border-2 border-[#111111] text-xs font-mono font-bold inline-flex items-center gap-1.5 transition-colors">
                            <i class="fa-solid fa-bolt text-[#CC0000]" aria-hidden="true"></i>
                            <span>{{ $sample->nis }}</span>
                            <span class="font-sans font-normal text-[#525252] hidden sm:inline">({{ $sample->full_name }})</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Result Area -->
        @if(request()->has('nis'))
            @if($player)
                <div class="space-y-8 destijl-enter">

                    <!-- DIGITAL PLAYER CARD (Iconic Mondrian Dark Container) -->
                    <div class="bg-[#111111] text-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] dark-surface print-card-clean">

                        <!-- Top 3-Color Mondrian Ribbon -->
                        <div class="grid grid-cols-12 h-2.5 border-b-2 border-[#FFFFFF]" aria-hidden="true">
                            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
                            <div class="col-span-4 bg-[#FFFF00] border-r-2 border-[#111111]"></div>
                            <div class="col-span-3 bg-[#0000FF]"></div>
                        </div>

                        <div class="p-6 sm:p-8 space-y-6">
                            <!-- Card Header -->
                            <div class="flex flex-wrap justify-between items-start gap-4 border-b-2 border-[#333333] pb-5">
                                <div class="flex items-center gap-3.5">
                                    <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-12 w-12 object-cover border-2 border-[#FFFFFF]">
                                    <div>
                                        <span class="font-bold text-white text-base sm:text-lg block leading-tight">MEKARJAYA.SPORTS SUBANG</span>
                                        <span class="text-xs text-[#FFFF00] font-mono font-bold tracking-widest uppercase block mt-0.5">KARTU ANGGOTA SISWA DIGITAL</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1.5 bg-[#FFFF00] text-[#111111] border border-[#FFFFFF] text-xs font-mono font-bold uppercase">
                                        RESMI
                                    </span>
                                    <button type="button" onclick="window.print()" class="no-print min-h-[44px] px-3.5 py-2 bg-white hover:bg-[#FFFF00] text-[#111111] border-2 border-[#FFFFFF] text-xs font-bold inline-flex items-center gap-1.5 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-print" aria-hidden="true"></i>
                                        <span>Cetak / Unduh</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Main Asymmetric Split -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">

                                <!-- Left Photo Badge & Copyable NIS (4 Cols) -->
                                <div class="md:col-span-4 flex flex-col items-center justify-center bg-[#181818] border-2 border-[#333333] p-5 space-y-3">
                                    <div class="w-24 h-24 bg-[#0000FF] text-white font-bold text-4xl flex items-center justify-center border-2 border-[#FFFFFF] font-mono">
                                        {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                    </div>
                                    <div class="text-center space-y-2 w-full">
                                        <span class="block px-3 py-1.5 bg-[#111111] text-[#FFFF00] text-xs font-mono font-bold border border-[#FFFFFF]">
                                            {{ $player->nis }}
                                        </span>
                                        <button type="button" id="portal-copy-nis-btn" onclick="copyPortalNis('{{ $player->nis }}', this)"
                                                class="no-print w-full min-h-[44px] px-3 py-2 bg-[#222222] hover:bg-[#FFFF00] hover:text-[#111111] text-white border border-[#525252] text-xs font-mono font-bold inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                                            <i class="fa-regular fa-copy" aria-hidden="true"></i>
                                            <span>Salin NIS</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Right Details (8 Cols) -->
                                <div class="md:col-span-8 space-y-4">
                                    <div>
                                        <span class="text-[#D4D4D4] uppercase font-mono font-bold block text-[11px] tracking-wider">Nama Lengkap Siswa</span>
                                        <h2 class="font-bold text-white text-2xl sm:text-3xl tracking-tight mt-0.5">{{ $player->full_name }}</h2>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 bg-[#181818] p-4 border-2 border-[#FFFFFF]">
                                        <div class="border-r border-[#333333] pr-2">
                                            <span class="text-[#D4D4D4] block text-[11px] font-mono uppercase">Tahun Kelahiran</span>
                                            <span class="font-bold text-[#FFFF00] text-lg font-mono">{{ $player->birth_year }}</span>
                                        </div>
                                        <div class="pl-1">
                                            <span class="text-[#D4D4D4] block text-[11px] font-mono uppercase">Kelompok Umur</span>
                                            <span class="font-bold text-white text-base">{{ $player->age_category_badge }}</span>
                                        </div>
                                        <div class="border-r border-t border-[#333333] pt-3 pr-2">
                                            <span class="text-[#D4D4D4] block text-[11px] font-mono uppercase">Posisi Bermain</span>
                                            <span class="font-bold text-white text-sm">{{ $player->position }}</span>
                                        </div>
                                        <div class="border-t border-[#333333] pt-3 pl-1">
                                            <span class="text-[#D4D4D4] block text-[11px] font-mono uppercase mb-1">Status SPP Bulanan</span>
                                            @if($player->spp_status == 'Lunas')
                                                <span class="badge-success text-xs"><i class="fa-solid fa-check mr-1" aria-hidden="true"></i> Lunas</span>
                                            @else
                                                <span class="badge-danger text-xs"><i class="fa-solid fa-circle-exclamation mr-1" aria-hidden="true"></i> Belum Bayar</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Card Footer -->
                            <div class="pt-4 border-t-2 border-[#333333] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-xs text-[#D4D4D4] font-mono">
                                <span>Lapangan Veteran Dangdeur Subang</span>
                                <span>Sekretariat / WA: <strong class="text-[#FFFF00]">0851-3346-3626</strong></span>
                            </div>
                        </div>

                    </div>

                    <!-- RADAR CHART PERFORMA PERKEMBANGAN -->
                    <div class="editorial-card p-6 sm:p-8 space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-[#0000FF] text-white border-2 border-[#111111] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-chart-pie text-sm" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-[#111111] text-base sm:text-lg">
                                        Rapor Evaluasi Performa Teknik & Fisik
                                    </h3>
                                    <p class="text-xs text-[#525252] mt-0.5">Penilaian periodik dari Tim Pelatih SSB Mekar Jaya Subang.</p>
                                </div>
                            </div>
                            <span class="badge-primary font-mono self-start sm:self-center">Skala 0 - 100</span>
                        </div>

                        <div class="h-72 sm:h-80 relative flex items-center justify-center bg-[#FFFFFF]">
                            <canvas id="parentRadarChart"></canvas>
                        </div>

                        @if($player->latestEvaluation && $player->latestEvaluation->coach_notes)
                            <div class="bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] p-4 text-sm text-[#111111] space-y-1">
                                <span class="font-mono font-bold block text-[#111111] uppercase tracking-wider text-xs">Catatan Evaluasi Pelatih</span>
                                <p class="text-[#525252] leading-relaxed">"{{ $player->latestEvaluation->coach_notes }}"</p>
                            </div>
                        @endif
                    </div>

                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    function copyPortalNis(nisText, btn) {
                        const markCopied = () => {
                            const label = btn.querySelector('span');
                            if (!label) return;
                            const orig = label.textContent;
                            label.textContent = 'Tersalin!';
                            btn.setAttribute('aria-label', 'NIS berhasil disalin');
                            setTimeout(() => {
                                label.textContent = orig;
                                btn.removeAttribute('aria-label');
                            }, 1600);
                        };

                        const fallbackCopy = () => {
                            const tmp = document.createElement('input');
                            tmp.value = nisText;
                            document.body.appendChild(tmp);
                            tmp.select();
                            try { document.execCommand('copy'); } catch (err) {}
                            document.body.removeChild(tmp);
                            markCopied();
                        };

                        if (navigator.clipboard && window.isSecureContext) {
                            navigator.clipboard.writeText(nisText).then(markCopied).catch(fallbackCopy);
                        } else {
                            fallbackCopy();
                        }
                    }

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
                                    backgroundColor: 'rgba(0, 0, 255, 0.14)',
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
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    r: {
                                        angleLines: { color: '#D4D4D4' },
                                        grid: { color: '#E5E5E5' },
                                        pointLabels: {
                                            color: '#111111',
                                            font: { family: 'Helvetica, Arial, sans-serif', weight: '700', size: 12 }
                                        },
                                        suggestedMin: 50,
                                        suggestedMax: 100,
                                        ticks: { stepSize: 10, color: '#525252' }
                                    }
                                }
                            }
                        });
                    });
                </script>
            @else
                <!-- Empty State (Sharp De Stijl Bordered Composition) -->
                <div class="editorial-card p-8 sm:p-12 text-center max-w-2xl mx-auto space-y-5 destijl-enter">
                    <div class="w-16 h-16 bg-[#FFFF00] border-2 border-[#111111] text-[#111111] flex items-center justify-center mx-auto">
                        <i class="fa-solid fa-magnifying-glass text-2xl" aria-hidden="true"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-bold text-[#111111] text-xl tracking-tight">Data Pemain Tidak Ditemukan</h3>
                        <p class="text-[#525252] text-sm max-w-md mx-auto leading-relaxed">
                            Sistem tidak menemukan data siswa untuk kata kunci pencarian tersebut. Pastikan Anda memasukkan Nomor Induk Siswa (NIS, contoh: <strong class="text-[#111111] font-mono">SSB-MJ-1701</strong>), nama lengkap siswa, atau nomor WhatsApp orang tua dengan benar.
                        </p>
                    </div>
                    <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('parent.portal') }}" class="btn-secondary text-xs py-2.5 px-5">
                            <i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Reset Pencarian
                        </a>
                        <a href="https://wa.me/6285133463626?text={{ rawurlencode('Halo Admin SSB Mekar Jaya, saya ingin menanyakan NIS anak saya') }}" target="_blank" class="btn-yellow text-xs py-2.5 px-5">
                            <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i> Bantuan WhatsApp
                        </a>
                    </div>
                </div>
            @endif
        @endif

    </div>
</section>

@endsection
