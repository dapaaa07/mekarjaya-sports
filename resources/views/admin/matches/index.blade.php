@extends('layouts.admin')

@section('title', 'Match Center & Catatan Pertandingan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Match Center Pertandingan')

@section('content')
<div class="space-y-6">

    <!-- Header Summary & Quick Action Button -->
    <div class="tile flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-lg text-[#111111] flex items-center gap-2">
                <i class="fa-solid fa-trophy text-[#ff5600]"></i> Master Catatan Pertandingan SSB
            </h2>
            <p class="text-xs text-[#626260]">Pencatatan hasil uji tanding, game internal, turnamen KU, dan pemain Man of the Match (MOTM).</p>
        </div>
        
        <button onclick="document.getElementById('modal-add-match').classList.remove('hidden')" class="btn-fin text-xs py-2 px-4 flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Pertandingan Baru
        </button>
    </div>

    <!-- Match Data Table -->
    <div class="tile overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f5f1ec] border-b border-[#d3cec6] text-[11px] font-bold text-[#626260] uppercase tracking-wider">
                        <th class="py-3 px-4">Tanggal & Jenis</th>
                        <th class="py-3 px-4">Nama Pertandingan / Opponent</th>
                        <th class="py-3 px-4 text-center">Kelompok Umur</th>
                        <th class="py-3 px-4 text-center">Skor Akhir</th>
                        <th class="py-3 px-4">Man of the Match</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ebe7e1] text-xs">
                    @forelse($matches as $m)
                        <tr class="hover:bg-[#f5f1ec]/50 transition-colors">
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-[#111111] block">{{ $m->match_date->format('d M Y') }}</span>
                                <span class="bg-[#313130] text-white text-[9px] font-mono px-1.5 py-0.5 rounded uppercase mt-0.5 inline-block">{{ $m->match_type }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-[#111111]">
                                {{ $m->match_title }}
                                @if($m->opponent_name)
                                    <span class="block text-[11px] text-[#626260] font-normal">vs {{ $m->opponent_name }}</span>
                                @endif
                                @if($m->match_notes)
                                    <span class="block text-[10px] text-[#626260] italic mt-0.5">{{ $m->match_notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="badge-secondary text-[10px]">{{ $m->target_ku }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="bg-[#111111] text-[#ff5600] font-mono font-bold text-sm px-2.5 py-1 rounded">
                                    {{ $m->score_result ?? '0 - 0' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-[#111111]">
                                @if($m->man_of_the_match)
                                    <span class="flex items-center gap-1.5 text-[#ff5600] font-bold">
                                        <i class="fa-solid fa-star text-amber-500 text-xs"></i> {{ $m->man_of_the_match }}
                                    </span>
                                @else
                                    <span class="text-[#626260] text-[10px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.matches.tactics', $m->id) }}" class="bg-[#111111] hover:bg-[#ff5600] text-white px-2.5 py-1 rounded text-[10px] font-bold transition-colors flex items-center gap-1">
                                        <i class="fa-solid fa-shirt text-[#ff5600] group-hover:text-white"></i> Formasi FM ({{ $m->formation ?? '4-3-3' }})
                                    </a>

                                    <form action="{{ route('admin.matches.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pertandingan ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1 text-xs">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#626260]">
                                Belum ada data pertandingan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-[#ebe7e1]">
            {{ $matches->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Pertandingan Baru -->
<div id="modal-add-match" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-xl border border-[#d3cec6] space-y-4">
        <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-3">
            <h3 class="font-bold text-sm text-[#111111]">Catat Pertandingan Baru</h3>
            <button onclick="document.getElementById('modal-add-match').classList.add('hidden')" class="text-[#626260] hover:text-[#111111]">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="{{ route('admin.matches.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Judul Pertandingan *</label>
                <input type="text" name="match_title" required placeholder="Contoh: Internal Game Match U-12 vs U-14" class="w-full border border-[#d3cec6] rounded px-3 py-2 focus:ring-[#ff5600] focus:border-[#ff5600]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold mb-1">Tanggal Pertandingan *</label>
                    <input type="date" name="match_date" required value="{{ date('Y-m-d') }}" class="w-full border border-[#d3cec6] rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Jenis Laga *</label>
                    <select name="match_type" required class="w-full border border-[#d3cec6] rounded px-3 py-2">
                        <option value="Internal Game">Internal Game</option>
                        <option value="Uji Tanding">Uji Tanding</option>
                        <option value="Turnamen KU">Turnamen KU</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold mb-1">Kelompok Umur *</label>
                    <select name="target_ku" required class="w-full border border-[#d3cec6] rounded px-3 py-2">
                        <option value="Semua KU">Semua KU</option>
                        <option value="U-10">U-10 (2016+)</option>
                        <option value="U-12">U-12 (2014-2015)</option>
                        <option value="U-14">U-14 (2012-2013)</option>
                        <option value="U-16">U-16 (2010-2011)</option>
                        <option value="U-18">U-18 (2008-2009)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Nama Lawan (Jika Uji Tanding)</label>
                    <input type="text" name="opponent_name" placeholder="Contoh: SSB Persikas Subang" class="w-full border border-[#d3cec6] rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold mb-1">Skor Akhir (misal: 3 - 1)</label>
                    <input type="text" name="score_result" placeholder="3 - 1" class="w-full border border-[#d3cec6] rounded px-3 py-2 font-mono">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Man of the Match (MOTM)</label>
                    <input type="text" name="man_of_the_match" placeholder="Nama Pemain Terbaik" class="w-full border border-[#d3cec6] rounded px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Catatan Evaluasi Laga</label>
                <textarea name="match_notes" rows="2" placeholder="Catatan taktik pelatih..." class="w-full border border-[#d3cec6] rounded px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-match').classList.add('hidden')" class="btn-secondary py-2 px-4">Batal</button>
                <button type="submit" class="btn-fin py-2 px-4">Simpan Pertandingan</button>
            </div>
        </form>
    </div>
</div>
@endsection
