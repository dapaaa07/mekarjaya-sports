@extends('layouts.admin')

@section('title', 'Input Score Rapor - ' . $player->full_name)
@section('page-header', 'Input Score Rapor Performa Pemain')

@section('content')

<div class="max-w-2xl mx-auto editorial-card p-8 space-y-6">
    
    <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-4">
        <div>
            <h2 class="font-bold text-[#111111] text-base">Nilai Performa: {{ $player->full_name }}</h2>
            <p class="text-xs text-[#626260]">Nilai (0 - 100) akan ditampilkan pada Diagram Radar Rapor Pemain.</p>
        </div>
        <a href="{{ route('admin.players.show', $player->id) }}" class="text-xs text-[#ff5600] font-semibold hover:underline">
            &larr; Kembali Ke Profil
        </a>
    </div>

    <form action="{{ route('admin.evaluations.update', $player->id) }}" method="POST" class="space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div>
                <label for="passing_score" class="block font-medium text-[#626260] uppercase mb-1">Passing / Operan (0-100) *</label>
                <input type="number" min="0" max="100" id="passing_score" name="passing_score" required 
                    value="{{ old('passing_score', $evaluation->passing_score ?? 75) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-mono font-bold">
            </div>

            <div>
                <label for="dribbling_score" class="block font-medium text-[#626260] uppercase mb-1">Dribbling / Giringan (0-100) *</label>
                <input type="number" min="0" max="100" id="dribbling_score" name="dribbling_score" required 
                    value="{{ old('dribbling_score', $evaluation->dribbling_score ?? 75) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-mono font-bold">
            </div>

            <div>
                <label for="shooting_score" class="block font-medium text-[#626260] uppercase mb-1">Shooting / Tendangan (0-100) *</label>
                <input type="number" min="0" max="100" id="shooting_score" name="shooting_score" required 
                    value="{{ old('shooting_score', $evaluation->shooting_score ?? 75) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-mono font-bold">
            </div>

            <div>
                <label for="physical_score" class="block font-medium text-[#626260] uppercase mb-1">Fisik & Stamina (0-100) *</label>
                <input type="number" min="0" max="100" id="physical_score" name="physical_score" required 
                    value="{{ old('physical_score', $evaluation->physical_score ?? 75) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-mono font-bold">
            </div>

            <div>
                <label for="discipline_score" class="block font-medium text-[#626260] uppercase mb-1">Kedisiplinan (0-100) *</label>
                <input type="number" min="0" max="100" id="discipline_score" name="discipline_score" required 
                    value="{{ old('discipline_score', $evaluation->discipline_score ?? 80) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-mono font-bold">
            </div>

            <div>
                <label for="tactical_score" class="block font-medium text-[#626260] uppercase mb-1">Pemahaman Taktik (0-100) *</label>
                <input type="number" min="0" max="100" id="tactical_score" name="tactical_score" required 
                    value="{{ old('tactical_score', $evaluation->tactical_score ?? 70) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-mono font-bold">
            </div>

            <div class="sm:col-span-2">
                <label for="coach_notes" class="block font-medium text-[#626260] uppercase mb-1">Catatan Pelatih / Rekomendasi Evaluasi</label>
                <textarea id="coach_notes" name="coach_notes" rows="3" 
                    placeholder="Contoh: Pemain memiliki Visi permainan sangat tajam. Tingkatkan lagi stamina..."
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">{{ old('coach_notes', $evaluation->coach_notes ?? '') }}</textarea>
            </div>

        </div>

        <div class="pt-4 border-t border-[#ebe7e1] flex justify-end gap-3">
            <a href="{{ route('admin.players.show', $player->id) }}" class="btn-secondary text-xs py-2 px-4">
                Batal
            </a>
            <button type="submit" class="btn-fin text-xs py-2 px-5">
                Simpan Score Rapor Radar
            </button>
        </div>

    </form>

</div>

@endsection
