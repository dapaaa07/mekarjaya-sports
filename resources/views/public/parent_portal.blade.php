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
        <div class="no-print editorial-card p-5 sm:p-6 space-y-4">
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
                    <div id="digital-player-card" class="bg-[#111111] text-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] dark-surface print-card-clean">

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

                                <!-- Left QR Verification + Badge + Copyable NIS (4 Cols) -->
                                <div class="md:col-span-4 flex flex-col items-center justify-center bg-[#181818] border-2 border-[#333333] p-5 space-y-3">
                                    <div class="w-full flex items-center justify-center gap-3">
                                        <div class="w-16 h-16 bg-[#0000FF] text-white font-bold text-2xl flex items-center justify-center border-2 border-[#FFFFFF] font-mono shrink-0">
                                            {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                        </div>
                                        <div class="w-24 h-24 bg-white p-1.5 border-2 border-[#FFFFFF] qr-code-frame shrink-0" aria-label="QR Code Verifikasi Kartu Digital {{ $player->nis }}">
                                            {!! $player->generatePortalQrSvg(96) !!}
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-mono text-[#D4D4D4] text-center uppercase tracking-wider">
                                        Scan QR untuk buka Portal Orang Tua
                                    </p>
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
                                            <span class="text-[#D4D4D4] block text-[11px] font-mono uppercase mb-1">Status SPP Bulan Ini</span>
                                            @if($player->current_spp_status == 'Lunas')
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
                    @php $accEval = $player->accumulated_stats; @endphp
                    <div class="editorial-card p-6 sm:p-8 space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-[#0000FF] text-white border-2 border-[#111111] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-chart-pie text-sm" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2 flex-wrap">
                                        Rapor Evaluasi Performa Teknik &amp; Fisik
                                        @if($accEval->is_accumulated ?? false)
                                            <span class="bg-[#0000FF] text-white text-[10px] font-mono font-bold px-2 py-0.5 border border-[#111111]">
                                                Akumulasi {{ $accEval->matches_count }} Laga
                                            </span>
                                        @endif
                                    </h3>
                                    <p class="text-xs text-[#525252] mt-0.5">
                                        @if($accEval->is_accumulated ?? false)
                                            Akumulasi penilaian performa resmi dari {{ $accEval->matches_count }} pertandingan siswa.
                                        @else
                                            Penilaian evaluasi dasar dari Tim Pelatih SSB Mekar Jaya Subang.
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <span class="badge-primary font-mono self-start sm:self-center">Skala 0 - 100</span>
                        </div>

                        <div class="h-72 sm:h-80 relative flex items-center justify-center bg-[#FFFFFF]">
                            <canvas id="parentRadarChart"></canvas>
                        </div>

                        @if($accEval->coach_notes)
                            <div class="bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] p-4 text-sm text-[#111111] space-y-1">
                                <span class="font-mono font-bold block text-[#111111] uppercase tracking-wider text-xs">Catatan Evaluasi Pelatih</span>
                                <p class="text-[#525252] leading-relaxed">"{{ $accEval->coach_notes }}"</p>
                            </div>
                        @endif
                    </div>

                    <!-- RIWAYAT PERTANDINGAN & STATISTIK PER LAGA -->
                    @php $matchHistory = $player->match_history; @endphp
                    <div id="parent-match-history" class="editorial-card p-6 sm:p-8 space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-[#FF0000] text-white border-2 border-[#111111] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-trophy text-sm" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2 flex-wrap">
                                        Riwayat Pertandingan &amp; Statistik Per Laga
                                        <span class="bg-[#111111] text-[#FFFF00] text-[10px] font-mono font-bold px-2 py-0.5 border border-[#111111]">
                                            {{ $matchHistory->count() }} Laga Dimainkan
                                        </span>
                                    </h3>
                                    <p class="text-xs text-[#525252] mt-0.5">
                                        Daftar seluruh pertandingan resmi dan uji coba yang dimainkan siswa beserta rincian nilai performa di tiap laga.
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($matchHistory->isNotEmpty())
                            @php
                                $evaluatedMatches = $matchHistory->where('has_evaluation', true);
                                $avgAllMatches = $evaluatedMatches->isNotEmpty() ? round($evaluatedMatches->avg('average_score'), 1) : null;
                                $startersCount = $matchHistory->where('role', 'starter')->count();
                                $subsCount = $matchHistory->where('role', 'substitute')->count();
                                $motmCount = $matchHistory->where('is_motm', true)->count();
                            @endphp

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-[#F4F4F4] p-4 border-2 border-[#111111]">
                                <div class="space-y-0.5">
                                    <span class="text-[10px] uppercase font-mono font-bold text-[#525252] block">Total Laga</span>
                                    <span class="text-xl sm:text-2xl font-mono font-bold text-[#111111]">
                                        {{ $matchHistory->count() }} <span class="text-xs font-normal text-[#525252]">Laga</span>
                                    </span>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="text-[10px] uppercase font-mono font-bold text-[#525252] block">Status Skuad</span>
                                    <span class="text-xs sm:text-sm font-mono font-bold text-[#111111] block mt-1">
                                        <span class="text-[#0000FF]">{{ $startersCount }}</span> Starter / <span class="text-[#525252]">{{ $subsCount }}</span> Cadangan
                                    </span>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="text-[10px] uppercase font-mono font-bold text-[#525252] block">Rata-Rata Nilai</span>
                                    <span class="text-xl sm:text-2xl font-mono font-bold text-[#CC0000]">
                                        {{ $avgAllMatches ?? '-' }} <span class="text-xs font-normal text-[#525252]">/ 100</span>
                                    </span>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="text-[10px] uppercase font-mono font-bold text-[#525252] block">Man of the Match</span>
                                    <span class="text-xl sm:text-2xl font-mono font-bold text-[#111111]">
                                        {{ $motmCount }} <span class="text-xs font-normal text-[#525252]">Kali</span>
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-5">
                                @foreach($matchHistory as $mItem)
                                    <div class="border-2 border-[#111111] bg-white shadow-[0_2px_4px_rgba(0,0,0,0.04)]">
                                        <div class="p-4 sm:p-5 border-b-2 border-[#111111] bg-[#FAFAFA] flex flex-col md:flex-row md:items-center justify-between gap-3">
                                            <div class="space-y-1.5">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="font-mono text-xs font-bold text-[#525252]">
                                                        <i class="fa-regular fa-calendar mr-1" aria-hidden="true"></i>
                                                        {{ $mItem->match_date ? $mItem->match_date->format('d M Y') : '-' }}
                                                    </span>
                                                    @if($mItem->match?->match_type)
                                                        <span class="px-2 py-0.5 bg-[#111111] text-white text-[10px] font-mono font-bold uppercase">
                                                            {{ $mItem->match->match_type }}
                                                        </span>
                                                    @endif
                                                    @if($mItem->match?->target_ku)
                                                        <span class="px-2 py-0.5 bg-[#FFFFFF] border border-[#111111] text-[10px] font-mono font-bold">
                                                            {{ $mItem->match->target_ku }}
                                                        </span>
                                                    @endif
                                                    @if($mItem->role === 'starter')
                                                        <span class="badge-blue text-[10px] font-mono uppercase">
                                                            <i class="fa-solid fa-shirt mr-1" aria-hidden="true"></i> Starter
                                                        </span>
                                                    @else
                                                        <span class="badge-secondary text-[10px] font-mono uppercase">
                                                            <i class="fa-solid fa-arrows-rotate mr-1" aria-hidden="true"></i> Cadangan
                                                        </span>
                                                    @endif
                                                    <span class="px-2 py-0.5 bg-white text-[#111111] border border-[#111111] text-[10px] font-mono font-bold">
                                                        Posisi: {{ $mItem->position }}
                                                    </span>
                                                    @if($mItem->is_motm)
                                                        <span class="bg-[#FFFF00] text-[#111111] border border-[#111111] px-2 py-0.5 text-[10px] font-mono font-bold uppercase">
                                                            <i class="fa-solid fa-star text-[#CC0000] mr-1" aria-hidden="true"></i> MOTM
                                                        </span>
                                                    @endif
                                                </div>

                                                <h4 class="font-bold text-base sm:text-lg text-[#111111] tracking-tight">
                                                    {{ $mItem->match?->match_title ?? 'Pertandingan Mekar Jaya' }}
                                                </h4>

                                                @if($mItem->match?->opponent_name)
                                                    <p class="text-xs text-[#525252]">
                                                        Lawan: <strong class="text-[#111111]">{{ $mItem->match->opponent_name }}</strong>
                                                        @if($mItem->match?->formation)
                                                            <span class="mx-1.5">•</span> Formasi Tim: <span class="font-mono font-bold text-[#111111]">{{ $mItem->match->formation }}</span>
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-3 self-start md:self-center shrink-0">
                                                <div class="text-right">
                                                    <span class="block text-[10px] uppercase font-mono font-bold text-[#525252]">Hasil Skor</span>
                                                    <span class="inline-block px-3 py-1 bg-[#111111] text-[#FFFF00] font-mono font-bold text-base sm:text-lg border border-[#111111]">
                                                        {{ $mItem->match?->score_result ?: 'VS' }}
                                                    </span>
                                                </div>
                                                @if($mItem->has_evaluation)
                                                    <div class="text-right pl-3 border-l-2 border-[#111111]">
                                                        <span class="block text-[10px] uppercase font-mono font-bold text-[#525252]">Nilai Laga</span>
                                                        <span class="inline-block px-2.5 py-1 bg-[#0000FF] text-white font-mono font-bold text-base sm:text-lg border border-[#111111]">
                                                            {{ $mItem->average_score }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="p-4 sm:p-5 space-y-4">
                                            @if($mItem->has_evaluation)
                                                <div>
                                                    <span class="text-xs font-mono font-bold text-[#111111] uppercase tracking-wider block mb-3">
                                                        <i class="fa-solid fa-chart-column text-[#0000FF] mr-1" aria-hidden="true"></i> Rincian 6 Parameter Nilai Pertandingan Ini
                                                    </span>

                                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2.5">
                                                        <div class="bg-[#F4F4F4] border-2 border-[#111111] p-2.5 space-y-1">
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="font-bold text-[#111111]">Passing</span>
                                                                <span class="font-mono font-bold text-[#0000FF]">{{ $mItem->passing_score }}</span>
                                                            </div>
                                                            <div class="w-full bg-[#E5E5E5] h-1.5 border border-[#111111]">
                                                                <div class="bg-[#0000FF] h-full" style="width: {{ min(100, max(0, (int) $mItem->passing_score)) }}%;"></div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-[#F4F4F4] border-2 border-[#111111] p-2.5 space-y-1">
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="font-bold text-[#111111]">Dribbling</span>
                                                                <span class="font-mono font-bold text-[#CC0000]">{{ $mItem->dribbling_score }}</span>
                                                            </div>
                                                            <div class="w-full bg-[#E5E5E5] h-1.5 border border-[#111111]">
                                                                <div class="bg-[#CC0000] h-full" style="width: {{ min(100, max(0, (int) $mItem->dribbling_score)) }}%;"></div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-[#F4F4F4] border-2 border-[#111111] p-2.5 space-y-1">
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="font-bold text-[#111111]">Shooting</span>
                                                                <span class="font-mono font-bold text-[#111111]">{{ $mItem->shooting_score }}</span>
                                                            </div>
                                                            <div class="w-full bg-[#E5E5E5] h-1.5 border border-[#111111]">
                                                                <div class="bg-[#111111] h-full" style="width: {{ min(100, max(0, (int) $mItem->shooting_score)) }}%;"></div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-[#F4F4F4] border-2 border-[#111111] p-2.5 space-y-1">
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="font-bold text-[#111111]">Fisik</span>
                                                                <span class="font-mono font-bold text-[#166534]">{{ $mItem->physical_score }}</span>
                                                            </div>
                                                            <div class="w-full bg-[#E5E5E5] h-1.5 border border-[#111111]">
                                                                <div class="bg-[#166534] h-full" style="width: {{ min(100, max(0, (int) $mItem->physical_score)) }}%;"></div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-[#F4F4F4] border-2 border-[#111111] p-2.5 space-y-1">
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="font-bold text-[#111111]">Disiplin</span>
                                                                <span class="font-mono font-bold text-[#B45309]">{{ $mItem->discipline_score }}</span>
                                                            </div>
                                                            <div class="w-full bg-[#E5E5E5] h-1.5 border border-[#111111]">
                                                                <div class="bg-[#B45309] h-full" style="width: {{ min(100, max(0, (int) $mItem->discipline_score)) }}%;"></div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-[#F4F4F4] border-2 border-[#111111] p-2.5 space-y-1">
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="font-bold text-[#111111]">Taktik</span>
                                                                <span class="font-mono font-bold text-[#4B5563]">{{ $mItem->tactical_score }}</span>
                                                            </div>
                                                            <div class="w-full bg-[#E5E5E5] h-1.5 border border-[#111111]">
                                                                <div class="bg-[#4B5563] h-full" style="width: {{ min(100, max(0, (int) $mItem->tactical_score)) }}%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($mItem->coach_notes)
                                                    <div class="bg-[#F9FAFB] border-l-4 border-l-[#0000FF] border border-[#E5E5E5] p-3.5 text-xs text-[#111111] space-y-1">
                                                        <span class="font-mono font-bold uppercase text-[10px] text-[#525252] block">
                                                            <i class="fa-solid fa-comment-dots text-[#0000FF] mr-1" aria-hidden="true"></i> Catatan Evaluasi Pelatih Laga Ini
                                                        </span>
                                                        <p class="text-[#111111] leading-relaxed">"{{ $mItem->coach_notes }}"</p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="p-3.5 bg-[#F4F4F4] border border-[#D4D4D4] text-xs text-[#525252] flex items-center gap-2">
                                                    <i class="fa-solid fa-clock text-[#B45309]" aria-hidden="true"></i>
                                                    <span>Siswa tercatat dalam skuad pertandingan ini. Penilaian statistik individu sedang dalam proses oleh tim pelatih.</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-8 text-center border-2 border-dashed border-[#111111] bg-[#F4F4F4] space-y-2">
                                <div class="w-12 h-12 bg-white border-2 border-[#111111] flex items-center justify-center mx-auto text-[#525252]">
                                    <i class="fa-solid fa-futbol text-lg" aria-hidden="true"></i>
                                </div>
                                <h4 class="font-bold text-[#111111] text-sm">Belum Ada Riwayat Pertandingan</h4>
                                <p class="text-xs text-[#525252] max-w-md mx-auto">
                                    Siswa ini belum tercatat bermain dalam pertandingan resmi atau uji tanding. Nilai statistik per laga akan otomatis muncul setelah pelatih mencatat penilaian pertandingan.
                                </p>
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
                                        {{ $accEval->passing_score ?? 75 }},
                                        {{ $accEval->dribbling_score ?? 75 }},
                                        {{ $accEval->shooting_score ?? 75 }},
                                        {{ $accEval->physical_score ?? 75 }},
                                        {{ $accEval->discipline_score ?? 80 }},
                                        {{ $accEval->tactical_score ?? 70 }}
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
