@extends('layouts.admin')

@section('title', 'Evaluasi Performa Siswa - Mekar Jaya Sport Subang')
@section('page-header', 'Evaluasi Performa & Rapor Siswa')

@section('content')

<div class="space-y-6">

    <!-- Header Card -->
    <div class="editorial-card p-6 border-l-[6px] border-l-[#0000FF] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                <i class="fa-solid fa-sliders text-[#0000FF]" aria-hidden="true"></i> Daftar Evaluasi Performa Siswa Aktif
            </h2>
            <p class="text-xs text-[#525252] mt-0.5">Pilih siswa untuk mencatat skor evaluasi teknik, fisik, disiplin, serta catatan perkembangan pelatih.</p>
        </div>
        <span class="badge-blue font-mono self-start sm:self-center">{{ $players->total() }} Siswa Aktif</span>
    </div>

    <!-- Info Banner: Evaluated Per Match -->
    <div class="bg-[#FFFF00] border-2 border-[#111111] p-4 text-xs text-[#111111] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-info text-base mt-0.5 text-[#111111]" aria-hidden="true"></i>
            <div>
                <p class="font-bold">Statistik Pemain Terakumulasi Dari Pertandingan</p>
                <p class="text-[11px] text-[#262626] mt-0.5">Nilai statistik pemain tidak diubah langsung di halaman ini, melainkan dihitung otomatis dari akumulasi penilaian performa di setiap pertandingan resmi (Match Center).</p>
            </div>
        </div>
        <a href="{{ route('admin.matches.index') }}" class="btn-primary text-xs py-2 px-3.5 whitespace-nowrap shrink-0">
            <i class="fa-solid fa-trophy mr-1 text-xs" aria-hidden="true"></i> Buka Match Center
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.evaluations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4 items-end text-xs">
            <div class="md:col-span-5">
                <label for="eval-search" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Cari Nama / NIS</label>
                <input type="text" id="eval-search" name="search" value="{{ request('search') }}"
                       autocorrect="off" autocapitalize="off" spellcheck="false"
                       placeholder="Contoh: Fatih, SSB-MJ..."
                       class="ds-input text-sm py-2.5">
            </div>

            <div class="md:col-span-3">
                <label for="eval-year" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tahun Lahir</label>
                <select id="eval-year" name="year" class="ds-input text-sm py-2.5">
                    <option value="">-- Semua Tahun --</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="eval-ku" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kelompok Umur</label>
                <select id="eval-ku" name="ku" class="ds-input text-sm py-2.5">
                    <option value="">-- Semua KU --</option>
                    @foreach($ageCategories as $cat)
                        <option value="{{ $cat->code }}" {{ request('ku') == $cat->code ? 'selected' : '' }}>{{ $cat->code }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-1.5">
                <button type="submit" class="w-full btn-primary text-xs py-2.5 px-4">
                    <i class="fa-solid fa-filter" aria-hidden="true"></i> Filter
                </button>
                @if(request()->hasAny(['year', 'ku', 'search']))
                    <a href="{{ route('admin.evaluations.index') }}" aria-label="Reset filter evaluasi" class="btn-secondary text-xs py-2.5 px-3">
                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Players Table -->
    <div class="editorial-card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                    <tr>
                        <th class="p-4">Siswa &amp; NIS</th>
                        <th class="p-4">Kelompok Umur</th>
                        <th class="p-4">Posisi</th>
                        <th class="p-4">Pertandingan Dinilai</th>
                        <th class="p-4 text-center">Rata-rata Skor</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($players as $player)
                        @php
                            $accumulated = $player->accumulated_stats;
                            $avg = $accumulated->average_score;
                        @endphp
                        <tr class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-4">
                                <span class="font-bold text-[#111111] text-sm block">{{ $player->full_name }}</span>
                                <span class="text-xs font-mono text-[#525252]">{{ $player->nis }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs">{{ $player->birth_year }}</span>
                                <span class="badge-secondary font-mono ml-1">{{ $player->age_category_badge }}</span>
                            </td>
                            <td class="p-4 font-semibold">{{ $player->position }}</td>
                            <td class="p-4 font-mono text-xs text-[#525252]">
                                @if(($accumulated->matches_count ?? 0) > 0)
                                    <span class="font-bold text-xs text-[#111111] block">
                                        {{ $accumulated->matches_count }} Laga Dinilai
                                    </span>
                                    <span class="text-[10px] text-[#525252]">Laga Terakhir: {{ $accumulated->evaluation_date ? $accumulated->evaluation_date->format('d M Y') : '-' }}</span>
                                @else
                                    <span class="text-[11px] text-[#525252] italic">Belum Ada Laga</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($avg !== null)
                                    <span class="px-2.5 py-1 bg-[#FFFF00] text-[#111111] border border-[#111111] font-mono font-bold text-xs">
                                        {{ $avg }}
                                    </span>
                                @else
                                    <span class="text-[#525252] font-mono">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.players.show', $player->id) }}" class="btn-secondary text-xs py-2 px-3 min-h-[44px]">
                                            Profil &amp; Rapor
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-primary text-xs py-2 px-3.5 min-h-[44px]">
                                        <i class="fa-solid fa-chart-pie text-xs" aria-hidden="true"></i> Rincian &amp; Riwayat Laga
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-[#525252]">
                                Tidak ada siswa yang sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-[#111111] bg-white">
            {{ $players->links() }}
        </div>
    </div>

</div>

@endsection
