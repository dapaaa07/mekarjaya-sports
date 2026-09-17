@extends('layouts.app')

@section('title', 'Mekar Jaya Sport Subang - Akademi SSB & Mini Soccer')

@section('content')

<!-- HERO SECTION (DESIGN.md Editorial Canvas Style) -->
<section class="relative bg-[#f5f1ec] pt-12 pb-20 border-b border-[#d3cec6]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-[#ebe7e1] border border-[#d3cec6] text-[#111111] text-xs font-medium tracking-tight">
                    <span class="w-2 h-2 rounded-full bg-[#ff5600]"></span>
                    <span>Akademi Sepak Bola & Mini Soccer Subang</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#111111] tracking-tight leading-[1.08]">
                    Mencetak Pesepakbola <span class="text-[#ff5600]">Berkarakter & Berprestasi</span>
                </h1>

                <p class="text-base sm:text-lg text-[#626260] max-w-2xl leading-relaxed font-normal">
                    Selamat datang di portal resmi <strong>Mekar Jaya Sport Subang</strong>. Pembinaan talenta sepak bola usia dini (SSB Mekar Jaya Academy) & penyedia lapangan <strong>Mekar Jaya Mini Soccer</strong> di Subang.
                </p>

                <!-- Honest Metrics Tiles (DESIGN.md Surface-1 Cards) -->
                <div class="pt-2 grid grid-cols-3 gap-3 max-w-lg">
                    <div class="editorial-card p-3.5 text-center">
                        <span class="block text-2xl sm:text-3xl font-bold text-[#111111] font-mono">{{ $totalPlayers }}</span>
                        <span class="text-xs text-[#626260] font-medium">Siswa Terdaftar</span>
                    </div>
                    <div class="editorial-card p-3.5 text-center">
                        <span class="block text-2xl sm:text-3xl font-bold text-[#111111] font-mono">{{ $yearsCovered }}</span>
                        <span class="text-xs text-[#626260] font-medium">Tahun Kelahiran</span>
                    </div>
                    <div class="editorial-card p-3.5 text-center">
                        <span class="block text-2xl sm:text-3xl font-bold text-[#16A34A] font-mono">PSSI B/C</span>
                        <span class="text-xs text-[#626260] font-medium">Lisensi Pelatih</span>
                    </div>
                </div>

                <!-- Call To Action Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <a href="#roster" class="btn-fin text-center text-sm shadow-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-calendar-days text-xs"></i> Cari Pemain Per Tahun Lahir
                    </a>
                    <a href="#pendaftaran" class="btn-secondary text-center text-sm flex items-center justify-center gap-2">
                        Form Pendaftaran Siswa
                    </a>
                </div>
            </div>

            <!-- Right Hero Product UI Preview Card (DESIGN.md Product Mockup Card) -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="w-full max-w-md editorial-card-lg p-6 space-y-4 shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-[#d3cec6]">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports" class="h-10 w-auto rounded-md object-contain border border-[#d3cec6]">
                            <div>
                                <h3 class="font-bold text-[#111111] text-base leading-tight">MEKARJAYA.SPORTS</h3>
                                <p class="text-xs text-[#626260]">Subang Youth Academy</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded bg-[#ebe7e1] text-[#111111] font-semibold text-xs border border-[#d3cec6]">
                            SUBANG
                        </span>
                    </div>

                    <div class="space-y-3 text-xs text-[#111111]">
                        <div class="flex justify-between items-center px-1">
                            <span class="font-bold text-[#111111] uppercase tracking-wider text-[11px]"><i class="fa-solid fa-calendar-days text-[#ff5600] mr-1"></i> Sesi Latihan Terdekat</span>
                            <span class="text-[10px] text-[#16A34A] font-semibold">Resmi SSB</span>
                        </div>

                        @if(isset($upcomingSchedules) && $upcomingSchedules->count() > 0)
                            @foreach($upcomingSchedules as $sched)
                                <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] space-y-1">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-[#111111] text-xs leading-tight">{{ $sched->title }}</span>
                                        <span class="px-2 py-0.5 rounded bg-[#111111] text-white font-mono text-[9px] font-bold">{{ $sched->target_ku }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-[11px] text-[#626260]">
                                        <span><i class="fa-solid fa-clock text-[#ff5600] mr-1"></i> {{ date('d M Y', strtotime($sched->schedule_date)) }} ({{ substr($sched->start_time, 0, 5) }})</span>
                                        <span class="text-[#16A34A] font-semibold"><i class="fa-solid fa-location-dot mr-1"></i> Subang</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#d3cec6] text-center text-[#626260]">
                                Sesi Latihan Rutin: Selasa & Kamis (15:30 WIB) di Lapangan Veteran Dangdeur Subang.
                            </div>
                        @endif

                        <div class="bg-[#ebe7e1] p-3 rounded-md border border-[#d3cec6] text-center space-y-1">
                            <span class="text-xs font-semibold text-[#111111] block">Pencarian Instant Berbasis Tahun Lahir</span>
                            <p class="text-[11px] text-[#626260]">Memudahkan pengelompokan siswa SSB per angkatan kelahiran (2008 – 2018).</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION 1: ROSTER PEMAIN PER TAHUN LAHIR (Core Solution) -->
<section id="roster" class="py-16 bg-[#f5f1ec]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-8">
            <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Fitur Utama Mitra</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Daftar & Pencarian Pemain Berdasarkan Tahun Lahir
            </h2>
            <p class="text-[#626260] mt-2 text-sm sm:text-base">
                Memudahkan pelatih, pengurus, dan orang tua dalam memfilter data siswa SSB Mekar Jaya Subang sesuai angkatan kelahiran dan Kelompok Umur (KU).
            </p>
        </div>

        <!-- Filter Controls Card (DESIGN.md Editorial Card) -->
        <div class="editorial-card p-6 mb-8">
            <form action="{{ route('home') }}#roster" method="GET" class="space-y-4">
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-5">
                        <label for="search" class="block text-xs font-medium text-[#626260] uppercase tracking-wider mb-1.5">
                            Cari Nama / NIS Pemain
                        </label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                            placeholder="Masukkan nama pemain atau NIS..."
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] text-sm">
                    </div>

                    <!-- Filter by Birth Year (Key Feature!) -->
                    <div class="md:col-span-3">
                        <label for="year" class="block text-xs font-medium text-[#626260] uppercase tracking-wider mb-1.5">
                            Tahun Lahir
                        </label>
                        <select id="year" name="year" class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] text-sm font-medium">
                            <option value="">-- Semua Tahun Lahir --</option>
                            @foreach($availableYears as $yr)
                                <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                                    Kelahiran {{ $yr }} (Usia {{ date('Y') - $yr }} th)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Kelompok Umur -->
                    <div class="md:col-span-3">
                        <label for="ku" class="block text-xs font-medium text-[#626260] uppercase tracking-wider mb-1.5">
                            Kelompok Umur (KU)
                        </label>
                        <select id="ku" name="ku" class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] text-sm font-medium">
                            <option value="">-- Semua KU --</option>
                            @foreach($ageCategories as $cat)
                                <option value="{{ $cat->code }}" {{ request('ku') == $cat->code ? 'selected' : '' }}>
                                    {{ $cat->code }} ({{ $cat->min_birth_year }}-{{ $cat->max_birth_year }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="md:col-span-1 flex gap-2">
                        <button type="submit" class="w-full py-2.5 btn-primary text-sm flex items-center justify-center">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>

                </div>

                <!-- Year Chips Quick Selector -->
                <div class="pt-3 border-t border-[#ebe7e1] flex flex-wrap items-center gap-2">
                    <span class="text-xs font-medium text-[#626260]">Filter Cepat Tahun:</span>
                    <a href="{{ route('home') }}#roster" class="px-3 py-1 rounded-md text-xs font-medium transition-colors {{ !request('year') ? 'bg-[#111111] text-white' : 'bg-[#ebe7e1] text-[#111111] hover:bg-[#d3cec6]' }}">
                        Semua
                    </a>
                    @foreach($availableYears as $yr)
                        <a href="{{ route('home', ['year' => $yr]) }}#roster" 
                           class="px-3 py-1 rounded-md text-xs font-medium transition-colors {{ request('year') == $yr ? 'bg-[#ff5600] text-white' : 'bg-[#ebe7e1] text-[#111111] hover:bg-[#d3cec6]' }}">
                            {{ $yr }}
                        </a>
                    @endforeach
                </div>

            </form>
        </div>

        <!-- Active Filter Indicator -->
        @if(request('year') || request('ku') || request('search'))
            <div class="mb-6 flex items-center justify-between bg-[#ebe7e1] border border-[#d3cec6] p-3 rounded-md text-xs text-[#111111]">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-info-circle text-[#ff5600]"></i>
                    <span>Hasil filter: 
                        @if(request('year')) <strong>Tahun {{ request('year') }}</strong> @endif
                        @if(request('ku')) <strong>KU {{ request('ku') }}</strong> @endif
                        @if(request('search')) <strong>Kata Kunci "{{ request('search') }}"</strong> @endif
                    </span>
                </div>
                <a href="{{ route('home') }}#roster" class="font-semibold text-[#ff5600] hover:underline">Reset Filter</a>
            </div>
        @endif

        <!-- Player Card Grid (DESIGN.md Surface-1 Tile) -->
        @if($players->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($players as $player)
                    <div class="editorial-card overflow-hidden hover:border-[#111111] transition-colors flex flex-col justify-between">
                        
                        <div>
                            <!-- Header / NIS & Position -->
                            <div class="bg-[#111111] p-3 text-white flex justify-between items-center text-xs">
                                <span class="font-mono text-[#9c9fa5] text-[11px]">{{ $player->nis }}</span>
                                <span class="px-2 py-0.5 rounded bg-[#ff5600] text-white font-semibold text-[10px] uppercase">
                                    {{ $player->position }}
                                </span>
                            </div>

                            <!-- Body Details -->
                            <div class="p-5 space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-md bg-[#ebe7e1] text-[#111111] font-bold flex items-center justify-center text-base border border-[#d3cec6]">
                                        {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-[#111111] text-base leading-tight truncate" title="{{ $player->full_name }}">
                                            {{ $player->full_name }}
                                        </h3>
                                        <p class="text-xs text-[#626260]">Panggilan: {{ $player->nickname ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="bg-[#f5f1ec] p-3 rounded-md border border-[#ebe7e1] space-y-1.5 text-xs text-[#111111]">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#626260]">Tahun Lahir:</span>
                                        <span class="px-2 py-0.5 rounded bg-[#111111] text-white font-bold font-mono text-xs">
                                            {{ $player->birth_year }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#626260]">Usia Sekarang:</span>
                                        <span class="font-medium text-[#111111]">{{ $player->age }} Tahun</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#626260]">Kelompok Umur:</span>
                                        <span class="font-semibold text-[#16A34A]">{{ $player->age_category_badge }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 py-2.5 bg-[#f5f1ec] border-t border-[#ebe7e1] text-[11px] text-[#626260] flex justify-between items-center">
                            <span>Subang</span>
                            <span class="text-[#16A34A] font-medium"><i class="fa-solid fa-check mr-1"></i> Terdaftar {{ $player->joined_year }}</span>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $players->links() }}
            </div>
        @else
            <div class="editorial-card p-12 text-center">
                <h3 class="font-bold text-[#111111] text-lg">Tidak Ada Data Pemain Ditemukan</h3>
                <p class="text-[#626260] text-xs mt-1">Coba ubah kriteria pencarian atau pilih tahun lahir yang lain.</p>
                <a href="{{ route('home') }}#roster" class="mt-4 inline-block btn-primary text-xs">Reset Filter</a>
            </div>
        @endif

    </div>
</section>


<!-- SECTION 2: PROGRAM KELOMPOK UMUR (KU) -->
<section id="program" class="py-16 bg-[#f5f1ec] border-t border-[#d3cec6]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Kurikulum Pembinaan</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Program Kelompok Umur (KU)
            </h2>
            <p class="text-[#626260] mt-2 text-sm sm:text-base">
                Kurikulum bertahap sesuai usia anak untuk membangun disiplin, teknik dasar sepak bola, dan mental kompetisi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ageCategories as $cat)
                <div class="editorial-card p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="px-3 py-1 rounded bg-[#111111] text-white font-bold text-xs font-mono">
                                {{ $cat->code }}
                            </span>
                            <span class="text-xs font-medium text-[#626260] bg-[#f5f1ec] px-2.5 py-1 rounded border border-[#d3cec6]">
                                Lahir {{ $cat->min_birth_year }} - {{ $cat->max_birth_year }}
                            </span>
                        </div>

                        <h3 class="font-bold text-[#111111] text-lg mb-2">{{ $cat->category_name }}</h3>
                        <p class="text-[#626260] text-xs leading-relaxed mb-6">{{ $cat->description }}</p>

                        <div class="space-y-2 border-t border-[#ebe7e1] pt-4 text-xs">
                            <div class="flex justify-between text-[#626260]">
                                <span>Jadwal Latihan:</span>
                                <span class="font-semibold text-[#111111]">{{ $cat->schedule_days }}</span>
                            </div>
                            <div class="flex justify-between text-[#626260]">
                                <span>Jam Latihan:</span>
                                <span class="font-semibold text-[#111111]">{{ $cat->schedule_time }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-[#ebe7e1] flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-[#626260] block uppercase">SPP Bulanan</span>
                            <span class="text-base font-bold text-[#111111] font-mono">
                                Rp {{ number_format($cat->monthly_fee, 0, ',', '.') }}
                            </span>
                        </div>
                        <a href="#pendaftaran" class="btn-primary text-xs py-1.5 px-3">
                            Daftar {{ $cat->code }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- SECTION 2.5: FOOTBALL MANAGER TACTICAL MATCH PITCH -->
@if(count($upcomingMatches) > 0)
<section id="taktik-match" class="py-16 bg-[#081c15] text-white border-t border-b border-[#1b4332]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Match Center & Taktik Tim</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight mt-1">
                    Formasi Laga & Starting XI Football Manager
                </h2>
                <p class="text-[#9c9fa5] text-xs sm:text-sm mt-1">
                    Pratinjau susunan 11 pemain inti & strategi formasi taktis laga mendatang SSB Mekar Jaya Subang.
                </p>
            </div>
            <a href="{{ route('admin.matches.index') }}" class="btn-fin text-xs py-2 px-4 flex items-center gap-1.5">
                <i class="fa-solid fa-shirt"></i> Kelola Formasi Match
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($upcomingMatches as $match)
                <div class="bg-[#111111] p-6 rounded-2xl border-2 border-[#1b4332] space-y-4 shadow-xl">
                    <div class="flex items-center justify-between border-b border-[#313130] pb-3">
                        <div>
                            <span class="bg-[#ff5600] text-white text-[9px] font-mono px-2 py-0.5 rounded uppercase font-bold">{{ $match->match_type }}</span>
                            <span class="text-xs font-bold text-[#9c9fa5] ml-2 font-mono">KU: {{ $match->target_ku }}</span>
                            <h3 class="font-bold text-white text-base mt-1">{{ $match->match_title }}</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-[#9c9fa5] block font-mono">FORMASI TAKTIK</span>
                            <span class="text-lg font-mono font-bold text-[#ff5600]">{{ $match->formation ?? '4-3-3' }}</span>
                        </div>
                    </div>

                    <!-- Mini Pitch Display -->
                    <div class="bg-[#081c15] p-4 rounded-xl border border-[#1b4332] relative overflow-hidden min-h-[300px] flex flex-col justify-between">
                        <!-- Pitch lines mockup -->
                        <div class="absolute inset-2 border border-white/20 rounded pointer-events-none"></div>
                        <div class="absolute top-1/2 left-2 right-2 h-0.5 bg-white/20 -translate-y-1/2 pointer-events-none"></div>
                        <div class="absolute top-1/2 left-1/2 w-20 h-20 border border-white/20 rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

                        <div class="relative z-10 space-y-3">
                            <p class="text-[10px] text-white/70 italic text-center">Formasi Taktik Disusun oleh Pelatih Head Coach SSB Mekar Jaya Subang</p>
                            
                            <!-- Lineup badges grid -->
                            @if(!empty($match->lineup_json))
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                                    @foreach($match->lineup_json as $posKey => $playerName)
                                        @if(!empty($playerName))
                                            <div class="bg-[#111111]/90 border border-[#ff5600]/40 p-1.5 rounded flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-[#ff5600] text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-shirt"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[10px] font-bold text-white truncate">{{ $playerName }}</span>
                                                    <span class="block text-[8px] font-mono text-[#ff5600] uppercase">{{ strtoupper($posKey) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="py-12 text-center text-xs text-white/60 italic">
                                    Formasi taktik belum dikonfigurasi untuk match ini. Pelatih dapat mengaturnya di Admin Match Center.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-[#9c9fa5] border-t border-[#313130] pt-3">
                        <span><i class="fa-solid fa-calendar mr-1 text-[#ff5600]"></i> {{ $match->match_date->format('d M Y') }}</span>
                        @if($match->score_result)
                            <span class="font-mono font-bold text-white bg-[#313130] px-2 py-0.5 rounded">Skor: {{ $match->score_result }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- SECTION 3: MEKAR JAYA MINI SOCCER (Inverse Canvas Tile) -->
<section id="mini-soccer" class="py-16 bg-[#111111] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Fasilitas Mini Soccer</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight mt-1">
                Sewa Lapangan Mekar Jaya Mini Soccer
            </h2>
            <p class="text-[#9c9fa5] mt-2 text-sm sm:text-base">
                Lapangan Mini Soccer sintetis berkualitas di Jl. Arief Rahman Hakim No.18, Cigadung, Subang. Buka setiap hari pukul 06.00 – 00.00 WIB.
            </p>
        </div>

        <!-- Rates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($miniSoccerRates as $rate)
                <div class="bg-[#1c1c1f] rounded-xl p-6 border border-[#313130] flex flex-col justify-between">
                    <div>
                        <div class="inline-block px-2.5 py-1 rounded bg-[#313130] text-[#ebe7e1] text-xs font-semibold mb-3 border border-[#424240]">
                            {{ $rate->day_type }}
                        </div>
                        <h3 class="font-bold text-white text-base mb-1">{{ $rate->time_slot }}</h3>
                        <div class="my-4">
                            <span class="text-2xl font-bold text-[#ff5600] font-mono">
                                Rp {{ number_format($rate->price_per_hour, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-[#d3cec6]">/ Jam</span>
                        </div>
                        <p class="text-xs text-[#d3cec6] leading-relaxed border-t border-[#313130] pt-3">
                            <i class="fa-solid fa-check text-[#16A34A] mr-1"></i> {{ $rate->facilities }}
                        </p>
                    </div>

                    <a href="https://wa.me/6285133463626?text=Halo%20Mekar%20Jaya%20Mini%20Soccer,%20saya%20ingin%20booking%20lapangan%20slot%20{{ urlencode($rate->time_slot) }}" target="_blank"
                       class="mt-6 w-full py-2.5 bg-[#ff5600] hover:bg-[#e04b00] text-white font-semibold text-xs rounded-md text-center transition-colors block">
                        <i class="fa-brands fa-whatsapp text-sm mr-1"></i> Booking Lapangan
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- SECTION 4: TIM PELATIH -->
<section id="pelatih" class="py-16 bg-[#f5f1ec] border-t border-[#d3cec6]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Tim Profesional</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Staf Pelatih Berlisensi PSSI & AFC
            </h2>
            <p class="text-[#626260] mt-2 text-sm">
                Pelatih berpengalaman mendampingi tumbuh kembang teknik, kedisiplinan, dan sportivitas para siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($coaches as $coach)
                <div class="editorial-card p-6 text-center">
                    <div class="w-20 h-20 rounded-md bg-[#111111] text-white font-bold text-2xl flex items-center justify-center mx-auto mb-4 border border-[#d3cec6]">
                        {{ strtoupper(substr($coach->name, 6, 1)) }}
                    </div>
                    <h3 class="font-bold text-[#111111] text-base">{{ $coach->name }}</h3>
                    <p class="text-xs font-semibold text-[#ff5600] mt-0.5">{{ $coach->role_title }}</p>
                    
                    <div class="mt-4 pt-4 border-t border-[#ebe7e1] flex items-center justify-center gap-2 text-xs">
                        <span class="px-2.5 py-1 rounded bg-[#ebe7e1] text-[#111111] font-medium border border-[#d3cec6]">
                            Lisensi {{ $coach->license }}
                        </span>
                        <span class="text-[#626260]">Pengalaman {{ $coach->experience_years }} Tahun</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- SECTION 5: FORM PENDAFTARAN SISWA BARU -->
<section id="pendaftaran" class="py-16 bg-[#f5f1ec] border-t border-[#d3cec6]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10">
            <span class="text-xs font-semibold text-[#ff5600] uppercase tracking-wider block">Formulir Pendaftaran</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Pendaftaran Siswa Baru SSB
            </h2>
            <p class="text-[#626260] text-sm mt-1">Isi formulir di bawah ini untuk mendaftarkan putra Anda di SSB Mekar Jaya Subang.</p>
        </div>

        <!-- Alert Success Notification -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-[#ebe7e1] border border-[#16A34A] text-[#111111] rounded-md flex items-start gap-3 text-xs">
                <i class="fa-solid fa-circle-check text-[#16A34A] text-base mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-[#111111]">Pendaftaran Berhasil!</h4>
                    <p class="mt-0.5 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="editorial-card p-8">
            <form action="{{ route('public.register') }}" method="POST" class="space-y-6">
                @csrf
                
                <h3 class="font-semibold text-[#111111] text-base border-b border-[#ebe7e1] pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-[#111111] text-white flex items-center justify-center text-xs font-mono">1</span>
                    Data Calon Siswa
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label for="full_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Lengkap Siswa *</label>
                        <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                            placeholder="Contoh: Muhammad Fatih"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>

                    <div>
                        <label for="position_preference" class="block font-medium text-[#626260] uppercase mb-1">Posisi Yang Diminati *</label>
                        <select id="position_preference" name="position_preference" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                            <option value="Gelandang">Gelandang (Midfielder)</option>
                            <option value="Striker">Striker (Forward)</option>
                            <option value="Penyerang Sayap">Penyerang Sayap (Winger)</option>
                            <option value="Bek Tengah">Bek Tengah (Center Back)</option>
                            <option value="Bek Sayap">Bek Sayap (Full Back)</option>
                            <option value="Kiper">Kiper (Goalkeeper)</option>
                        </select>
                    </div>

                    <div>
                        <label for="jersey_size" class="block font-medium text-[#626260] uppercase mb-1">Ukuran Jersey Tim *</label>
                        <select id="jersey_size" name="jersey_size" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                            <option value="S">S (Ukuran Anak / Kecil)</option>
                            <option value="M" selected>M (Ukuran Sedang)</option>
                            <option value="L">L (Ukuran Besar)</option>
                            <option value="XL">XL (Ukuran Extra Large)</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>

                    <div>
                        <label for="birth_place" class="block font-medium text-[#626260] uppercase mb-1">Tempat Lahir *</label>
                        <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place', 'Subang') }}"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>

                    <div>
                        <label for="birth_date" class="block font-medium text-[#626260] uppercase mb-1">Tanggal Lahir * (Penentu KU)</label>
                        <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="school_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Sekolah Asal</label>
                        <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}"
                            placeholder="Contoh: SDN Dangdeur 1 Subang"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>
                </div>

                <h3 class="font-semibold text-[#111111] text-base border-b border-[#ebe7e1] pb-3 pt-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-[#111111] text-white flex items-center justify-center text-xs font-mono">2</span>
                    Data Orang Tua / Wali
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label for="parent_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Orang Tua / Wali *</label>
                        <input type="text" id="parent_name" name="parent_name" required value="{{ old('parent_name') }}"
                            placeholder="Nama Ibu / Bapak"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>

                    <div>
                        <label for="parent_phone" class="block font-medium text-[#626260] uppercase mb-1">No. WhatsApp Orang Tua *</label>
                        <input type="tel" id="parent_phone" name="parent_phone" required value="{{ old('parent_phone') }}"
                            placeholder="0851-XXXX-XXXX"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block font-medium text-[#626260] uppercase mb-1">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="2" placeholder="Desa / Kecamatan di Subang..."
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">{{ old('address') }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="health_notes" class="block font-medium text-[#626260] uppercase mb-1">Catatan Kesehatan (Jika Ada)</label>
                        <input type="text" id="health_notes" name="health_notes" value="{{ old('health_notes') }}"
                            placeholder="Contoh: Tidak ada"
                            class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn-fin py-3 font-semibold text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Formulir Pendaftaran Online
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

@endsection
