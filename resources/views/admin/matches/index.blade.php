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
                        <th class="py-4 px-4">Nama Pertandingan / Opponent</th>
                        <th class="py-4 px-4 text-center">Kelompok Umur</th>
                        <th class="py-4 px-4 text-center">Skor Akhir</th>
                        <th class="py-4 px-4">Man of the Match</th>
                        <th class="py-4 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($matches as $m)
                        <tr class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="py-3.5 px-4">
                                <span class="font-bold font-mono text-[#111111] block">{{ $m->match_date->format('d M Y') }}</span>
                                <span class="bg-[#0000FF] text-white text-[10px] font-mono font-bold px-2 py-0.5 uppercase mt-1 inline-block border border-[#111111]">{{ $m->match_type }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-[#111111]">
                                {{ $m->match_title }}
                                @if($m->opponent_name)
                                    <span class="block text-xs text-[#525252] font-normal mt-0.5">vs {{ $m->opponent_name }}</span>
                                @endif
                                @if($m->match_notes)
                                    <span class="block text-[11px] text-[#525252] font-normal mt-0.5">{{ $m->match_notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="badge-secondary font-mono">{{ $m->target_ku }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="bg-[#111111] text-[#FFFF00] font-mono font-bold text-sm px-3 py-1 border border-[#111111]">
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
                                    <form action="{{ route('admin.matches.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pertandingan ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Hapus pertandingan {{ $m->match_title }}"
                                                class="w-10 h-10 bg-white text-[#991B1B] hover:bg-[#FF0000] hover:text-[#000000] border-2 border-[#111111] flex items-center justify-center transition-colors cursor-pointer" title="Hapus Pertandingan">
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

<!-- Modal Tambah Pertandingan Baru (De Stijl Sharp 0px Modal) -->
<div id="modal-add-match" role="dialog" aria-modal="true" aria-labelledby="modal-add-match-title"
     class="fixed inset-0 bg-[#111111]/75 z-[300] flex items-center justify-center hidden p-4">
    <div id="modal-add-match-box" class="bg-white max-w-md w-full border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden">
        <!-- Mondrian ribbon -->
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#111111]" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between border-b-2 border-[#111111] pb-3">
                <h3 id="modal-add-match-title" class="font-bold text-base text-[#111111]">Catat Pertandingan Baru</h3>
                <button type="button" onclick="closeAddMatchModal()" aria-label="Tutup dialog"
                        class="w-10 h-10 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
                </button>
            </div>

            <form action="{{ route('admin.matches.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Judul Pertandingan *</label>
                    <input type="text" name="match_title" required placeholder="Contoh: Internal Game Match U-12 vs U-14" class="ds-input text-sm py-2.5">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Pertandingan *</label>
                        <input type="date" name="match_date" required value="{{ date('Y-m-d') }}" class="ds-input text-sm py-2.5">
                    </div>
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Jenis Laga *</label>
                        <select name="match_type" required class="ds-input text-sm py-2.5">
                            <option value="Internal Game">Internal Game</option>
                            <option value="Uji Tanding">Uji Tanding</option>
                            <option value="Turnamen KU">Turnamen KU</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kelompok Umur *</label>
                        <select name="target_ku" required class="ds-input text-sm py-2.5">
                            <option value="Semua KU">Semua KU</option>
                            <option value="U-10">U-10 (2016+)</option>
                            <option value="U-12">U-12 (2014-2015)</option>
                            <option value="U-14">U-14 (2012-2013)</option>
                            <option value="U-16">U-16 (2010-2011)</option>
                            <option value="U-18">U-18 (2008-2009)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Lawan</label>
                        <input type="text" name="opponent_name" placeholder="Contoh: SSB Persikas Subang" class="ds-input text-sm py-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Skor Akhir (3 - 1)</label>
                        <input type="text" name="score_result" placeholder="3 - 1" class="ds-input text-sm py-2.5 font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Man of the Match (MOTM)</label>
                        <input type="text" name="man_of_the_match" placeholder="Nama Pemain Terbaik" class="ds-input text-sm py-2.5">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Catatan Evaluasi Laga</label>
                    <textarea name="match_notes" rows="2" placeholder="Catatan taktik pelatih..." class="ds-input text-sm py-2.5"></textarea>
                </div>

                <div class="flex justify-end gap-2.5 pt-3 border-t-2 border-[#111111]">
                    <button type="button" onclick="closeAddMatchModal()" class="btn-secondary text-xs py-2.5 px-4">Batal</button>
                    <button type="submit" class="btn-primary text-xs py-2.5 px-5 font-bold">Simpan Pertandingan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddMatchModal() {
        const m = document.getElementById('modal-add-match');
        if (m) m.classList.remove('hidden');
    }
    function closeAddMatchModal() {
        const m = document.getElementById('modal-add-match');
        if (m) m.classList.add('hidden');
    }
    document.getElementById('modal-add-match')?.addEventListener('click', function(e) {
        if (e.target === this) closeAddMatchModal();
    });
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAddMatchModal();
    });
</script>
@endsection
