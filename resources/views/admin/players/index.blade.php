@extends('layouts.admin')

@section('title', 'Manajemen Pemain Per Tahun - Mekar Jaya Sport Subang')
@section('page-header', 'Manajemen Data Pemain SSB')

@section('content')

<div class="space-y-6">

    <!-- Header Control Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 editorial-card p-6 border-l-[6px] border-l-[#0000FF]">
        <div>
            <h2 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                <i class="fa-solid fa-users text-[#0000FF]" aria-hidden="true"></i> Master Data Siswa SSB Mekar Jaya
            </h2>
            <p class="text-xs text-[#525252] mt-0.5">Total <strong class="font-mono text-[#111111]">{{ $players->total() }}</strong> pemain terdaftar (berdasarkan filter aktif).</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.players.print', request()->all()) }}" target="_blank"
               class="btn-secondary text-xs py-2.5 px-4">
                <i class="fa-solid fa-print" aria-hidden="true"></i> Cetak Roster Filter Ini
            </a>
            <a href="{{ route('admin.players.create') }}"
               class="btn-primary text-xs py-2.5 px-4">
                <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Tambah Pemain Baru
            </a>
        </div>
    </div>

    <!-- FILTER SYSTEM -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.players.index') }}" method="GET" class="space-y-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4 items-end text-xs">

                <!-- Search Input -->
                <div class="md:col-span-4">
                    <label for="search" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Cari Nama / NIS / Panggilan</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                           autocorrect="off" autocapitalize="off" spellcheck="false"
                           placeholder="Contoh: Fatih, SSB-MJ..."
                           class="ds-input text-sm py-2.5">
                </div>

                <!-- Filter by Birth Year -->
                <div class="md:col-span-3">
                    <label for="year" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">
                        <i class="fa-solid fa-calendar text-[#CC0000] mr-1" aria-hidden="true"></i> Filter Tahun Lahir
                    </label>
                    <select id="year" name="year" class="ds-input text-sm py-2.5 font-medium">
                        <option value="">-- Semua Tahun Lahir --</option>
                        @foreach($availableYears as $yr)
                            <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                                Kelahiran {{ $yr }} (Usia {{ date('Y') - $yr }} Thn)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Kelompok Umur -->
                <div class="md:col-span-2">
                    <label for="ku" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kelompok Umur</label>
                    <select id="ku" name="ku" class="ds-input text-sm py-2.5">
                        <option value="">-- Semua KU --</option>
                        @foreach($ageCategories as $cat)
                            <option value="{{ $cat->code }}" {{ request('ku') == $cat->code ? 'selected' : '' }}>
                                {{ $cat->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by SPP Status -->
                <div class="md:col-span-2">
                    <label for="spp_status" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Status SPP</label>
                    <select id="spp_status" name="spp_status" class="ds-input text-sm py-2.5">
                        <option value="">-- Semua SPP --</option>
                        <option value="Lunas" {{ request('spp_status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Bayar" {{ request('spp_status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    </select>
                </div>

                <!-- Submit & Reset Button -->
                <div class="md:col-span-1 flex gap-1.5">
                    <button type="submit" aria-label="Terapkan filter pemain" title="Terapkan Filter"
                            class="w-full btn-primary text-xs py-2.5 px-3">
                        <i class="fa-solid fa-filter" aria-hidden="true"></i>
                    </button>
                    @if(request()->hasAny(['year', 'ku', 'search', 'spp_status']))
                        <a href="{{ route('admin.players.index') }}" aria-label="Reset filter" title="Reset Filter"
                           class="btn-secondary text-xs py-2.5 px-3">
                            <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>

            </div>

            <!-- Quick Year Filter Chips Bar -->
            <div class="pt-4 border-t-2 border-[#111111] flex flex-wrap items-center gap-2">
                <span class="text-xs font-mono font-bold text-[#525252] uppercase tracking-wider mr-1">Filter Instan Tahun:</span>
                <a href="{{ route('admin.players.index') }}"
                   class="min-h-[40px] px-3 py-1.5 text-xs font-mono font-bold border-2 border-[#111111] inline-flex items-center transition-colors {{ !request('year') ? 'bg-[#111111] text-[#FFFF00]' : 'bg-[#F4F4F4] text-[#111111] hover:bg-[#FFFF00]' }}">
                    Semua
                </a>
                @foreach($availableYears as $yr)
                    <a href="{{ route('admin.players.index', ['year' => $yr]) }}"
                       class="min-h-[40px] px-3 py-1.5 text-xs font-mono font-bold border-2 border-[#111111] inline-flex items-center transition-colors {{ request('year') == $yr ? 'bg-[#0000FF] text-white' : 'bg-[#F4F4F4] text-[#111111] hover:bg-[#FFFF00]' }}">
                        {{ $yr }}
                    </a>
                @endforeach
            </div>

        </form>
    </div>

    <!-- Player Data Table -->
    <div class="editorial-card p-0 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                    <tr>
                        <th class="p-4">NIS & Pemain</th>
                        <th class="p-4">Tahun Lahir & Usia</th>
                        <th class="p-4">Kelompok Umur</th>
                        <th class="p-4">Posisi</th>
                        <th class="p-4">Orang Tua / WA</th>
                        <th class="p-4">Status SPP</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($players as $player)
                        <tr class="hover:bg-[#F4F4F4] transition-colors">

                            <!-- NIS & Player Name -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#0000FF] text-white border-2 border-[#111111] font-mono font-bold flex items-center justify-center text-sm flex-shrink-0">
                                        {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.players.show', $player->id) }}" class="font-bold text-[#111111] hover:text-[#0000FF] hover:underline text-sm block leading-tight transition-colors">
                                            {{ $player->full_name }}
                                        </a>
                                        <span class="text-xs text-[#525252] font-mono">{{ $player->nis }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Birth Year & Age -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs inline-block">
                                    {{ $player->birth_year }}
                                </span>
                                <span class="text-xs font-bold text-[#111111] ml-1">({{ $player->age }} Thn)</span>
                                <span class="block text-[11px] font-mono text-[#525252] mt-0.5">{{ date('d M Y', strtotime($player->birth_date)) }}</span>
                            </td>

                            <!-- Kelompok Umur Badge -->
                            <td class="p-4">
                                <span class="badge-secondary font-mono">{{ $player->age_category_badge }}</span>
                            </td>

                            <!-- Position -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 border border-[#111111] bg-white text-[#111111] text-xs font-semibold">
                                    {{ $player->position }}
                                </span>
                            </td>

                            <!-- Parent Info -->
                            <td class="p-4">
                                <span class="block font-bold text-[#111111]">{{ $player->parent_name }}</span>
                                <span class="text-xs font-mono text-[#525252]"><i class="fa-brands fa-whatsapp text-[#166534] mr-1" aria-hidden="true"></i> {{ $player->parent_phone }}</span>
                            </td>

                            <!-- SPP Status (Derived from Current Month SppPayment Ledger) -->
                            <td class="p-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($player->current_spp_status == 'Lunas')
                                        <span class="badge-success text-xs font-mono">
                                            <i class="fa-solid fa-check mr-1" aria-hidden="true"></i> Lunas
                                        </span>
                                        <a href="{{ route('admin.players.show', $player->id) }}#spp-section"
                                           title="Lihat &amp; Catat Riwayat SPP {{ $player->full_name }}"
                                           class="min-h-[40px] px-2.5 py-1 bg-white hover:bg-[#FFFF00] text-[#111111] border border-[#111111] text-[11px] font-mono font-bold inline-flex items-center transition-colors">
                                            Riwayat
                                        </a>
                                    @else
                                        <span class="badge-danger text-xs font-mono">
                                            <i class="fa-solid fa-circle-exclamation mr-1" aria-hidden="true"></i> Belum Bayar
                                        </span>
                                        <a href="{{ route('admin.players.show', $player->id) }}#spp-section"
                                           class="min-h-[40px] px-2.5 py-1 bg-[#FFFF00] hover:bg-[#E6E600] text-[#111111] border-2 border-[#111111] text-[11px] font-bold inline-flex items-center gap-1 transition-colors">
                                            <i class="fa-solid fa-receipt text-[10px]" aria-hidden="true"></i> Bayar SPP
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.players.show', $player->id) }}"
                                       title="Lihat Rapor Radar"
                                       aria-label="Lihat rapor {{ $player->full_name }}"
                                       class="w-10 h-10 bg-white text-[#111111] hover:bg-[#0000FF] hover:text-white border-2 border-[#111111] flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-eye text-xs" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('admin.players.edit', $player->id) }}"
                                       title="Edit Data"
                                       aria-label="Edit data {{ $player->full_name }}"
                                       class="w-10 h-10 bg-white text-[#111111] hover:bg-[#FFFF00] hover:text-[#111111] border-2 border-[#111111] flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-xs" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('admin.players.destroy', $player->id) }}" method="POST" onsubmit="return confirm('Hapus data pemain {{ $player->full_name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus Pemain"
                                                aria-label="Hapus {{ $player->full_name }}"
                                                class="w-10 h-10 bg-white text-[#991B1B] hover:bg-[#FF0000] hover:text-[#000000] border-2 border-[#111111] flex items-center justify-center transition-colors cursor-pointer">
                                            <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-[#525252]">
                                Tidak ada data pemain yang cocok dengan kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t-2 border-[#111111] bg-white">
            {{ $players->links() }}
        </div>

    </div>

</div>

@endsection
