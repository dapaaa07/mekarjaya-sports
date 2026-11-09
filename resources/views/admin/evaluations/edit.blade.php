@extends('layouts.admin')

@section('title', 'Input Score Rapor - ' . $player->full_name)
@section('page-header', 'Input Score Rapor Performa Pemain')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">
    <div class="editorial-card p-6 sm:p-8 space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
            <div>
                <h2 class="font-bold text-[#111111] text-lg">Tambah Catatan Evaluasi: {{ $player->full_name }}</h2>
                <p class="text-xs text-[#525252]">Setiap penyimpanan mencatat entri riwayat evaluasi baru untuk grafik perkembangan dan rapor.</p>
            </div>
            @php
                $backUrl = Auth::user()->isAdmin()
                    ? route('admin.players.show', $player->id)
                    : route('admin.evaluations.index');
                $backLabel = Auth::user()->isAdmin() ? 'Kembali Ke Profil' : 'Kembali Ke Daftar Evaluasi';
            @endphp
            <a href="{{ $backUrl }}" class="text-xs font-mono font-bold text-[#0000FF] hover:underline inline-flex items-center gap-1 min-h-[44px]">
                &larr; {{ $backLabel }}
            </a>
        </div>

        <form action="{{ route('admin.evaluations.update', $player->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label for="evaluation_date" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Evaluasi *</label>
                    <input type="date" id="evaluation_date" name="evaluation_date" required
                           value="{{ old('evaluation_date', now()->toDateString()) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div>
                    <label for="passing_score" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Passing / Operan (0-100) *</label>
                    <input type="number" min="0" max="100" id="passing_score" name="passing_score" required
                           value="{{ old('passing_score', $evaluation->passing_score ?? 75) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div>
                    <label for="dribbling_score" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Dribbling / Giringan (0-100) *</label>
                    <input type="number" min="0" max="100" id="dribbling_score" name="dribbling_score" required
                           value="{{ old('dribbling_score', $evaluation->dribbling_score ?? 75) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div>
                    <label for="shooting_score" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Shooting / Tendangan (0-100) *</label>
                    <input type="number" min="0" max="100" id="shooting_score" name="shooting_score" required
                           value="{{ old('shooting_score', $evaluation->shooting_score ?? 75) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div>
                    <label for="physical_score" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Fisik &amp; Stamina (0-100) *</label>
                    <input type="number" min="0" max="100" id="physical_score" name="physical_score" required
                           value="{{ old('physical_score', $evaluation->physical_score ?? 75) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div>
                    <label for="discipline_score" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kedisiplinan (0-100) *</label>
                    <input type="number" min="0" max="100" id="discipline_score" name="discipline_score" required
                           value="{{ old('discipline_score', $evaluation->discipline_score ?? 80) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div>
                    <label for="tactical_score" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Pemahaman Taktik (0-100) *</label>
                    <input type="number" min="0" max="100" id="tactical_score" name="tactical_score" required
                           value="{{ old('tactical_score', $evaluation->tactical_score ?? 70) }}"
                           class="ds-input text-sm font-mono font-bold">
                </div>

                <div class="sm:col-span-2">
                    <label for="coach_notes" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Catatan Pelatih / Rekomendasi Evaluasi</label>
                    <textarea id="coach_notes" name="coach_notes" rows="3"
                              placeholder="Contoh: Pemain memiliki visi permainan tajam. Tingkatkan lagi ketahanan stamina..."
                              class="ds-input text-sm">{{ old('coach_notes', $evaluation->coach_notes ?? '') }}</textarea>
                </div>

            </div>

            <div class="pt-5 border-t-2 border-[#111111] flex flex-wrap justify-end gap-3">
                <a href="{{ $backUrl }}" class="btn-secondary text-xs py-2.5 px-5">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-xs py-2.5 px-6 font-bold">
                    Simpan Evaluasi Baru
                </button>
            </div>

        </form>

    </div>

    @include('admin.evaluations._history_panel', [
        'evaluations' => $evaluations,
        'evaluationTrend' => $evaluationTrend,
        'chartId' => 'editProgressEvaluationChart',
    ])
</div>

@endsection
