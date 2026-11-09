@extends('layouts.admin')

@section('title', 'Match Center & Catatan Pertandingan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Match Center Pertandingan')

@section('content')
<div class="space-y-6">

    <!-- Header Summary & Quick Action Button -->
    <div class="editorial-card p-6 border-l-[6px] border-l-[#0000FF] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-base sm:text-lg text-[#111111] flex items-center gap-2">
                <i class="fa-solid fa-trophy text-[#0000FF]" aria-hidden="true"></i> Master Catatan Pertandingan SSB
            </h2>
            <p class="text-xs text-[#525252] mt-0.5">Pencatatan hasil uji tanding, game internal, turnamen KU, dan pemain Man of the Match (MOTM).</p>
        </div>

        <button type="button" onclick="openAddMatchModal()" class="btn-primary text-xs py-2.5 px-4">
            <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Tambah Pertandingan Baru
        </button>
    </div>

    <!-- Match Data Table -->
    <div class="editorial-card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-[#111111]">
                <thead>
                    <tr class="bg-[#111111] text-white text-[11px] font-mono font-bold uppercase tracking-wider">
                        <th class="py-4 px-4">Tanggal &amp; Jenis</th>
                        <th class="py-4 px-4">Nama Pertandingan, Formasi &amp; Lineup</th>
                        <th class="py-4 px-4 text-center">Kelompok Umur</th>
                        <th class="py-4 px-4 text-center">Skor Akhir</th>
                        <th class="py-4 px-4">Man of the Match</th>
                        <th class="py-4 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($matches as $m)
                        @php
                            $startersList = $m->starters;
                            $subsList = $m->substitutes;
                            $totalSquad = count($startersList) + count($subsList);
                        @endphp
                        <tr class="hover:bg-[#F4F4F4] transition-colors align-top">
                            <td class="py-3.5 px-4">
                                <span class="font-bold font-mono text-[#111111] block">{{ $m->match_date->format('d M Y') }}</span>
                                <span class="bg-[#0000FF] text-white text-[10px] font-mono font-bold px-2 py-0.5 uppercase mt-1 inline-block border border-[#111111]">{{ $m->match_type }}</span>
                                <span class="bg-[#FFFF00] text-[#111111] text-[10px] font-mono font-bold px-2 py-0.5 uppercase mt-1 ml-1 inline-block border border-[#111111]">
                                    Formasi {{ $m->formation ?? '4-3-3' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-[#111111]">
                                {{ $m->match_title }}
                                @if($m->opponent_name)
                                    <span class="block text-xs text-[#525252] font-normal mt-0.5">vs {{ $m->opponent_name }}</span>
                                @endif
                                @if($m->match_notes)
                                    <span class="block text-[11px] text-[#525252] font-normal mt-0.5">{{ $m->match_notes }}</span>
                                @endif

                                @if($totalSquad > 0)
                                    <details class="mt-2.5 border-2 border-[#111111] bg-[#F4F4F4]">
                                        <summary class="cursor-pointer px-3 py-2 text-[11px] font-mono font-bold text-[#111111] hover:bg-[#FFFF00] transition-colors select-none">
                                            Lihat Skuad Laga ({{ count($startersList) }} Inti{{ count($subsList) > 0 ? ' + ' . count($subsList) . ' Cadangan' : '' }} &middot; {{ $m->formation ?? '4-3-3' }})
                                        </summary>
                                        <div class="p-3 bg-white border-t-2 border-[#111111] space-y-3 text-[11px]">
                                            <div>
                                                <div class="text-[10px] font-mono font-bold uppercase text-[#525252] mb-1.5">
                                                    Starting XI ({{ count($startersList) }} Pemain Inti)
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                                                    @foreach($startersList as $slot)
                                                        <div class="flex items-center justify-between gap-2 px-2 py-1.5 bg-[#F4F4F4] border border-[#111111]">
                                                            <span class="font-medium text-[#111111] truncate">
                                                                <strong class="font-mono text-[#525252] mr-1">{{ str_pad((string) ($slot['slot'] ?? $loop->iteration), 2, '0', STR_PAD_LEFT) }}.</strong>
                                                                {{ $slot['player_name'] ?? '-' }}
                                                            </span>
                                                            <span class="px-1.5 py-0.5 font-mono font-bold text-[10px] shrink-0 border border-[#111111] {{ ($slot['position'] ?? '') === 'Kiper' ? 'bg-[#FFFF00] text-[#111111]' : 'bg-[#111111] text-white' }}">
                                                                {{ $slot['position'] ?? '-' }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @if(count($subsList) > 0)
                                                <div class="pt-2.5 border-t-2 border-[#111111]">
                                                    <div class="text-[10px] font-mono font-bold uppercase text-[#0000FF] mb-1.5">
                                                        Pemain Cadangan ({{ count($subsList) }} Pemain)
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                                                        @foreach($subsList as $subSlot)
                                                            <div class="flex items-center justify-between gap-2 px-2 py-1.5 bg-white border border-[#111111]">
                                                                <span class="font-medium text-[#111111] truncate">
                                                                    <strong class="font-mono text-[#0000FF] mr-1">C{{ $loop->iteration }}.</strong>
                                                                    {{ $subSlot['player_name'] ?? '-' }}
                                                                </span>
                                                                <span class="px-1.5 py-0.5 font-mono font-bold text-[10px] shrink-0 border border-[#111111] {{ ($subSlot['position'] ?? '') === 'Kiper' ? 'bg-[#FFFF00] text-[#111111]' : 'bg-[#0000FF] text-white' }}">
                                                                    {{ $subSlot['position'] ?? '-' }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </details>
                                @else
                                    <span class="inline-block mt-2 text-[11px] font-mono text-[#525252]">Lineup belum diisi</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <span class="badge-secondary font-mono whitespace-nowrap">{{ $m->target_ku }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <span class="inline-block whitespace-nowrap bg-[#111111] text-[#FFFF00] font-mono font-bold text-sm px-3 py-1 border border-[#111111]">
                                    {{ $m->score_result ?? '0 - 0' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-[#111111]">
                                @if($m->man_of_the_match)
                                    <span class="inline-flex items-center gap-1.5 bg-[#FFFF00] border border-[#111111] px-2.5 py-0.5 text-xs font-bold">
                                        <i class="fa-solid fa-star text-[#111111] text-xs" aria-hidden="true"></i> {{ $m->man_of_the_match }}
                                    </span>
                                @else
                                    <span class="text-[#525252] font-mono">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.matches.edit', $m->id) }}"
                                       title="Edit Pertandingan &amp; Lineup"
                                       aria-label="Edit pertandingan {{ $m->match_title }}"
                                       class="w-11 h-11 bg-white text-[#111111] hover:bg-[#FFFF00] border-2 border-[#111111] flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-xs" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('admin.matches.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pertandingan ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Hapus pertandingan {{ $m->match_title }}"
                                                class="w-11 h-11 bg-white text-[#991B1B] hover:bg-[#FF0000] hover:text-[#000000] border-2 border-[#111111] flex items-center justify-center transition-colors cursor-pointer" title="Hapus Pertandingan">
                                            <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-[#525252]">
                                Belum ada data pertandingan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-[#111111] bg-white">
            {{ $matches->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Pertandingan Baru (De Stijl Sharp 0px Modal + Starting XI Builder) -->
<div id="modal-add-match" role="dialog" aria-modal="true" aria-labelledby="modal-add-match-title"
     class="fixed inset-0 bg-[#111111]/75 z-[300] flex items-center justify-center hidden p-4 overscroll-contain">
    <div id="modal-add-match-box" class="bg-white max-w-3xl w-full max-h-[92dvh] flex flex-col border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden">
        <!-- Mondrian ribbon -->
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#111111] shrink-0" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="px-6 py-4 flex items-center justify-between border-b-2 border-[#111111] shrink-0 bg-white">
            <h3 id="modal-add-match-title" class="font-bold text-base text-[#111111]">Catat Pertandingan &amp; Lineup Baru</h3>
            <button type="button" onclick="closeAddMatchModal()" aria-label="Tutup dialog"
                    class="w-11 h-11 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] flex items-center justify-center cursor-pointer">
                <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
            </button>
        </div>

        <form action="{{ route('admin.matches.store') }}" method="POST" class="p-6 overflow-y-auto overscroll-contain space-y-4 text-xs flex-1">
            @csrf

            @if($errors->any())
                <div class="bg-[#FEE2E2] border-2 border-[#111111] border-l-[6px] border-l-[#CC0000] p-3 text-xs text-[#991B1B] font-bold">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="add_match_title" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Judul Pertandingan *</label>
                <input id="add_match_title" type="text" name="match_title" required value="{{ old('match_title') }}" placeholder="Contoh: Internal Game Match U-12 vs U-14" class="ds-input text-sm py-2.5">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="add_match_date" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Pertandingan *</label>
                    <input id="add_match_date" type="date" name="match_date" required value="{{ old('match_date', date('Y-m-d')) }}" class="ds-input text-sm py-2.5">
                </div>
                <div>
                    <label for="add_match_type" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Jenis Laga *</label>
                    <select id="add_match_type" name="match_type" required class="ds-input text-sm py-2.5">
                        @foreach(['Internal Game', 'Uji Tanding', 'Turnamen KU'] as $typeOpt)
                            <option value="{{ $typeOpt }}" {{ old('match_type', 'Internal Game') === $typeOpt ? 'selected' : '' }}>{{ $typeOpt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="add_target_ku" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kelompok Umur *</label>
                    <select id="add_target_ku" name="target_ku" required class="ds-input text-sm py-2.5">
                        @foreach(['Semua KU', 'U-10', 'U-12', 'U-14', 'U-16', 'U-18'] as $kuOpt)
                            <option value="{{ $kuOpt }}" {{ old('target_ku', 'Semua KU') === $kuOpt ? 'selected' : '' }}>{{ $kuOpt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="add_opponent_name" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Lawan</label>
                    <input id="add_opponent_name" type="text" name="opponent_name" value="{{ old('opponent_name') }}" placeholder="Contoh: SSB Persikas Subang" class="ds-input text-sm py-2.5">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="add_score_result" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Skor Akhir (3 - 1)</label>
                    <input id="add_score_result" type="text" name="score_result" value="{{ old('score_result') }}" placeholder="3 - 1" class="ds-input text-sm py-2.5 font-mono">
                </div>
                <div>
                    <label for="add_man_of_the_match" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Man of the Match (MOTM)</label>
                    <input id="add_man_of_the_match" type="text" name="man_of_the_match" value="{{ old('man_of_the_match') }}" placeholder="Nama Pemain Terbaik" class="ds-input text-sm py-2.5">
                </div>
            </div>

            <div>
                <label for="add_match_notes" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Catatan Evaluasi Laga</label>
                <textarea id="add_match_notes" name="match_notes" rows="2" placeholder="Catatan taktik pelatih..." class="ds-input text-sm py-2.5">{{ old('match_notes') }}</textarea>
            </div>

            @include('admin.matches._lineup_form', [
                'players' => $players,
                'match' => null,
                'prefix' => 'add_match',
            ])

            <div class="flex justify-end gap-2.5 pt-4 border-t-2 border-[#111111]">
                <button type="button" onclick="closeAddMatchModal()" class="btn-secondary text-xs py-2.5 px-4">Batal</button>
                <button type="submit" class="btn-primary text-xs py-2.5 px-5 font-bold">Simpan Pertandingan &amp; Lineup</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddMatchModal() {
        const m = document.getElementById('modal-add-match');
        if (!m) return;
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        const firstInput = document.getElementById('add_match_title');
        if (firstInput) firstInput.focus();
    }
    function closeAddMatchModal() {
        const m = document.getElementById('modal-add-match');
        if (!m) return;
        m.classList.add('hidden');
        document.body.style.overflow = '';
    }
    document.getElementById('modal-add-match')?.addEventListener('click', function(e) {
        if (e.target === this) closeAddMatchModal();
    });
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAddMatchModal();
    });
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', openAddMatchModal);
    @endif
</script>
@endsection
