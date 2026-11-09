@extends('layouts.app')

@section('title', 'Mekar Jaya Sport Subang - Akademi SSB & Mini Soccer')

@section('content')

@php
    $kuJson = $ageCategories->map(fn($c) => [
        'code' => $c->code,
        'name' => $c->category_name,
        'min_year' => (int) $c->min_birth_year,
        'max_year' => (int) $c->max_birth_year,
    ])->values();
@endphp

<!-- HERO SECTION (De Stijl Abstrato Asymmetric Mondrian Composition) -->
<section class="relative bg-[#FFFFFF] py-12 sm:py-16 lg:py-20 border-b-2 border-[#111111]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">

            <!-- Left Hero Column (7 cols) -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6 text-left destijl-enter">
                <div class="space-y-5">
                    <div class="inline-flex items-center border-2 border-[#111111] bg-[#FFFF00] text-[#111111] px-3 py-1 font-mono text-xs font-bold uppercase tracking-wider">
                        Akademi Sepak Bola & Mini Soccer Subang
                    </div>

                    <h1 class="text-[clamp(2.35rem,5vw,3.85rem)] font-bold text-[#111111] tracking-tight leading-[1.06]">
                        Mencetak Pesepakbola <span class="inline-block bg-[#FF0000] text-[#000000] px-2.5 border-2 border-[#111111]">Berkarakter</span> & Berprestasi
                    </h1>

                    <p class="text-base sm:text-lg text-[#525252] max-w-[65ch] leading-relaxed font-normal">
                        Portal resmi <strong class="text-[#111111]">Mekar Jaya Sport Subang</strong>. Pembinaan talenta sepak bola usia dini melalui SSB Mekar Jaya Academy dan pengelolaan lapangan rumput sintetis <strong class="text-[#111111]">Mekar Jaya Mini Soccer</strong> di Subang.
                    </p>
                </div>

                <!-- Asymmetric Mondrian KPI Grid (5 / 3 / 4 split - NO 3 equal columns) -->
                <div class="grid grid-cols-12 border-2 border-[#111111] bg-[#111111] gap-[2px] max-w-xl">
                    <div class="col-span-6 sm:col-span-5 bg-[#FFFF00] text-[#111111] p-4 sm:p-5">
                        <span class="block text-3xl sm:text-4xl font-bold font-mono leading-none">{{ $totalPlayers }}</span>
                        <span class="text-xs text-[#111111] font-bold uppercase tracking-wider mt-2 block">Siswa Terdaftar</span>
                    </div>
                    <div class="col-span-6 sm:col-span-3 bg-[#FFFFFF] text-[#111111] p-4 sm:p-5">
                        <span class="block text-3xl sm:text-4xl font-bold font-mono leading-none">{{ $yearsCovered }}</span>
                        <span class="text-xs text-[#525252] font-bold uppercase tracking-wider mt-2 block">Tahun Lahir</span>
                    </div>
                    <div class="col-span-12 sm:col-span-4 bg-[#0000FF] text-[#FFFFFF] p-4 sm:p-5">
                        <span class="block text-2xl sm:text-3xl font-bold font-mono leading-none">PSSI B/C</span>
                        <span class="text-xs text-[#FFFFFF] font-bold uppercase tracking-wider mt-2 block">Lisensi Pelatih</span>
                    </div>
                </div>

                <!-- Primary & Secondary CTAs -->
                <div class="pt-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5">
                    <a href="#roster" class="btn-primary text-sm">
                        <i class="fa-solid fa-calendar-days text-xs" aria-hidden="true"></i> Cari Pemain Per Tahun Lahir
                    </a>
                    <a href="#pendaftaran" class="btn-secondary text-sm">
                        Form Pendaftaran Siswa
                    </a>
                </div>
            </div>

            <!-- Right Hero Mondrian Live Schedule Block (5 cols) -->
            <div class="lg:col-span-5 flex flex-col destijl-enter destijl-enter-delay-1">
                <div class="w-full flex-grow bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex flex-col justify-between">
                    <!-- Asymmetric Dual Header Strip -->
                    <div>
                        <div class="grid grid-cols-12 border-b-2 border-[#111111]">
                            <div class="col-span-8 bg-[#0000FF] text-white p-4 sm:p-5 flex items-center gap-3 border-r-2 border-[#111111]">
                                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports" class="h-11 w-11 object-cover border-2 border-[#FFFFFF] shrink-0">
                                <div class="min-w-0">
                                    <h3 class="font-bold text-white text-sm sm:text-base leading-tight truncate">MEKARJAYA.SPORTS</h3>
                                    <p class="text-xs text-white/90 font-mono">Subang Youth Academy</p>
                                </div>
                            </div>
                            <div class="col-span-4 bg-[#FFFF00] text-[#111111] p-4 flex flex-col items-center justify-center text-center">
                                <span class="font-mono font-bold text-xs uppercase tracking-wider">SUBANG</span>
                                <span class="text-[11px] font-bold mt-0.5">RESMI SSB</span>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 space-y-4">
                            <div class="flex justify-between items-center border-b-2 border-[#111111] pb-3">
                                <span class="font-bold uppercase tracking-wider text-xs text-[#111111] flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-days text-[#0000FF]" aria-hidden="true"></i> Sesi Latihan Terdekat
                                </span>
                                <span class="text-xs font-mono font-bold bg-[#111111] text-white px-2.5 py-0.5">JADWAL</span>
                            </div>

                            @if(isset($upcomingSchedules) && $upcomingSchedules->count() > 0)
                                <div class="space-y-3">
                                    @foreach($upcomingSchedules as $sched)
                                        <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] space-y-1.5 hover:bg-[#FFFF00]/25 transition-colors">
                                            <div class="flex justify-between items-start gap-2">
                                                <span class="font-bold text-sm text-[#111111] leading-snug">{{ $sched->title }}</span>
                                                <span class="px-2 py-0.5 bg-[#FF0000] text-[#000000] border border-[#111111] font-mono text-[11px] font-bold shrink-0">{{ $sched->target_ku }}</span>
                                            </div>
                                            <div class="flex justify-between items-center text-xs text-[#525252] font-mono">
                                                <span><i class="fa-solid fa-clock text-[#111111] mr-1" aria-hidden="true"></i> {{ date('d M Y', strtotime($sched->schedule_date)) }} ({{ substr($sched->start_time, 0, 5) }})</span>
                                                <span><i class="fa-solid fa-location-dot mr-1 text-[#0000FF]" aria-hidden="true"></i> Subang</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-[#F4F4F4] p-4 border-2 border-[#111111] text-xs text-[#111111] leading-relaxed">
                                    Sesi Latihan Rutin: Selasa & Kamis (15:30 WIB) dan Minggu Pagi di Lapangan Veteran Dangdeur Subang.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Portal Access Strip -->
                    <a href="{{ route('parent.portal') }}" class="border-t-2 border-[#111111] bg-[#111111] text-white hover:bg-[#0000FF] p-4 flex items-center justify-between text-xs font-bold uppercase tracking-wider transition-colors">
                        <span><i class="fa-solid fa-id-card mr-2 text-[#FFFF00]" aria-hidden="true"></i> Cek Kartu Siswa Digital & Rapor</span>
                        <i class="fa-solid fa-arrow-right text-sm" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION 1: ROSTER PEMAIN PER TAHUN LAHIR -->
<section id="roster" class="relative py-14 sm:py-16 lg:py-20 bg-[#FFFFFF] border-b-2 border-[#111111]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 border-b-2 border-[#111111] pb-6 mb-8">
            <div class="max-w-3xl">
                <span class="text-xs font-mono font-bold text-[#0000FF] uppercase tracking-wider block">Direktori Anggota Resmi</span>
                <h2 class="text-2xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                    Direktori & Data Siswa SSB Mekar Jaya
                </h2>
                <p class="text-[#525252] mt-2 text-sm sm:text-base max-w-[72ch] leading-relaxed">
                    Informasi seluruh siswa aktif Akademi Sepak Bola Mekar Jaya Subang. Saring data berdasarkan nama, Nomor Induk Siswa (NIS), tahun kelahiran, atau Kelompok Umur (KU).
                </p>
            </div>

            <div class="border-2 border-[#111111] bg-[#111111] text-white px-4 py-3 font-mono text-xs shrink-0 self-start lg:self-end">
                <span class="text-[#D4D4D4] block text-[11px] uppercase">Menampilkan Data</span>
                <span class="text-lg font-bold text-[#FFFF00]">{{ $players->total() }} Siswa Aktif</span>
            </div>
        </div>

        <!-- Filter Controls Matrix -->
        <div class="bg-[#FFFFFF] p-5 sm:p-6 mb-8 border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] space-y-5">
            <form action="{{ route('home') }}#roster" method="GET" class="space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                    <!-- Search Input -->
                    <div class="md:col-span-5">
                        <label for="search" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Cari Nama / NIS Pemain</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Contoh: Fatih atau SSB-MJ-1701..."
                               autocorrect="off" autocapitalize="off" spellcheck="false"
                               class="ds-input">
                    </div>

                    <!-- Filter by Birth Year -->
                    <div class="md:col-span-3">
                        <label for="year" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Tahun Lahir</label>
                        <select id="year" name="year" class="ds-input font-medium">
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
                        <select id="ku" name="ku" class="ds-input font-medium">
                            <option value="">-- Semua KU --</option>
                            @foreach($ageCategories as $cat)
                                <option value="{{ $cat->code }}" {{ request('ku') == $cat->code ? 'selected' : '' }}>
                                    {{ $cat->code }} ({{ $cat->min_birth_year }}-{{ $cat->max_birth_year }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="md:col-span-1">
                        <button type="submit" aria-label="Terapkan filter roster" class="w-full min-h-[46px] btn-primary px-3 text-sm">
                            <i class="fa-solid fa-filter" aria-hidden="true"></i>
                            <span class="md:hidden">Saring</span>
                        </button>
                    </div>

                </div>

                <!-- Dual Quick Selector Rows: Tahun Lahir & KU Pills -->
                <div class="pt-4 border-t-2 border-[#111111] space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-mono font-bold text-[#525252] uppercase tracking-wider mr-1">Tahun Lahir:</span>
                        <a href="{{ route('home') }}#roster"
                           class="min-h-[44px] px-3.5 py-2 border-2 border-[#111111] font-mono text-xs font-bold inline-flex items-center transition-colors {{ !request('year') && !request('ku') ? 'bg-[#FF0000] text-[#000000]' : 'bg-white text-[#111111] hover:bg-[#FFFF00]' }}">
                            Semua
                        </a>
                        @foreach($availableYears as $yr)
                            <a href="{{ route('home', ['year' => $yr]) }}#roster"
                               class="min-h-[44px] px-3.5 py-2 border-2 border-[#111111] font-mono text-xs font-bold inline-flex items-center transition-colors {{ request('year') == $yr ? 'bg-[#FF0000] text-[#000000]' : 'bg-white text-[#111111] hover:bg-[#FFFF00]' }}">
                                {{ $yr }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-mono font-bold text-[#525252] uppercase tracking-wider mr-1">Kelompok Umur:</span>
                        <a href="{{ route('home') }}#roster"
                           class="min-h-[44px] px-3.5 py-2 border-2 border-[#111111] font-mono text-xs font-bold inline-flex items-center transition-colors {{ !request('ku') ? 'bg-[#0000FF] text-[#FFFFFF]' : 'bg-white text-[#111111] hover:bg-[#FFFF00]' }}">
                            Semua KU
                        </a>
                        @foreach($ageCategories as $cat)
                            <a href="{{ route('home', ['ku' => $cat->code]) }}#roster"
                               class="min-h-[44px] px-3.5 py-2 border-2 border-[#111111] font-mono text-xs font-bold inline-flex items-center transition-colors {{ request('ku') == $cat->code ? 'bg-[#0000FF] text-[#FFFFFF]' : 'bg-white text-[#111111] hover:bg-[#FFFF00]' }}">
                                {{ $cat->code }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </form>
        </div>

        <!-- Active Filter Indicator -->
        @if(request('year') || request('ku') || request('search'))
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] p-4 text-xs sm:text-sm">
                <div class="flex items-center gap-2 text-[#111111]">
                    <i class="fa-solid fa-circle-info text-[#0000FF] text-base" aria-hidden="true"></i>
                    <span>
                        Filter aktif:
                        @if(request('year')) <strong class="font-mono">Tahun {{ request('year') }}</strong> @endif
                        @if(request('ku')) <strong class="font-mono">KU {{ request('ku') }}</strong> @endif
                        @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
                    </span>
                </div>
                <a href="{{ route('home') }}#roster" class="min-h-[44px] px-4 py-2 bg-white border-2 border-[#111111] hover:bg-[#FFFF00] font-bold text-[#111111] text-xs inline-flex items-center justify-center self-start sm:self-auto">
                    Reset Filter
                </a>
            </div>
        @endif

        <!-- Player Card Grid -->
        @if($players->count() > 0)
            <div id="roster-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($players as $player)
                    <div class="bg-[#FFFFFF] border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex flex-col justify-between group">

                        <div>
                            <!-- Header: NIS + Copy Button & Position -->
                            <div class="bg-[#F4F4F4] px-4 py-2.5 border-b-2 border-[#111111] flex justify-between items-center gap-2 text-xs">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="font-mono text-xs text-[#111111] font-bold truncate">{{ $player->nis }}</span>
                                    <button type="button"
                                            onclick="copyPlayerNis('{{ $player->nis }}', this)"
                                            aria-label="Salin NIS {{ $player->nis }}"
                                            title="Salin NIS {{ $player->nis }}"
                                            class="px-2 py-2 min-w-[44px] min-h-[44px] border border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] text-[10px] font-mono font-bold inline-flex items-center justify-center gap-1 cursor-pointer transition-colors shrink-0">
                                        <i class="fa-regular fa-copy" aria-hidden="true"></i>
                                        <span class="copy-label sr-only">Salin</span>
                                    </button>
                                </div>
                                <span class="px-2 py-0.5 bg-[#0000FF] text-white border border-[#111111] font-mono font-bold text-[10px] uppercase shrink-0">
                                    {{ $player->position }}
                                </span>
                            </div>

                            <!-- Body Details -->
                            <div class="p-5 space-y-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 shrink-0 bg-[#111111] text-[#FFFF00] font-mono font-bold flex items-center justify-center text-lg border-2 border-[#111111]">
                                        {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-[#111111] text-base leading-tight truncate" title="{{ $player->full_name }}">
                                            {{ $player->full_name }}
                                        </h3>
                                        <p class="text-xs text-[#525252] mt-0.5">Panggilan: {{ $player->nickname ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="bg-[#F4F4F4] p-3 border-2 border-[#111111] space-y-2 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#525252]">Tahun Lahir:</span>
                                        <span class="px-2 py-0.5 bg-[#FFFF00] text-[#111111] border border-[#111111] font-bold font-mono text-xs">
                                            {{ $player->birth_year }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#525252]">Usia Sekarang:</span>
                                        <span class="font-bold text-[#111111]">{{ $player->age }} Tahun</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#525252]">Kelompok Umur:</span>
                                        <span class="font-bold font-mono text-[#0000FF]">{{ $player->age_category_badge }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer: Joined Year + Direct Digital Card Shortcut -->
                        <div class="px-4 py-2.5 bg-[#FFFFFF] border-t-2 border-[#111111] text-xs flex justify-between items-center gap-2">
                            <span class="font-semibold text-[#166534] flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-xs" aria-hidden="true"></i> Terdaftar {{ $player->joined_year }}
                            </span>
                            <a href="{{ route('parent.portal', ['nis' => $player->nis]) }}"
                               class="min-h-[44px] px-3 py-2 inline-flex items-center gap-1 font-bold text-[#0000FF] border border-transparent hover:border-[#111111] hover:bg-[#FFFF00] hover:text-[#111111] transition-colors">
                                <span>Kartu Digital</span>
                                <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $players->links() }}
            </div>
        @else
            <div class="bg-[#FFFFFF] p-10 text-center border-2 border-[#111111] max-w-2xl mx-auto">
                <div class="w-12 h-12 mx-auto mb-4 bg-[#FFFF00] border-2 border-[#111111] flex items-center justify-center text-[#111111]">
                    <i class="fa-solid fa-magnifying-glass text-lg" aria-hidden="true"></i>
                </div>
                <h3 class="font-bold text-[#111111] text-lg">Tidak Ada Data Pemain Ditemukan</h3>
                <p class="text-[#525252] text-sm mt-2">Ubah kata kunci pencarian atau pilih tahun lahir yang lain.</p>
                <a href="{{ route('home') }}#roster" class="mt-6 btn-primary text-xs">Reset Filter</a>
            </div>
        @endif

    </div>
</section>


<!-- SECTION 2: PROGRAM KELOMPOK UMUR (Asymmetric Mondrian Span Grid) -->
<section id="program" class="relative py-14 sm:py-16 lg:py-20 bg-[#FFFFFF] border-b-2 border-[#111111]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6">

        <div class="max-w-3xl mb-10">
            <span class="text-xs font-mono font-bold text-[#CC0000] uppercase tracking-wider block">Kurikulum Pembinaan</span>
            <h2 class="text-2xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Program Kelompok Umur (KU)
            </h2>
            <p class="text-[#525252] mt-2 text-sm sm:text-base max-w-[72ch] leading-relaxed">
                Kurikulum bertahap sesuai kelompok usia untuk membentuk kedisiplinan, teknik dasar sepak bola, dan kesiapan kompetisi.
            </p>
        </div>

        <!-- Asymmetric 12-Col Mondrian Layout (7/5, 5/7, 12) - Zero 3-Equal-Columns -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            @foreach($ageCategories as $cat)
                @php
                    $idx = $loop->index;
                    $colClass = match($idx % 5) {
                        0 => 'md:col-span-7',
                        1 => 'md:col-span-5',
                        2 => 'md:col-span-5',
                        3 => 'md:col-span-7',
                        default => 'md:col-span-12',
                    };
                    $accentHeader = match($idx % 3) {
                        0 => 'bg-[#FFFF00] text-[#111111]',
                        1 => 'bg-[#0000FF] text-[#FFFFFF]',
                        default => 'bg-[#FF0000] text-[#000000]',
                    };
                @endphp
                <div class="{{ $colClass }} bg-[#FFFFFF] border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex flex-col justify-between">
                    <div>
                        <div class="{{ $accentHeader }} border-b-2 border-[#111111] px-5 py-3 flex justify-between items-center gap-3">
                            <span class="font-mono font-bold text-sm uppercase tracking-wider">
                                {{ $cat->code }}
                            </span>
                            <span class="text-xs font-mono font-bold bg-[#FFFFFF] text-[#111111] px-2.5 py-0.5 border border-[#111111]">
                                Lahir {{ $cat->min_birth_year }} - {{ $cat->max_birth_year }}
                            </span>
                        </div>

                        <div class="p-6 space-y-5">
                            <div>
                                <h3 class="font-bold text-[#111111] text-xl mb-1.5">{{ $cat->category_name }}</h3>
                                <p class="text-[#525252] text-sm leading-relaxed max-w-[72ch]">{{ $cat->description }}</p>
                            </div>

                            <div class="space-y-2 border-t-2 border-[#111111] pt-4 text-xs sm:text-sm">
                                <div class="flex justify-between gap-4">
                                    <span class="text-[#525252]">Jadwal Latihan:</span>
                                    <span class="font-bold text-[#111111] text-right">{{ $cat->schedule_days }}</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="text-[#525252]">Jam Latihan:</span>
                                    <span class="font-bold font-mono text-[#111111] text-right">{{ $cat->schedule_time }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-[#F4F4F4] border-t-2 border-[#111111] flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] block uppercase tracking-wider font-bold">SPP Bulanan</span>
                            <span class="text-2xl font-bold text-[#111111] font-mono">
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


<!-- SECTION 3: MEKAR JAYA MINI SOCCER (Charcoal Dark Canvas with Primary Mondrian Headers) -->
<section id="mini-soccer" class="relative py-14 sm:py-16 lg:py-20 bg-[#111111] text-[#FFFFFF] border-b-2 border-[#111111] dark-surface">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end pb-8 border-b-2 border-[#333333] mb-10">
            <div class="lg:col-span-8">
                <span class="text-xs font-mono font-bold text-[#FFFF00] uppercase tracking-wider block">Fasilitas Mini Soccer</span>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight mt-1">
                    Sewa Lapangan Mekar Jaya Mini Soccer
                </h2>
                <p class="text-[#D4D4D4] mt-2 text-sm sm:text-base max-w-[72ch] leading-relaxed">
                    Lapangan rumput sintetis berstandar di Jl. Arief Rahman Hakim No.18, Cigadung, Subang. Operasional setiap hari pukul 06.00 - 00.00 WIB.
                </p>
            </div>
            <div class="lg:col-span-4 bg-[#FFFF00] text-[#111111] border-2 border-[#FFFFFF] p-4 font-mono text-xs space-y-1">
                <span class="font-bold uppercase tracking-wider block">Reservasi Resmi (WA)</span>
                <span class="text-base font-bold block">0851-3346-3626</span>
                <span class="block text-[#111111]">Konfirmasi slot jadwal langsung dengan pengelola lapangan.</span>
            </div>
        </div>

        <!-- 2-Column Ledger Grid (Avoids cramped 4-narrow/3-col repetition) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($miniSoccerRates as $rate)
                @php
                    $barBg = match($loop->index % 3) {
                        0 => 'bg-[#FF0000] text-[#000000]',
                        1 => 'bg-[#0000FF] text-[#FFFFFF]',
                        default => 'bg-[#FFFF00] text-[#111111]',
                    };
                @endphp
                <div class="bg-[#1A1A1A] border-2 border-[#FFFFFF] flex flex-col justify-between">
                    <div>
                        <div class="{{ $barBg }} border-b-2 border-[#FFFFFF] px-5 py-2.5 flex items-center justify-between text-xs font-mono font-bold uppercase tracking-wider">
                            <span>{{ $rate->day_type }}</span>
                            <span>SLOT {{ $loop->iteration }}</span>
                        </div>

                        <div class="p-6 space-y-4">
                            <h3 class="font-bold text-white text-lg">{{ $rate->time_slot }}</h3>
                            <div>
                                <span class="text-3xl sm:text-4xl font-bold text-[#FFFF00] font-mono">
                                    Rp {{ number_format($rate->price_per_hour, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-[#D4D4D4] ml-1">/ Jam</span>
                            </div>
                            <p class="text-xs sm:text-sm text-[#D4D4D4] leading-relaxed border-t border-[#333333] pt-4">
                                <i class="fa-solid fa-check text-[#FFFF00] mr-1.5" aria-hidden="true"></i> {{ $rate->facilities }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 pt-0">
                        <a href="https://wa.me/6285133463626?text=Halo%20Mekar%20Jaya%20Mini%20Soccer,%20saya%20ingin%20booking%20lapangan%20slot%20{{ urlencode($rate->time_slot) }}"
                           target="_blank"
                           class="w-full btn-yellow text-sm">
                            <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i> Booking Lapangan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- SECTION 4: TIM PELATIH (Asymmetric Featured Head Coach + Horizontal Staff Stack) -->
<section id="pelatih" class="relative py-14 sm:py-16 lg:py-20 bg-[#FFFFFF] border-b-2 border-[#111111]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6">

        <div class="max-w-3xl mb-10">
            <span class="text-xs font-mono font-bold text-[#0000FF] uppercase tracking-wider block">Tim Profesional</span>
            <h2 class="text-2xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Staf Pelatih Berlisensi PSSI & AFC
            </h2>
            <p class="text-[#525252] mt-2 text-sm sm:text-base max-w-[72ch] leading-relaxed">
                Pelatih berlisensi mendampingi perkembangan teknik, kedisiplinan, dan sportivitas setiap siswa di lapangan.
            </p>
        </div>

        <!-- Asymmetric [6 cols Featured] + [6 cols Stacked Horizontals] (NO 3 Equal Columns!) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @foreach($coaches as $coach)
                @if($loop->first)
                    <div class="lg:col-span-6 lg:row-span-2 bg-[#FFFFFF] border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex flex-col justify-between">
                        <div>
                            <div class="bg-[#FF0000] text-[#000000] border-b-2 border-[#111111] px-5 py-3 flex items-center justify-between text-xs font-mono font-bold uppercase tracking-wider">
                                <span><i class="fa-solid fa-certificate mr-1.5" aria-hidden="true"></i> {{ $coach->license }}</span>
                                <span>PELATIH UTAMA</span>
                            </div>

                            <div class="p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-start">
                                <div class="w-40 h-44 shrink-0 border-2 border-[#111111] bg-[#F4F4F4] overflow-hidden">
                                    @if($coach->photo && file_exists(public_path($coach->photo)))
                                        <img src="{{ asset($coach->photo) }}" alt="{{ $coach->name }}" class="w-full h-full object-cover object-top">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#FFFF00] text-[#111111] text-4xl font-mono font-bold">
                                            {{ strtoupper(substr($coach->name, 6, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-3 min-w-0">
                                    <h3 class="font-bold text-[#111111] text-2xl leading-tight">{{ $coach->name }}</h3>
                                    <p class="text-sm font-bold text-[#0000FF]">{{ $coach->role_title }}</p>
                                    <p class="text-xs sm:text-sm text-[#525252] leading-relaxed">
                                        Memimpin perancangan kurikulum latihan usia dini, pemantauan rapor teknik berkala, serta persiapan kejuaraan regional Askab PSSI Subang.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-[#F4F4F4] border-t-2 border-[#111111] flex flex-wrap items-center justify-between gap-3 text-xs">
                            <span class="font-mono font-bold text-[#111111]">
                                <i class="fa-solid fa-clock-rotate-left text-[#CC0000] mr-1.5" aria-hidden="true"></i> Pengalaman {{ $coach->experience_years }} Tahun
                            </span>
                            @if($coach->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $coach->phone) }}?text=Halo%20{{ urlencode($coach->name) }},%20saya%20ingin%20bertanya%20mengenai%20latihan%20di%20SSB%20Mekar%20Jaya"
                                   target="_blank"
                                   class="btn-blue text-xs py-2 px-4">
                                    <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i> Konsultasi Coach
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="lg:col-span-6 bg-[#FFFFFF] border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex flex-col sm:flex-row items-stretch">
                        <div class="sm:w-40 h-48 sm:h-auto shrink-0 border-b-2 sm:border-b-0 sm:border-r-2 border-[#111111] bg-[#F4F4F4] overflow-hidden">
                            @if($coach->photo && file_exists(public_path($coach->photo)))
                                <img src="{{ asset($coach->photo) }}" alt="{{ $coach->name }}" class="w-full h-full object-cover object-top">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#0000FF] text-white text-3xl font-mono font-bold">
                                    {{ strtoupper(substr($coach->name, 6, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex-grow flex flex-col justify-between gap-4">
                            <div class="space-y-2">
                                <span class="inline-block px-2.5 py-0.5 border border-[#111111] bg-[#FFFF00] text-[#111111] text-[11px] font-mono font-bold uppercase">
                                    {{ $coach->license }}
                                </span>
                                <h3 class="font-bold text-[#111111] text-lg leading-tight">{{ $coach->name }}</h3>
                                <p class="text-xs font-medium text-[#525252]">{{ $coach->role_title }}</p>
                            </div>

                            <div class="pt-3 border-t border-[#D4D4D4] flex items-center justify-between gap-3 text-xs">
                                <span class="font-mono font-bold text-[#111111]">
                                    <i class="fa-solid fa-clock-rotate-left text-[#0000FF] mr-1" aria-hidden="true"></i> {{ $coach->experience_years }} Th Pengalaman
                                </span>
                                @if($coach->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $coach->phone) }}?text=Halo%20{{ urlencode($coach->name) }},%20saya%20ingin%20bertanya%20mengenai%20latihan%20di%20SSB%20Mekar%20Jaya"
                                       target="_blank"
                                       class="min-h-[44px] px-3.5 py-2 border-2 border-[#111111] bg-[#FFFFFF] hover:bg-[#FFFF00] text-[#111111] font-bold inline-flex items-center gap-1.5 transition-colors">
                                        <i class="fa-brands fa-whatsapp text-sm text-[#166534]" aria-hidden="true"></i>
                                        <span>Konsultasi</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</section>


<!-- SECTION 5: FORM PENDAFTARAN SISWA BARU (De Stijl Form + Auto-KU + Live KK Preview) -->
<section id="pendaftaran" class="relative py-14 sm:py-16 lg:py-20 bg-[#FFFFFF]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        <div class="mb-8 border-b-2 border-[#111111] pb-6">
            <span class="text-xs font-mono font-bold text-[#CC0000] uppercase tracking-wider block">Formulir Pendaftaran</span>
            <h2 class="text-2xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Pendaftaran Siswa Baru SSB
            </h2>
            <p class="text-[#525252] text-sm sm:text-base mt-2 max-w-[68ch]">
                Lengkapi 3 bagian formulir di bawah ini untuk mendaftarkan calon siswa baru ke SSB Mekar Jaya Subang.
            </p>

            <!-- Interactive 3-Part Progress Indicator Strip -->
            <div class="grid grid-cols-3 border-2 border-[#111111] bg-[#111111] gap-[2px] mt-6 text-xs font-mono font-bold" id="reg-step-indicator">
                <div data-step="1" class="step-pill bg-[#FF0000] text-[#000000] p-3 text-center">1. Data Siswa</div>
                <div data-step="2" class="step-pill bg-[#FFFFFF] text-[#111111] p-3 text-center">2. Data Orang Tua</div>
                <div data-step="3" class="step-pill bg-[#FFFFFF] text-[#111111] p-3 text-center">3. Upload KK & Kirim</div>
            </div>
        </div>

        <!-- Alert Success Notification -->
        @if(session('success'))
            <x-alert type="success" title="Pendaftaran Berhasil!" class="mb-8">
                <p class="leading-relaxed">{{ session('success') }}</p>
                <div class="mt-2.5 pt-2.5 border-t border-[#166534]/30 flex items-center gap-2 text-[#14532D] text-xs font-bold">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    <span>Pengurus SSB akan segera memverifikasi kelengkapan berkas pendaftaran Anda.</span>
                </div>
            </x-alert>
        @endif

        <!-- Alert Error Notification -->
        @if($errors->any())
            <x-alert type="error" title="Mohon Periksa Kembali Formulir Anda" class="mb-8">
                <p class="mb-2 font-bold text-[#111111]">Terdapat beberapa kesalahan pengisian formulir:</p>
                <ul class="list-disc list-inside space-y-1 text-xs text-[#111111]">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <div class="bg-[#FFFFFF] p-6 sm:p-10 border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
            <form id="registration-form" action="{{ route('public.register') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Step 1 -->
                <fieldset data-reg-step="1" class="space-y-5">
                    <legend class="w-full font-bold text-[#111111] text-base border-b-2 border-[#111111] pb-3 flex items-center gap-3">
                        <span class="w-7 h-7 bg-[#FF0000] text-[#000000] border-2 border-[#111111] flex items-center justify-center text-xs font-mono font-bold">1</span>
                        Data Calon Siswa
                    </legend>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="full_name" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Nama Lengkap Siswa *</label>
                            <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                                   autocomplete="name" placeholder="Contoh: Muhammad Fatih"
                                   class="ds-input">
                        </div>

                        <div>
                            <label for="position_preference" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Posisi Yang Diminati *</label>
                            <select id="position_preference" name="position_preference" required class="ds-input">
                                <option value="Gelandang" {{ old('position_preference') == 'Gelandang' ? 'selected' : '' }}>Gelandang (Midfielder)</option>
                                <option value="Striker" {{ old('position_preference') == 'Striker' ? 'selected' : '' }}>Striker (Forward)</option>
                                <option value="Penyerang Sayap" {{ old('position_preference') == 'Penyerang Sayap' ? 'selected' : '' }}>Penyerang Sayap (Winger)</option>
                                <option value="Bek Tengah" {{ old('position_preference') == 'Bek Tengah' ? 'selected' : '' }}>Bek Tengah (Center Back)</option>
                                <option value="Bek Sayap" {{ old('position_preference') == 'Bek Sayap' ? 'selected' : '' }}>Bek Sayap (Full Back)</option>
                                <option value="Kiper" {{ old('position_preference') == 'Kiper' ? 'selected' : '' }}>Kiper (Goalkeeper)</option>
                            </select>
                        </div>

                        <div>
                            <label for="jersey_size" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Ukuran Jersey Tim *</label>
                            <select id="jersey_size" name="jersey_size" required class="ds-input">
                                <option value="S" {{ old('jersey_size') == 'S' ? 'selected' : '' }}>S (Ukuran Anak / Kecil)</option>
                                <option value="M" {{ old('jersey_size', 'M') == 'M' ? 'selected' : '' }}>M (Ukuran Sedang)</option>
                                <option value="L" {{ old('jersey_size') == 'L' ? 'selected' : '' }}>L (Ukuran Besar)</option>
                                <option value="XL" {{ old('jersey_size') == 'XL' ? 'selected' : '' }}>XL (Ukuran Extra Large)</option>
                                <option value="XXL" {{ old('jersey_size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                        </div>

                        <div>
                            <label for="birth_place" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Tempat Lahir *</label>
                            <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place', 'Subang') }}"
                                   class="ds-input">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="birth_date" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Tanggal Lahir *</label>
                            <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}"
                                   aria-describedby="auto-ku-helper"
                                   class="ds-input font-mono font-bold">
                            <!-- Live Auto-KU Helper Output -->
                            <div id="auto-ku-helper" aria-live="polite" class="hidden mt-2.5 p-3 bg-[#FFFF00] border-2 border-[#111111] text-xs text-[#111111] flex flex-wrap items-center justify-between gap-2">
                                <span id="auto-ku-text" class="font-bold"></span>
                                <span id="auto-ku-badge" class="bg-[#0000FF] text-white px-2.5 py-0.5 font-mono font-bold border border-[#111111]"></span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="school_name" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Nama Sekolah Asal</label>
                            <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}"
                                   placeholder="Contoh: SDN Dangdeur 1 Subang"
                                   class="ds-input">
                        </div>
                    </div>
                </fieldset>

                <!-- Step 2 -->
                <fieldset data-reg-step="2" class="space-y-5">
                    <legend class="w-full font-bold text-[#111111] text-base border-b-2 border-[#111111] pb-3 flex items-center gap-3">
                        <span class="w-7 h-7 bg-[#0000FF] text-white border-2 border-[#111111] flex items-center justify-center text-xs font-mono font-bold">2</span>
                        Data Orang Tua / Wali
                    </legend>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="parent_name" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Nama Orang Tua / Wali *</label>
                            <input type="text" id="parent_name" name="parent_name" required value="{{ old('parent_name') }}"
                                   autocomplete="name" placeholder="Nama Ibu / Bapak"
                                   class="ds-input">
                        </div>

                        <div>
                            <label for="parent_phone" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">No. WhatsApp Orang Tua *</label>
                            <input type="tel" id="parent_phone" name="parent_phone" required value="{{ old('parent_phone') }}"
                                   inputmode="tel" autocomplete="tel" placeholder="0851-XXXX-XXXX"
                                   class="ds-input font-mono">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="2" autocomplete="street-address" placeholder="Desa / Kecamatan di Subang..."
                                      class="ds-input min-h-[80px]">{{ old('address') }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="health_notes" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Catatan Kesehatan (Jika Ada)</label>
                            <input type="text" id="health_notes" name="health_notes" value="{{ old('health_notes') }}"
                                   placeholder="Contoh: Tidak ada alergi atau riwayat asma"
                                   class="ds-input">
                        </div>
                    </div>
                </fieldset>

                <!-- Step 3 -->
                <fieldset data-reg-step="3" class="space-y-5">
                    <legend class="w-full font-bold text-[#111111] text-base border-b-2 border-[#111111] pb-3 flex items-center gap-3">
                        <span class="w-7 h-7 bg-[#FFFF00] text-[#111111] border-2 border-[#111111] flex items-center justify-center text-xs font-mono font-bold">3</span>
                        Dokumen Persyaratan
                    </legend>

                    <div class="space-y-4">
                        <div>
                            <label for="kk_document" class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">
                                Upload Dokumen Kartu Keluarga (KK) *
                            </label>
                            <p id="kk-format-hint" class="text-xs text-[#525252] mb-2">
                                Format wajib: JPG, JPEG, PNG, atau WEBP. Berkas di atas 2 MB otomatis dikompresi oleh sistem.
                            </p>
                            <input type="file" id="kk_document" name="kk_document" required
                                   accept="image/jpeg,image/png,image/webp,image/jpg"
                                   aria-describedby="kk-format-hint"
                                   class="w-full p-2.5 border-2 border-[#111111] bg-[#F4F4F4] text-[#111111] text-xs file:mr-4 file:py-2.5 file:px-4 file:border-2 file:border-[#111111] file:text-xs file:font-bold file:bg-[#0000FF] file:text-white hover:file:bg-[#0000D6] cursor-pointer">

                            <!-- Live KK Preview Box (Hidden until file selected) -->
                            <div id="kk-preview-card" class="hidden mt-3 border-2 border-[#111111] bg-[#F4F4F4] p-4 space-y-3">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <img id="kk-preview-img" src="" alt="Preview dokumen Kartu Keluarga" class="w-32 h-24 object-contain bg-white border-2 border-[#111111] shrink-0">
                                    <div class="flex-grow min-w-0 space-y-1.5 text-xs">
                                        <p id="kk-file-name" class="font-bold text-[#111111] truncate"></p>
                                        <p id="kk-file-meta" class="font-mono text-[#525252]"></p>
                                        <span id="kk-file-status" class="inline-block px-2.5 py-0.5 text-[11px] font-bold border border-[#111111]"></span>
                                    </div>
                                    <button type="button" id="kk-clear-btn" class="btn-secondary text-xs py-2 px-3.5 shrink-0">
                                        Ganti / Hapus Foto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox Persetujuan Syarat & Ketentuan -->
                        <div class="p-4 bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF]">
                            <label for="terms_agreement" class="flex items-start gap-3 text-xs sm:text-sm text-[#111111] cursor-pointer">
                                <input type="checkbox" id="terms_agreement" name="terms_agreement" value="1" required {{ old('terms_agreement') ? 'checked' : '' }}
                                       class="mt-1 h-5 w-5 shrink-0 border-2 border-[#111111] accent-[#0000FF] cursor-pointer">
                                <span class="leading-relaxed">
                                    Saya menyatakan bahwa seluruh data yang diisi adalah benar, dan saya menyetujui
                                    <button type="button" onclick="openPrivacyModal()" class="font-bold text-[#0000FF] underline underline-offset-2 hover:bg-[#FFFF00] hover:text-[#111111] px-0.5 cursor-pointer inline">
                                        Syarat & Ketentuan serta Kebijakan Privasi Dokumen KK
                                    </button>
                                    SSB Mekar Jaya Subang. *
                                </span>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="pt-2 space-y-2">
                    <button type="submit" id="reg-submit-btn" class="w-full btn-primary py-4 text-sm font-bold">
                        <i class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                        <span id="reg-submit-label">Kirim Formulir Pendaftaran Online</span>
                    </button>
                    <!-- Geometric Horizontal Loader (Hidden until submit) -->
                    <div id="reg-loading-bar" class="hidden destijl-loading-track" aria-hidden="true">
                        <div class="destijl-loading-bar"></div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</section>


<!-- SECTION 6: FAQ (Frequently Asked Questions & Keamanan Data) -->
<section id="faq" class="py-14 sm:py-16 lg:py-20 bg-[#F4F4F4] border-t-2 border-[#111111]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        <div class="mb-10">
            <span class="text-xs font-mono font-bold text-[#0000FF] uppercase tracking-wider block">Tanya Jawab Umum</span>
            <h2 class="text-2xl sm:text-4xl font-bold text-[#111111] tracking-tight mt-1">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-[#525252] text-sm sm:text-base mt-2 max-w-[68ch] leading-relaxed">
                Informasi resmi mengenai pendaftaran siswa baru, keamanan dokumen Kartu Keluarga (KK), jadwal latihan, dan fasilitas SSB Mekar Jaya Subang.
            </p>
        </div>

        <!-- FAQ Accordion List (Preserves .faq-item, button, and .faq-content.hidden per TC-14) -->
        <div class="space-y-3" id="faq-accordion">

            <!-- FAQ 1 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        1. Mengapa pendaftaran siswa SSB Mekar Jaya mewajibkan upload foto Kartu Keluarga (KK)?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Dokumen Kartu Keluarga dibutuhkan untuk memverifikasi keabsahan tanggal dan tahun kelahiran anak. Dalam pembinaan sepak bola usia dini, keaslian data kelahiran sangat krusial agar anak ditempatkan pada Kelompok Umur (KU) yang tepat (seperti U-10, U-12, U-14, U-16, atau U-18), serta memenuhi syarat pendaftaran atlet resmi pada turnamen Askab PSSI Subang.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        2. Bagaimana SSB Mekar Jaya menjaga keamanan dan privasi foto KK anak saya?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Kami memperlakukan dokumen KK sebagai data sensitif sesuai Undang-Undang No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP). Dokumen hanya dapat dibuka oleh pengurus administrasi resmi SSB saat verifikasi data dan tidak pernah dipublikasikan atau dibagikan di luar registrasi kompetisi resmi sepak bola.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        3. Bagaimana jika ukuran foto KK saya lebih dari 2 MB?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Sistem kami dilengkapi kompresi gambar otomatis. Apabila foto dokumen KK yang Anda pilih berukuran di atas 2 MB, server otomatis merampingkan ukuran file sebelum disimpan dengan tetap mempertahankan keterbacaan angka dan nama pada dokumen.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        4. Format file dokumen KK apa saja yang diterima pada form pendaftaran?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Sistem menerima berkas gambar standar hasil foto ponsel atau pemindaian, yaitu format JPG, JPEG, PNG, dan WEBP dengan ukuran maksimal sebelum kompresi sebesar 10 MB.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        5. Kapan jadwal latihan rutin SSB Mekar Jaya dan di mana lokasinya?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Sesi latihan rutin diadakan 3 kali seminggu, setiap hari Selasa dan Kamis sore (pukul 15.30 - 17.30 WIB) serta Minggu pagi (pukul 07.30 - 09.30 WIB) bertempat di Lapangan Veteran Dangdeur, Subang.
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        6. Bagaimana alur proses setelah mengirim formulir pendaftaran online?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Setelah formulir dikirim, sistem menerbitkan Kode Pendaftaran unik. Pengurus SSB memeriksa dan memvalidasi dokumen KK dalam waktu maksimal 1x24 jam kerja. Setelah disetujui, admin menghubungi nomor WhatsApp orang tua untuk menyampaikan Nomor Induk Siswa (NIS) dan jadwal latihan perdana.
                </div>
            </div>

            <!-- FAQ 7 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        7. Bagaimana cara orang tua memantau nilai rapor perkembangan anak?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Orang tua dapat membuka menu <strong class="text-[#111111]">Portal Orang Tua</strong> kapan saja. Masukkan Nomor Induk Siswa (NIS), nama lengkap siswa, atau nomor WhatsApp terdaftar untuk melihat kartu anggota digital beserta diagram radar penilaian teknik (passing, dribbling, shooting, fisik, disiplin, dan taktik).
                </div>
            </div>

            <!-- FAQ 8 -->
            <div class="faq-item bg-[#FFFFFF] border-2 border-[#111111] overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false"
                        class="w-full min-h-[54px] p-4 sm:p-5 text-left flex items-center justify-between gap-4 hover:bg-[#FFFF00]/30 transition-colors cursor-pointer">
                    <span class="font-bold text-sm text-[#111111]">
                        8. Apakah pemesanan lapangan Mini Soccer dapat dilakukan langsung melalui WhatsApp?
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-[#111111] faq-icon transition-transform duration-200 shrink-0" aria-hidden="true"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-[#525252] leading-relaxed border-t-2 border-[#111111] pt-4 bg-[#FFFFFF]">
                    Untuk menjaga akurasi ketersediaan slot lapangan rumput sintetis secara langsung, reservasi lapangan Mini Soccer dilayani langsung melalui WhatsApp pengelola resmi kami di <strong class="font-mono text-[#111111]">0851-3346-3626</strong>.
                </div>
            </div>

        </div>

        <!-- Help Banner (Asymmetric Mondrian Strip) -->
        <div class="mt-10 bg-[#FFFFFF] border-2 border-[#111111] grid grid-cols-1 sm:grid-cols-12">
            <div class="sm:col-span-8 p-6 border-b-2 sm:border-b-0 sm:border-r-2 border-[#111111]">
                <h4 class="font-bold text-base text-[#111111]">Masih Memiliki Pertanyaan Lain?</h4>
                <p class="text-xs sm:text-sm text-[#525252] mt-1">Pengurus SSB Mekar Jaya Subang siap membantu melalui layanan pesan WhatsApp resmi.</p>
            </div>
            <div class="sm:col-span-4 bg-[#FFFF00] p-6 flex items-center justify-center">
                <a href="https://wa.me/6285133463626?text={{ rawurlencode('Halo Pengurus SSB Mekar Jaya, saya ingin bertanya seputar pendaftaran siswa...') }}" target="_blank"
                   class="w-full btn-blue text-xs py-3 px-4">
                    <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i> Chat Sekretariat WA
                </a>
            </div>
        </div>

    </div>
</section>


<!-- LANDING PAGE UX SCRIPTS (Copy NIS, Auto-KU Calculator, Live KK Preview, Step Tracker, Submit State, FAQ) -->
<script>
    // 1. Copy Player NIS with accessible feedback
    function copyPlayerNis(nis, buttonEl) {
        const updateBtn = () => {
            const icon = buttonEl.querySelector('i');
            if (icon) icon.className = 'fa-solid fa-check text-[#166534]';
            buttonEl.setAttribute('title', 'NIS Tersalin!');
            buttonEl.classList.add('bg-[#DCFCE7]');
            setTimeout(() => {
                if (icon) icon.className = 'fa-regular fa-copy';
                buttonEl.setAttribute('title', 'Salin NIS ' + nis);
                buttonEl.classList.remove('bg-[#DCFCE7]');
            }, 1500);
        };

        const fallbackCopy = () => {
            const tmp = document.createElement('input');
            tmp.value = nis;
            document.body.appendChild(tmp);
            tmp.select();
            try { document.execCommand('copy'); } catch (err) {}
            document.body.removeChild(tmp);
            updateBtn();
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(nis).then(updateBtn).catch(fallbackCopy);
        } else {
            fallbackCopy();
        }
    }

    // 2. Auto-KU Calculator on Birth Date change
    (function() {
        const categories = @json($kuJson);
        const birthInput = document.getElementById('birth_date');
        const helperBox = document.getElementById('auto-ku-helper');
        const helperText = document.getElementById('auto-ku-text');
        const helperBadge = document.getElementById('auto-ku-badge');

        if (!birthInput || !helperBox) return;

        const updateKuHelper = () => {
            if (!birthInput.value) {
                helperBox.classList.add('hidden');
                return;
            }
            const parts = birthInput.value.split('-');
            const yr = parseInt(parts[0], 10);
            if (!yr || isNaN(yr)) return;

            const match = categories.find(c => yr >= c.min_year && yr <= c.max_year);
            helperBox.classList.remove('hidden');
            if (match) {
                helperText.textContent = 'Perkiraan Kelompok Umur (Kelahiran ' + yr + '): ' + match.name;
                helperBadge.textContent = match.code;
            } else {
                helperText.textContent = 'Tahun kelahiran ' + yr + ' terdeteksi. Pengurus SSB akan mengonfirmasi kategori usia yang sesuai.';
                helperBadge.textContent = 'Kelahiran ' + yr;
            }
        };

        birthInput.addEventListener('change', updateKuHelper);
        birthInput.addEventListener('input', updateKuHelper);
        if (birthInput.value) updateKuHelper();
    })();

    // 3. Live KK Document Preview & Size Check (> 2MB auto-compression note)
    (function() {
        const fileInput = document.getElementById('kk_document');
        const previewCard = document.getElementById('kk-preview-card');
        const previewImg = document.getElementById('kk-preview-img');
        const fileNameEl = document.getElementById('kk-file-name');
        const fileMetaEl = document.getElementById('kk-file-meta');
        const fileStatusEl = document.getElementById('kk-file-status');
        const clearBtn = document.getElementById('kk-clear-btn');

        if (!fileInput || !previewCard) return;

        let currentObjUrl = null;

        const resetPreview = () => {
            if (currentObjUrl) {
                URL.revokeObjectURL(currentObjUrl);
                currentObjUrl = null;
            }
            fileInput.value = '';
            previewImg.src = '';
            previewCard.classList.add('hidden');
        };

        fileInput.addEventListener('change', function() {
            const file = this.files && this.files[0];
            if (!file) {
                resetPreview();
                return;
            }

            if (!file.type.startsWith('image/')) {
                fileNameEl.textContent = file.name;
                fileMetaEl.textContent = 'Tipe tidak didukung';
                fileStatusEl.textContent = 'Pilih file gambar JPG, PNG, atau WEBP';
                fileStatusEl.className = 'inline-block px-2.5 py-0.5 text-[11px] font-bold bg-[#FEE2E2] text-[#991B1B] border border-[#111111]';
                previewImg.src = '';
                previewCard.classList.remove('hidden');
                return;
            }

            if (currentObjUrl) URL.revokeObjectURL(currentObjUrl);
            currentObjUrl = URL.createObjectURL(file);
            previewImg.src = currentObjUrl;
            fileNameEl.textContent = file.name;

            const sizeBytes = file.size;
            const sizeMb = sizeBytes / (1024 * 1024);
            const sizeLabel = sizeMb >= 1 ? sizeMb.toFixed(2) + ' MB' : Math.max(1, Math.round(sizeBytes / 1024)) + ' KB';
            fileMetaEl.textContent = 'Ukuran berkas: ' + sizeLabel;

            if (sizeMb > 2) {
                fileStatusEl.textContent = 'Di atas 2 MB: otomatis dikompresi saat dikirim';
                fileStatusEl.className = 'inline-block px-2.5 py-0.5 text-[11px] font-bold bg-[#FFFF00] text-[#111111] border border-[#111111]';
            } else {
                fileStatusEl.textContent = 'Dokumen siap diunggah';
                fileStatusEl.className = 'inline-block px-2.5 py-0.5 text-[11px] font-bold bg-[#DCFCE7] text-[#14532D] border border-[#111111]';
            }

            previewCard.classList.remove('hidden');
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', resetPreview);
        }
    })();

    // 4. Interactive 3-Part Step Indicator Highlight + Safe Submit Loading State
    (function() {
        const form = document.getElementById('registration-form');
        const pills = document.querySelectorAll('#reg-step-indicator .step-pill');
        if (!form) return;

        const setStep = (stepNum) => {
            pills.forEach(p => {
                const s = p.getAttribute('data-step');
                if (s === String(stepNum)) {
                    p.className = 'step-pill bg-[#FF0000] text-[#000000] p-3 text-center';
                } else if (Number(s) < Number(stepNum)) {
                    p.className = 'step-pill bg-[#0000FF] text-[#FFFFFF] p-3 text-center';
                } else {
                    p.className = 'step-pill bg-[#FFFFFF] text-[#111111] p-3 text-center';
                }
            });
        };

        form.addEventListener('focusin', (e) => {
            const fs = e.target.closest('fieldset[data-reg-step]');
            if (fs) setStep(fs.getAttribute('data-reg-step'));
        });

        const submitBtn = document.getElementById('reg-submit-btn');
        const submitLabel = document.getElementById('reg-submit-label');
        const loader = document.getElementById('reg-loading-bar');

        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) return;
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-90', 'cursor-wait');
            }
            if (submitLabel) {
                submitLabel.textContent = 'Mengunggah & Memproses Dokumen...';
            }
            if (loader) {
                loader.classList.remove('hidden');
            }
        });
    })();

    // 5. Accordion FAQ Toggle (Preserves .faq-item and .hidden behavior for TC-14)
    function toggleFaq(btn) {
        const item = btn.closest('.faq-item');
        const content = item.querySelector('.faq-content');
        const icon = item.querySelector('.faq-icon');
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';

        document.querySelectorAll('.faq-item').forEach(function(otherItem) {
            if (otherItem !== item) {
                const otherBtn = otherItem.querySelector('button');
                const otherContent = otherItem.querySelector('.faq-content');
                const otherIcon = otherItem.querySelector('.faq-icon');
                if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
                if (otherContent) otherContent.classList.add('hidden');
                if (otherIcon) otherIcon.classList.remove('rotate-180');
            }
        });

        if (isExpanded) {
            btn.setAttribute('aria-expanded', 'false');
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        } else {
            btn.setAttribute('aria-expanded', 'true');
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        }
    }
</script>

@endsection
