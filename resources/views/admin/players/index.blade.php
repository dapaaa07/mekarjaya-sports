@extends('layouts.admin')

@section('title', 'Manajemen Pemain Per Tahun - Mekar Jaya Sport Subang')
@section('page-header', 'Manajemen Data Pemain SSB')

@section('content')

<div class="space-y-6">

    <!-- Header Control Bar (DESIGN.md Editorial Card) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 editorial-card p-6">
        <div>
            <h2 class="font-bold text-[#111111] text-base flex items-center gap-2">
                <i class="fa-solid fa-users text-[#ff5600]"></i> Master Data Siswa SSB Mekar Jaya
            </h2>
            <p class="text-xs text-[#626260]">Total {{ $players->total() }} pemain terdaftar (Berdasarkan filter aktif).</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.players.print', request()->all()) }}" target="_blank" 
               class="btn-secondary text-xs py-2 px-3.5 flex items-center gap-1.5">
                <i class="fa-solid fa-print"></i> Cetak Roster Filter Ini
            </a>
            <a href="{{ route('admin.players.create') }}" 
               class="btn-fin text-xs py-2 px-3.5 flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Pemain Baru
            </a>
        </div>
    </div>


    <!-- FILTER SYSTEM (PRIMARY SOLVED REQUIREMENT) -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.players.index') }}" method="GET" class="space-y-4">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4 items-end text-xs">
                
                <!-- Search Input -->
                <div class="md:col-span-4">
                    <label for="search" class="block font-medium text-[#626260] uppercase mb-1">Cari Nama / NIS / Panggilan</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                        placeholder="Contoh: Fatih, SSB-MJ..."
                        class="w-full px-3 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                </div>

                <!-- Filter by Birth Year (Key Feature) -->
                <div class="md:col-span-3">
                    <label for="year" class="block font-medium text-[#626260] uppercase mb-1">
                        <i class="fa-solid fa-calendar text-[#ff5600] mr-1"></i> Filter Tahun Lahir
                    </label>
                    <select id="year" name="year" class="w-full px-3 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-medium">
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
                    <label for="ku" class="block font-medium text-[#626260] uppercase mb-1">Kelompok Umur</label>
                    <select id="ku" name="ku" class="w-full px-3 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
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
                    <label for="spp_status" class="block font-medium text-[#626260] uppercase mb-1">Status SPP</label>
                    <select id="spp_status" name="spp_status" class="w-full px-3 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                        <option value="">-- Semua SPP --</option>
                        <option value="Lunas" {{ request('spp_status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Bayar" {{ request('spp_status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-1 flex gap-1">
                    <button type="submit" class="w-full btn-primary text-xs py-2 flex items-center justify-center">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    @if(request()->hasAny(['year', 'ku', 'search', 'spp_status']))
                        <a href="{{ route('admin.players.index') }}" class="btn-secondary text-xs py-2 px-3 flex items-center justify-center">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>

            </div>

            <!-- Quick Year Filter Chips Bar -->
            <div class="pt-3 border-t border-[#ebe7e1] flex flex-wrap items-center gap-1.5">
                <span class="text-[11px] font-medium text-[#626260] uppercase mr-1">Filter Instan Tahun:</span>
                <a href="{{ route('admin.players.index') }}" 
                   class="px-2.5 py-1 rounded text-xs font-medium {{ !request('year') ? 'bg-[#111111] text-white' : 'bg-[#ebe7e1] text-[#111111] hover:bg-[#d3cec6]' }}">
                    Semua
                </a>
                @foreach($availableYears as $yr)
                    <a href="{{ route('admin.players.index', ['year' => $yr]) }}" 
                       class="px-2.5 py-1 rounded text-xs font-medium transition-colors {{ request('year') == $yr ? 'bg-[#ff5600] text-white' : 'bg-[#ebe7e1] text-[#111111] hover:bg-[#d3cec6]' }}">
                        {{ $yr }}
                    </a>
                @endforeach
            </div>

        </form>
    </div>


    <!-- Player Data Table -->
    <div class="editorial-card overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#ebe7e1] text-[#111111] font-semibold uppercase border-b border-[#d3cec6]">
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
                <tbody class="divide-y divide-[#ebe7e1]">
                    @forelse($players as $player)
                        <tr class="hover:bg-[#ebe7e1]/40 transition-colors">
                            
                            <!-- NIS & Player Name -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-[#111111] text-white font-bold flex items-center justify-center text-xs flex-shrink-0">
                                        {{ strtoupper(substr($player->full_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.players.show', $player->id) }}" class="font-bold text-[#111111] hover:text-[#ff5600] text-sm block leading-tight">
                                            {{ $player->full_name }}
                                        </a>
                                        <span class="text-[11px] text-[#626260] font-mono">{{ $player->nis }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Birth Year & Age (KEY SOLVED COLUMN) -->
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded bg-[#111111] text-white font-mono font-bold text-xs inline-block">
                                    {{ $player->birth_year }}
                                </span>
                                <span class="text-xs font-medium text-[#111111] ml-1">({{ $player->age }} Thn)</span>
                                <span class="block text-[10px] text-[#626260]">{{ date('d M Y', strtotime($player->birth_date)) }}</span>
                            </td>

                            <!-- Kelompok Umur Badge -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded bg-[#ebe7e1] text-[#111111] font-semibold text-xs border border-[#d3cec6]">
                                    {{ $player->age_category_badge }}
                                </span>
                            </td>

                            <!-- Position -->
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-[#f5f1ec] text-[#111111] border border-[#d3cec6]">
                                    {{ $player->position }}
                                </span>
                            </td>

                            <!-- Parent Info -->
                            <td class="p-4">
                                <span class="block font-medium text-[#111111]">{{ $player->parent_name }}</span>
                                <span class="text-[11px] text-[#626260]"><i class="fa-brands fa-whatsapp text-[#16A34A] mr-1"></i> {{ $player->parent_phone }}</span>
                            </td>

                            <!-- SPP Badge (1-click toggle) -->
                            <td class="p-4">
                                <form action="{{ route('admin.players.toggle-spp', $player->id) }}" method="POST">
                                    @csrf
                                    @if($player->spp_status == 'Lunas')
                                        <button type="submit" title="Klik untuk ubah ke Belum Bayar" 
                                                class="px-2.5 py-1 rounded bg-[#16A34A]/10 hover:bg-[#16A34A]/20 text-[#16A34A] font-semibold border border-[#16A34A]/30 text-[11px] transition-colors">
                                            <i class="fa-solid fa-check text-[#16A34A] mr-1"></i> Lunas
                                        </button>
                                    @else
                                        <button type="submit" title="Klik untuk ubah ke Lunas" 
                                                class="px-2.5 py-1 rounded bg-[#c41c1c]/10 hover:bg-[#c41c1c]/20 text-[#c41c1c] font-semibold border border-[#c41c1c]/30 text-[11px] transition-colors">
                                            <i class="fa-solid fa-exclamation-circle text-[#c41c1c] mr-1"></i> Belum Bayar
                                        </button>
                                    @endif
                                </form>
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.players.show', $player->id) }}" 
                                       title="Lihat Rapor Radar"
                                       class="w-7 h-7 rounded bg-[#ebe7e1] text-[#111111] hover:bg-[#111111] hover:text-white flex items-center justify-center transition-colors border border-[#d3cec6]">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.players.edit', $player->id) }}" 
                                       title="Edit Data"
                                       class="w-7 h-7 rounded bg-[#ebe7e1] text-[#111111] hover:bg-[#ff5600] hover:text-white flex items-center justify-center transition-colors border border-[#d3cec6]">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.players.destroy', $player->id) }}" method="POST" onsubmit="return confirm('Hapus data pemain {{ $player->full_name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Hapus Pemain"
                                                class="w-7 h-7 rounded bg-[#ebe7e1] text-[#c41c1c] hover:bg-[#c41c1c] hover:text-white flex items-center justify-center transition-colors border border-[#d3cec6]">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-[#626260]">
                                Tidak ada data pemain yang cocok dengan kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-[#ebe7e1]">
            {{ $players->links() }}
        </div>

    </div>

</div>

@endsection
