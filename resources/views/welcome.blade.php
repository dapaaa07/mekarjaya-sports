@extends('layouts.app')

@section('title', 'Mekar Jaya Sport Subang - Akademi SSB & Mini Soccer')

@section('content')

<!-- HERO SECTION (Cooking App Design System - Clean White Canvas) -->
<section class="relative bg-white py-16 lg:py-24 border-b border-[#EAEAEA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-50 border border-orange-200 text-[#FF6B00] text-xs font-bold tracking-tight">
                    <span class="w-2 h-2 rounded-full bg-[#FF6B00] animate-pulse"></span>
                    <span>Akademi Sepak Bola & Mini Soccer Subang</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#111111] tracking-tight leading-[1.1]">
                    Mencetak Pesepakbola <span class="text-[#FF6B00]">Berkarakter</span> & Berprestasi
                </h1>

                <p class="text-base sm:text-lg text-[#666666] max-w-2xl leading-relaxed font-normal">
                    Selamat datang di portal resmi <strong>Mekar Jaya Sport Subang</strong>. Pembinaan talenta sepak bola usia dini (SSB Mekar Jaya Academy) & penyedia lapangan <strong>Mekar Jaya Mini Soccer</strong> di Subang.
                </p>

                <!-- Metrics Tiles (16px rounded, white cards with soft shadow) -->
                <div class="pt-2 grid grid-cols-3 gap-4 max-w-lg">
                    <div class="bg-white p-5 text-center rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <span class="block text-3xl sm:text-4xl font-extrabold text-[#FF6B00] font-mono">{{ $totalPlayers }}</span>
                        <span class="text-xs text-[#666666] font-medium uppercase tracking-wider mt-1 block">Siswa Terdaftar</span>
                    </div>
                    <div class="bg-white p-5 text-center rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <span class="block text-3xl sm:text-4xl font-extrabold text-[#111111] font-mono">{{ $yearsCovered }}</span>
                        <span class="text-xs text-[#666666] font-medium uppercase tracking-wider mt-1 block">Tahun Lahir</span>
                    </div>
                    <div class="bg-white p-5 text-center rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <span class="block text-3xl sm:text-4xl font-extrabold text-emerald-600 font-mono">PSSI B/C</span>
                        <span class="text-xs text-[#666666] font-medium uppercase tracking-wider mt-1 block">Lisensi Pelatih</span>
                    </div>
                </div>

                <!-- Call To Action Buttons (12px rounded) -->
                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                    <a href="#roster" class="btn-primary text-center text-sm">
                        <i class="fa-solid fa-calendar-days text-xs mr-2"></i> Cari Pemain Per Tahun Lahir
                    </a>
                    <a href="#pendaftaran" class="btn-secondary text-center text-sm">
                        Form Pendaftaran Siswa
                    </a>
                </div>
            </div>

            <!-- Right Hero Product UI Preview Card (16px rounded, white card with soft shadow) -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="w-full max-w-md bg-white p-7 rounded-2xl border border-gray-100 shadow-lg space-y-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-3.5">
                            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports" class="h-12 w-auto rounded-xl object-contain border border-gray-200">
                            <div>
                                <h3 class="font-bold text-[#111111] text-base leading-tight">MEKARJAYA.SPORTS</h3>
                                <p class="text-xs text-[#666666]">Subang Youth Academy</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-orange-50 text-[#FF6B00] font-bold text-xs border border-orange-200">
                            SUBANG
                        </span>
                    </div>

                    <div class="space-y-3.5 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-bold uppercase tracking-wider text-xs text-[#111111] flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-days text-[#FF6B00]"></i> Sesi Latihan Terdekat
                            </span>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Resmi SSB</span>
                        </div>

                        @if(isset($upcomingSchedules) && $upcomingSchedules->count() > 0)
                            @foreach($upcomingSchedules as $sched)
                                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 space-y-1.5 hover:bg-orange-50/50 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-sm text-[#111111] leading-tight">{{ $sched->title }}</span>
                                        <span class="px-2 py-0.5 rounded-md bg-[#FF6B00] text-white font-mono text-[10px] font-bold">{{ $sched->target_ku }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs text-[#666666]">
                                        <span><i class="fa-solid fa-clock text-[#FF6B00] mr-1"></i> {{ date('d M Y', strtotime($sched->schedule_date)) }} ({{ substr($sched->start_time, 0, 5) }})</span>
                                        <span><i class="fa-solid fa-location-dot mr-1 text-gray-400"></i> Subang</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-center text-xs text-[#666666]">
                                Sesi Latihan Rutin: Selasa & Kamis (15:30 WIB) di Lapangan Veteran Dangdeur Subang.
                            </div>
                        @endif

                        <div class="bg-orange-50/60 p-4 rounded-xl border border-orange-100 text-center space-y-1">
                            <span class="text-xs font-bold text-[#FF6B00] block uppercase tracking-wide">Pencarian Instant Berbasis Tahun Lahir</span>
                            <p class="text-xs text-[#666666]">Memudahkan pengelompokan siswa SSB per angkatan kelahiran (2008 – 2018).</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION 1: ROSTER PEMAIN PER TAHUN LAHIR (Clean White Canvas) -->
<section id="roster" class="relative py-16 lg:py-20 bg-white border-b border-[#EAEAEA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-10">
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-widest block">Fitur Utama Mitra</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#111111] tracking-tight mt-1">
                Daftar & Pencarian Pemain Berdasarkan Tahun Lahir
            </h2>
            <p class="text-[#666666] mt-2 text-sm sm:text-base leading-relaxed">
                Memudahkan pelatih, pengurus, dan orang tua dalam memfilter data siswa SSB Mekar Jaya Subang sesuai angkatan kelahiran dan Kelompok Umur (KU).
            </p>
        </div>

        <!-- Filter Controls Card (16px rounded, white card with soft shadow) -->
        <div class="bg-white p-6 sm:p-8 mb-8 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <form action="{{ route('home') }}#roster" method="GET" class="space-y-4">
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-5">
                        <label for="search" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Cari Nama / NIS Pemain</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                            placeholder="Masukkan nama pemain atau NIS..."
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00] text-sm">
                    </div>

                    <!-- Filter by Birth Year -->
                    <div class="md:col-span-3">
                        <label for="year" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Tahun Lahir</label>
                        <select id="year" name="year" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00] text-sm font-medium">
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
                        <label for="ku" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Kelompok Umur (KU)</label>
                        <select id="ku" name="ku" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00] text-sm font-medium">
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
                        <button type="submit" class="w-full py-3 btn-primary text-sm flex items-center justify-center">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>

                </div>

                <!-- Year Chips Quick Selector -->
                <div class="pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2.5">
                    <span class="text-xs font-bold text-[#666666] uppercase tracking-wider">Filter Cepat:</span>
                    <a href="{{ route('home') }}#roster" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('year') ? 'bg-[#FF6B00] text-white shadow-sm' : 'bg-gray-100 text-[#111111] hover:bg-gray-200' }}">
                        Semua
                    </a>
                    @foreach($availableYears as $yr)
                        <a href="{{ route('home', ['year' => $yr]) }}#roster" 
                           class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('year') == $yr ? 'bg-[#FF6B00] text-white shadow-sm' : 'bg-gray-100 text-[#111111] hover:bg-gray-200' }}">
                            {{ $yr }}
                        </a>
                    @endforeach
                </div>

            </form>
        </div>

        <!-- Active Filter Indicator -->
        @if(request('year') || request('ku') || request('search'))
            <div class="mb-8 flex items-center justify-between bg-orange-50 border border-orange-200 p-4 rounded-xl text-xs">
                <div class="flex items-center gap-2 text-[#FF6B00]">
                    <i class="fa-solid fa-circle-info text-sm"></i>
                    <span>
                        Hasil filter: 
                        @if(request('year')) <strong>Tahun {{ request('year') }}</strong> @endif
                        @if(request('ku')) <strong>KU {{ request('ku') }}</strong> @endif
                        @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
                    </span>
                </div>
                <a href="{{ route('home') }}#roster" class="font-bold text-[#FF6B00] hover:underline">
                    Reset Filter
                </a>
            </div>
        @endif

        <!-- Player Card Grid (16px rounded, white cards with soft shadow) -->
        @if($players->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($players as $player)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
                        
                        <div>
                            <!-- Header / NIS & Position -->
                            <div class="bg-gray-50 px-5 py-3 border-b border-gray-100 flex justify-between items-center text-xs">
                                <span class="font-mono text-xs text-[#666666] font-semibold">{{ $player->nis }}</span>
                                <span class="px-2.5 py-0.5 rounded-full bg-orange-50 text-[#FF6B00] border border-orange-200 font-bold text-[10px] uppercase">
                                    {{ $player->position }}
                                </span>
                            </div>

                            <!-- Body Details -->
                            <div class="p-6 space-y-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-[#111111] text-[#FF6B00] font-extrabold flex items-center justify-center text-lg border border-gray-200 shadow-sm">
                                        {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-[#111111] text-base leading-tight truncate group-hover:text-[#FF6B00] transition-colors" title="{{ $player->full_name }}">
                                            {{ $player->full_name }}
                                        </h3>
                                        <p class="text-xs text-[#666666] mt-0.5">Panggilan: {{ $player->nickname ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 space-y-2 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#666666]">Tahun Lahir:</span>
                                        <span class="px-2 py-0.5 rounded-md bg-[#FF6B00] text-white font-bold font-mono text-xs">
                                            {{ $player->birth_year }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#666666]">Usia Sekarang:</span>
                                        <span class="font-bold text-[#111111]">{{ $player->age }} Tahun</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#666666]">Kelompok Umur:</span>
                                        <span class="font-bold text-[#FF6B00]">{{ $player->age_category_badge }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 py-3.5 bg-gray-50 border-t border-gray-100 text-[11px] text-[#666666] flex justify-between items-center">
                            <span>Subang</span>
                            <span class="font-semibold text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-xs"></i> Terdaftar {{ $player->joined_year }}
                            </span>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $players->links() }}
            </div>
        @else
            <div class="bg-white p-12 text-center rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#111111] text-lg">Tidak Ada Data Pemain Ditemukan</h3>
                <p class="text-[#666666] text-xs mt-2">Coba ubah kriteria pencarian atau pilih tahun lahir yang lain.</p>
                <a href="{{ route('home') }}#roster" class="mt-6 inline-block btn-primary text-xs">Reset Filter</a>
            </div>
        @endif

    </div>
</section>

<!-- SECTION 2: PROGRAM KELOMPOK UMUR (KU) (Clean White Canvas) -->
<section id="program" class="relative py-16 lg:py-20 bg-white border-b border-[#EAEAEA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-widest block">Kurikulum Pembinaan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#111111] tracking-tight mt-1">
                Program Kelompok Umur (KU)
            </h2>
            <p class="text-[#666666] mt-2 text-sm sm:text-base leading-relaxed">
                Kurikulum bertahap sesuai usia anak untuk membangun disiplin, teknik dasar sepak bola, dan mental kompetisi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($ageCategories as $cat)
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="px-3 py-1 rounded-xl bg-[#FF6B00] text-white font-bold text-xs font-mono shadow-sm">
                                {{ $cat->code }}
                            </span>
                            <span class="text-xs font-semibold text-[#666666] bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
                                Lahir {{ $cat->min_birth_year }} - {{ $cat->max_birth_year }}
                            </span>
                        </div>

                        <h3 class="font-bold text-[#111111] text-xl mb-2">{{ $cat->category_name }}</h3>
                        <p class="text-[#666666] text-sm leading-relaxed mb-6">{{ $cat->description }}</p>

                        <div class="space-y-2 border-t border-gray-100 pt-4 text-xs">
                            <div class="flex justify-between">
                                <span class="text-[#666666]">Jadwal Latihan:</span>
                                <span class="font-bold text-[#111111]">{{ $cat->schedule_days }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#666666]">Jam Latihan:</span>
                                <span class="font-bold text-[#111111]">{{ $cat->schedule_time }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-[#666666] block uppercase tracking-wider font-semibold">SPP Bulanan</span>
                            <span class="text-2xl font-extrabold text-[#111111] font-mono">
                                Rp {{ number_format($cat->monthly_fee, 0, ',', '.') }}
                            </span>
                        </div>
                        <a href="#pendaftaran" class="btn-primary text-xs py-2.5 px-5">
                            Daftar {{ $cat->code }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- SECTION 2.5: FOOTBALL MANAGER TACTICAL MATCH PITCH (Clean Card Wrapper) -->
@if(count($upcomingMatches) > 0)
<section id="taktik-match" class="relative py-16 lg:py-20 bg-white border-b border-[#EAEAEA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-10">
            <div>
                <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-widest block">Match Center & Taktik Tim</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#111111] tracking-tight mt-1">
                    Formasi Laga & Starting XI Football Manager
                </h2>
                <p class="text-[#666666] mt-1 text-sm">
                    Pratinjau susunan 11 pemain inti & strategi formasi taktis laga mendatang SSB Mekar Jaya Subang.
                </p>
            </div>
            <a href="{{ route('admin.matches.index') }}" class="btn-primary text-xs py-2.5 px-5 inline-flex items-center gap-1.5">
                <i class="fa-solid fa-shirt"></i> Kelola Formasi Match
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($upcomingMatches as $match)
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div>
                            <span class="bg-[#FF6B00] text-white px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase">{{ $match->match_type }}</span>
                            <span class="text-xs font-bold text-[#666666] ml-2 font-mono">KU: {{ $match->target_ku }}</span>
                            <h3 class="font-bold text-[#111111] text-lg leading-tight mt-1.5">{{ $match->match_title }}</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-[#666666] block font-mono uppercase tracking-wider font-semibold">FORMASI TAKTIK</span>
                            <span class="text-2xl font-mono font-extrabold text-[#FF6B00]">{{ $match->formation ?? '4-3-3' }}</span>
                        </div>
                    </div>

                    <!-- Mini Pitch Display -->
                    <div class="bg-[#081c15] p-6 rounded-2xl border-2 border-[#1b4332] relative overflow-hidden min-h-[350px] flex flex-col justify-between shadow-inner">
                        <!-- Pitch lines mockup -->
                        <div class="absolute inset-2 border border-white/20 rounded pointer-events-none"></div>
                        <div class="absolute top-1/2 left-2 right-2 h-0.5 bg-white/20 -translate-y-1/2 pointer-events-none"></div>
                        <div class="absolute top-1/2 left-1/2 w-24 h-24 border border-white/20 rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

                        <div class="relative z-10 space-y-4">
                            <p class="text-[11px] text-white/70 italic text-center">Formasi Taktik Disusun oleh Pelatih Head Coach SSB Mekar Jaya Subang</p>
                            
                            <!-- Lineup badges grid -->
                            @if(!empty($match->lineup_json))
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                                    @foreach($match->lineup_json as $posKey => $playerName)
                                        @if(!empty($playerName))
                                            <div class="bg-[#111111]/90 border border-[#FF6B00]/40 p-2 rounded-xl flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-[#FF6B00] text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-shirt"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[10px] font-bold text-white truncate">{{ $playerName }}</span>
                                                    <span class="block text-[8px] font-mono text-[#FF6B00] uppercase">{{ strtoupper($posKey) }}</span>
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

                    <div class="flex items-center justify-between text-xs text-[#666666] border-t border-gray-100 pt-4">
                        <span><i class="fa-solid fa-calendar mr-2 text-[#FF6B00]"></i> {{ $match->match_date->format('d M Y') }}</span>
                        @if($match->score_result)
                            <span class="font-mono font-bold text-white bg-[#111111] px-3 py-1 rounded-lg">Skor: {{ $match->score_result }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- SECTION 3: MEKAR JAYA MINI SOCCER (Modern Contrast Section) -->
<section id="mini-soccer" class="relative py-16 lg:py-20 bg-[#111111] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-widest block">Fasilitas Mini Soccer</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mt-1">
                Sewa Lapangan Mekar Jaya Mini Soccer
            </h2>
            <p class="text-gray-400 mt-2 text-sm sm:text-base leading-relaxed">
                Lapangan Mini Soccer sintetis berkualitas di Jl. Arief Rahman Hakim No.18, Cigadung, Subang. Buka setiap hari pukul 06.00 – 00.00 WIB.
            </p>
        </div>

        <!-- Rates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($miniSoccerRates as $rate)
                <div class="bg-[#1C1C1E] p-8 rounded-2xl border border-gray-800 flex flex-col justify-between hover:border-[#FF6B00] transition-colors">
                    <div>
                        <div class="inline-block px-3 py-1 rounded-full bg-[#FF6B00]/10 text-[#FF6B00] text-xs font-bold mb-4 border border-[#FF6B00]/20">
                            {{ $rate->day_type }}
                        </div>
                        <h3 class="font-bold text-white text-base mb-2">{{ $rate->time_slot }}</h3>
                        <div class="mb-6">
                            <span class="text-3xl font-extrabold text-[#FF6B00] font-mono">
                                Rp {{ number_format($rate->price_per_hour, 0, ',', '.') }}
                            </span>
                            <span class="text-sm text-gray-400">/ Jam</span>
                        </div>
                        <p class="text-xs text-gray-300 leading-relaxed border-t border-gray-800 pt-4">
                            <i class="fa-solid fa-check text-emerald-400 mr-1.5"></i> {{ $rate->facilities }}
                        </p>
                    </div>

                    <a href="https://wa.me/6285133463626?text=Halo%20Mekar%20Jaya%20Mini%20Soccer,%20saya%20ingin%20booking%20lapangan%20slot%20{{ urlencode($rate->time_slot) }}" target="_blank"
                       class="mt-8 w-full py-3 btn-primary text-center inline-flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Booking Lapangan
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- SECTION 4: TIM PELATIH (Clean White Canvas) -->
<section id="pelatih" class="relative py-16 lg:py-20 bg-white border-b border-[#EAEAEA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-widest block">Tim Profesional</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#111111] tracking-tight mt-1">
                Staf Pelatih Berlisensi PSSI & AFC
            </h2>
            <p class="text-[#666666] mt-2 text-sm sm:text-base leading-relaxed">
                Pelatih berpengalaman mendampingi tumbuh kembang teknik, kedisiplinan, dan sportivitas para siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($coaches as $coach)
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all text-center">
                    <div class="w-20 h-20 rounded-2xl bg-orange-50 text-[#FF6B00] font-extrabold text-2xl flex items-center justify-center mx-auto mb-6 border border-orange-200">
                        {{ strtoupper(substr($coach->name, 6, 1)) }}
                    </div>
                    <h3 class="font-bold text-[#111111] text-lg">{{ $coach->name }}</h3>
                    <p class="text-xs font-bold text-[#666666] mt-1">{{ $coach->role_title }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-center gap-3 text-xs">
                        <span class="px-3 py-1 rounded-full bg-orange-50 text-[#FF6B00] font-bold border border-orange-200">
                            Lisensi {{ $coach->license }}
                        </span>
                        <span class="text-[#666666]">Pengalaman {{ $coach->experience_years }} Th</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- SECTION 5: FORM PENDAFTARAN SISWA BARU (Clean White Canvas) -->
<section id="pendaftaran" class="relative py-16 lg:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-widest block">Formulir Pendaftaran</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#111111] tracking-tight mt-1">
                Pendaftaran Siswa Baru SSB
            </h2>
            <p class="text-[#666666] text-sm mt-2">Isi formulir di bawah ini untuk mendaftarkan putra Anda di SSB Mekar Jaya Subang.</p>
        </div>

        <!-- Alert Success Notification -->
        @if(session('success'))
            <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 text-[#111111] rounded-2xl flex items-start gap-4 text-sm shadow-sm">
                <i class="fa-solid fa-circle-check text-xl mt-0.5 text-emerald-600"></i>
                <div>
                    <h4 class="font-bold text-emerald-800">Pendaftaran Berhasil!</h4>
                    <p class="mt-1 leading-relaxed text-[#666666]">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white p-8 sm:p-10 rounded-2xl border border-gray-100 shadow-md">
            <form action="{{ route('public.register') }}" method="POST" class="space-y-6">
                @csrf
                
                <h3 class="font-bold text-[#111111] text-base border-b border-gray-100 pb-4 flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#FF6B00] text-white flex items-center justify-center text-xs font-mono font-bold">1</span>
                    Data Calon Siswa
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label for="full_name" class="block font-bold text-[#111111] uppercase mb-1.5">Nama Lengkap Siswa *</label>
                        <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                            placeholder="Contoh: Muhammad Fatih"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>

                    <div>
                        <label for="position_preference" class="block font-bold text-[#111111] uppercase mb-1.5">Posisi Yang Diminati *</label>
                        <select id="position_preference" name="position_preference" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                            <option value="Gelandang">Gelandang (Midfielder)</option>
                            <option value="Striker">Striker (Forward)</option>
                            <option value="Penyerang Sayap">Penyerang Sayap (Winger)</option>
                            <option value="Bek Tengah">Bek Tengah (Center Back)</option>
                            <option value="Bek Sayap">Bek Sayap (Full Back)</option>
                            <option value="Kiper">Kiper (Goalkeeper)</option>
                        </select>
                    </div>

                    <div>
                        <label for="jersey_size" class="block font-bold text-[#111111] uppercase mb-1.5">Ukuran Jersey Tim *</label>
                        <select id="jersey_size" name="jersey_size" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                            <option value="S">S (Ukuran Anak / Kecil)</option>
                            <option value="M" selected>M (Ukuran Sedang)</option>
                            <option value="L">L (Ukuran Besar)</option>
                            <option value="XL">XL (Ukuran Extra Large)</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>

                    <div>
                        <label for="birth_place" class="block font-bold text-[#111111] uppercase mb-1.5">Tempat Lahir *</label>
                        <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place', 'Subang') }}"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>

                    <div>
                        <label for="birth_date" class="block font-bold text-[#111111] uppercase mb-1.5">Tanggal Lahir * (Penentu KU)</label>
                        <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="school_name" class="block font-bold text-[#111111] uppercase mb-1.5">Nama Sekolah Asal</label>
                        <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}"
                            placeholder="Contoh: SDN Dangdeur 1 Subang"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>
                </div>

                <h3 class="font-bold text-[#111111] text-base border-b border-gray-100 pb-4 pt-4 flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#111111] text-white flex items-center justify-center text-xs font-mono font-bold">2</span>
                    Data Orang Tua / Wali
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label for="parent_name" class="block font-bold text-[#111111] uppercase mb-1.5">Nama Orang Tua / Wali *</label>
                        <input type="text" id="parent_name" name="parent_name" required value="{{ old('parent_name') }}"
                            placeholder="Nama Ibu / Bapak"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>

                    <div>
                        <label for="parent_phone" class="block font-bold text-[#111111] uppercase mb-1.5">No. WhatsApp Orang Tua *</label>
                        <input type="tel" id="parent_phone" name="parent_phone" required value="{{ old('parent_phone') }}"
                            placeholder="0851-XXXX-XXXX"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block font-bold text-[#111111] uppercase mb-1.5">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="2" placeholder="Desa / Kecamatan di Subang..."
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">{{ old('address') }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="health_notes" class="block font-bold text-[#111111] uppercase mb-1.5">Catatan Kesehatan (Jika Ada)</label>
                        <input type="text" id="health_notes" name="health_notes" value="{{ old('health_notes') }}"
                            placeholder="Contoh: Tidak ada"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-[#111111] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full btn-primary py-4 font-bold text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Formulir Pendaftaran Online
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

@endsection
