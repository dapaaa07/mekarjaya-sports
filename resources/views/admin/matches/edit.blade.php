@extends('layouts.admin')

@section('title', 'Edit Pertandingan & Lineup - Mekar Jaya Sport Subang')
@section('page-header', 'Edit Pertandingan & Susunan Lineup')

@section('content')

<div class="max-w-4xl mx-auto editorial-card p-6 sm:p-8 space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
        <div>
            <h2 class="font-bold text-[#111111] text-lg">Edit Laga: {{ $match->match_title }}</h2>
            <p class="text-xs text-[#525252]">Perbarui hasil laga, formasi, dan susunan 11 pemain inti (Starting XI).</p>
        </div>
        <a href="{{ route('admin.matches.index') }}" class="text-xs font-mono font-bold text-[#0000FF] hover:underline inline-flex items-center gap-1 min-h-[44px]">
            &larr; Kembali Ke Match Center
        </a>
    </div>

    <form action="{{ route('admin.matches.update', $match->id) }}" method="POST" class="space-y-5 text-xs">
        @csrf
        @method('PUT')

        <div>
            <label for="edit_match_title" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Judul Pertandingan *</label>
            <input type="text" id="edit_match_title" name="match_title" required value="{{ old('match_title', $match->match_title) }}" class="ds-input text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="edit_match_date" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Pertandingan *</label>
                <input type="date" id="edit_match_date" name="match_date" required value="{{ old('match_date', $match->match_date->format('Y-m-d')) }}" class="ds-input text-sm font-mono">
            </div>
            <div>
                <label for="edit_match_type" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Jenis Laga *</label>
                <select id="edit_match_type" name="match_type" required class="ds-input text-sm">
                    @foreach(['Internal Game', 'Uji Tanding', 'Turnamen KU'] as $typeOpt)
                        <option value="{{ $typeOpt }}" {{ old('match_type', $match->match_type) === $typeOpt ? 'selected' : '' }}>{{ $typeOpt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="edit_target_ku" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kelompok Umur *</label>
                <select id="edit_target_ku" name="target_ku" required class="ds-input text-sm">
                    @foreach(['Semua KU', 'U-10', 'U-12', 'U-14', 'U-16', 'U-18'] as $kuOpt)
                        <option value="{{ $kuOpt }}" {{ old('target_ku', $match->target_ku) === $kuOpt ? 'selected' : '' }}>{{ $kuOpt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="edit_opponent_name" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Lawan</label>
                <input type="text" id="edit_opponent_name" name="opponent_name" value="{{ old('opponent_name', $match->opponent_name) }}" class="ds-input text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="edit_score_result" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Skor Akhir (3 - 1)</label>
                <input type="text" id="edit_score_result" name="score_result" value="{{ old('score_result', $match->score_result) }}" class="ds-input text-sm font-mono">
            </div>
            <div>
                <label for="edit_man_of_the_match" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Man of the Match (MOTM)</label>
                <input type="text" id="edit_man_of_the_match" name="man_of_the_match" value="{{ old('man_of_the_match', $match->man_of_the_match) }}" class="ds-input text-sm">
            </div>
        </div>

        <div>
            <label for="edit_match_notes" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Catatan Evaluasi Laga</label>
            <textarea id="edit_match_notes" name="match_notes" rows="2" class="ds-input text-sm">{{ old('match_notes', $match->match_notes) }}</textarea>
        </div>

        @include('admin.matches._lineup_form', [
            'players' => $players,
            'match' => $match,
            'prefix' => 'edit_match',
        ])

        <div class="pt-5 border-t-2 border-[#111111] flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.matches.index') }}" class="btn-secondary text-xs py-2.5 px-5">
                Batal
            </a>
            <button type="submit" class="btn-primary text-xs py-2.5 px-6 font-bold">
                Simpan Perubahan &amp; Lineup
            </button>
        </div>
    </form>

</div>

@endsection
