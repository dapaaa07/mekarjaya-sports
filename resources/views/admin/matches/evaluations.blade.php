@extends('layouts.admin')

@section('title', 'Penilaian Statistik Pemain - ' . $match->match_title)
@section('page-header', 'Penilaian Statistik Pemain Per Match')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Header & Match Info Card -->
    <div class="editorial-card p-6 border-l-[6px] border-l-[#0000FF] space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b-2 border-[#111111] pb-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                    <span class="bg-[#0000FF] text-white text-[11px] font-mono font-bold px-2 py-0.5 uppercase border border-[#111111]">{{ $match->match_type }}</span>
                    <span class="bg-[#FFFF00] text-[#111111] text-[11px] font-mono font-bold px-2 py-0.5 uppercase border border-[#111111]">{{ $match->target_ku }}</span>
                    <span class="bg-[#111111] text-[#FFFF00] text-[11px] font-mono font-bold px-2.5 py-0.5 border border-[#111111]">Skor: {{ $match->score_result ?? '-' }}</span>
                    <span class="bg-[#F4F4F4] text-[#111111] text-[11px] font-mono font-bold px-2 py-0.5 border border-[#111111]">Formasi {{ $match->formation ?? '4-3-3' }}</span>
                </div>
                <h2 class="font-bold text-lg sm:text-xl text-[#111111]">{{ $match->match_title }}</h2>
                <p class="text-xs text-[#525252] mt-0.5">
                    Tanggal: <strong class="font-mono text-[#111111]">{{ $match->match_date->format('d M Y') }}</strong>
                    @if($match->opponent_name) &bull; Lawan: <strong class="text-[#111111]">{{ $match->opponent_name }}</strong> @endif
                </p>
            </div>

            <a href="{{ route('admin.matches.index') }}" class="btn-secondary text-xs py-2.5 px-4 self-start md:self-auto min-h-[44px]">
                &larr; Kembali ke Match Center
            </a>
        </div>

        <div class="bg-[#FFFF00] border-2 border-[#111111] p-3.5 text-xs text-[#111111] flex items-start gap-2.5">
            <i class="fa-solid fa-circle-info text-base mt-0.5 text-[#111111]" aria-hidden="true"></i>
            <div>
                <p class="font-bold">Sistem Akumulasi Statistik Pemain</p>
                <p class="text-[11px] text-[#262626] mt-0.5">Nilai yang Anda masukkan pada pertandingan ini akan otomatis diakumulasikan (dirata-rata) ke profil performa dan rapor setiap pemain yang dinilai. Centang pemain yang bermain di laga ini untuk menyimpan nilainya.</p>
            </div>
        </div>
    </div>

    <!-- Squad Evaluation Form -->
    <form action="{{ route('admin.matches.evaluations.store', $match->id) }}" method="POST" class="space-y-6">
        @csrf

        <div class="flex items-center justify-between gap-3 bg-white p-4 border-2 border-[#111111]">
            <span class="font-bold text-xs uppercase tracking-wider text-[#111111]">
                Daftar Skuad Laga ({{ count($squad) }} Pemain Terdaftar)
            </span>
            <div class="flex items-center gap-2">
                <button type="button" onclick="toggleAllSquadCheckboxes(true)" class="text-xs font-mono font-bold text-[#0000FF] hover:underline px-2 py-1">
                    Pilih Semua
                </button>
                <span class="text-[#525252]">&middot;</span>
                <button type="button" onclick="toggleAllSquadCheckboxes(false)" class="text-xs font-mono font-bold text-[#CC0000] hover:underline px-2 py-1">
                    Batalkan Semua
                </button>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($squad as $slot)
                @php
                    $pId = (int) ($slot['player_id'] ?? 0);
                    $existing = $existingEvaluations->get($pId);
                    $playerObj = $playersById->get($pId);
                    $isStarter = ($slot['role'] ?? 'starter') === 'starter';
                    $isChecked = $existing !== null || $isStarter;
                @endphp
                <div class="editorial-card p-5 border-2 border-[#111111] bg-white space-y-4 transition-colors squad-player-card {{ $isChecked ? 'border-l-[6px] border-l-[#111111]' : 'opacity-70 bg-[#FBFBFB]' }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-3">
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox"
                                       name="evaluations[{{ $pId }}][include]"
                                       value="1"
                                       {{ $isChecked ? 'checked' : '' }}
                                       onchange="handleSquadCheckboxChange(this)"
                                       class="squad-include-cb w-5 h-5 rounded-none border-2 border-[#111111] text-[#0000FF] focus:ring-0">
                                <span class="font-bold text-sm text-[#111111]">{{ $slot['player_name'] ?? 'Pemain' }}</span>
                            </label>

                            @if($slot['nis'] ?? false)
                                <span class="text-xs font-mono text-[#525252] font-semibold">({{ $slot['nis'] }})</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 text-[11px] font-mono font-bold border border-[#111111] {{ $isStarter ? 'bg-[#111111] text-white' : 'bg-[#0000FF] text-white' }}">
                                {{ $isStarter ? 'Starting XI' : 'Cadangan' }}
                            </span>
                            <span class="px-2 py-0.5 text-[11px] font-mono font-bold border border-[#111111] bg-[#FFFF00] text-[#111111]">
                                Posisi: {{ $slot['position'] ?? 'Gelandang' }}
                            </span>
                            @if($existing)
                                <span class="px-2 py-0.5 text-[11px] font-mono font-bold border border-[#111111] bg-[#166534] text-white">
                                    Sudah Dinilai (Rata-rata: {{ $existing->average_score }})
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 6 Performance Metrics Inputs -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Passing (0-100) *</label>
                            <input type="number" min="0" max="100"
                                   name="evaluations[{{ $pId }}][passing_score]"
                                   value="{{ old("evaluations.{$pId}.passing_score", $existing->passing_score ?? 75) }}"
                                   class="ds-input font-mono font-bold text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Dribbling (0-100) *</label>
                            <input type="number" min="0" max="100"
                                   name="evaluations[{{ $pId }}][dribbling_score]"
                                   value="{{ old("evaluations.{$pId}.dribbling_score", $existing->dribbling_score ?? 75) }}"
                                   class="ds-input font-mono font-bold text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Shooting (0-100) *</label>
                            <input type="number" min="0" max="100"
                                   name="evaluations[{{ $pId }}][shooting_score]"
                                   value="{{ old("evaluations.{$pId}.shooting_score", $existing->shooting_score ?? 75) }}"
                                   class="ds-input font-mono font-bold text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Fisik (0-100) *</label>
                            <input type="number" min="0" max="100"
                                   name="evaluations[{{ $pId }}][physical_score]"
                                   value="{{ old("evaluations.{$pId}.physical_score", $existing->physical_score ?? 75) }}"
                                   class="ds-input font-mono font-bold text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Disiplin (0-100) *</label>
                            <input type="number" min="0" max="100"
                                   name="evaluations[{{ $pId }}][discipline_score]"
                                   value="{{ old("evaluations.{$pId}.discipline_score", $existing->discipline_score ?? 80) }}"
                                   class="ds-input font-mono font-bold text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Taktik (0-100) *</label>
                            <input type="number" min="0" max="100"
                                   name="evaluations[{{ $pId }}][tactical_score]"
                                   value="{{ old("evaluations.{$pId}.tactical_score", $existing->tactical_score ?? 70) }}"
                                   class="ds-input font-mono font-bold text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-[#111111] uppercase tracking-wider mb-1">Catatan Evaluasi Laga Ini (Opsional)</label>
                        <input type="text"
                               name="evaluations[{{ $pId }}][coach_notes]"
                               value="{{ old("evaluations.{$pId}.coach_notes", $existing->coach_notes ?? '') }}"
                               placeholder="Contoh: Bermain disiplin di lini tengah, transisi bertahan sangat cepat."
                               class="ds-input text-xs">
                    </div>
                </div>
            @empty
                <div class="editorial-card p-8 text-center text-[#525252]">
                    Tidak ada pemain dalam skuad pertandingan ini.
                </div>
            @endforelse
        </div>

        <!-- Sticky Submit Bar -->
        <div class="sticky bottom-4 z-20 editorial-card p-4 bg-white border-2 border-[#111111] shadow-lg flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="text-xs text-[#525252]">
                Pastikan nilai yang dimasukkan akurat sebelum menyimpan akumulasi.
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.matches.index') }}" class="btn-secondary text-xs py-2.5 px-5">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-xs py-2.5 px-6 font-bold">
                    <i class="fa-solid fa-floppy-disk mr-1.5" aria-hidden="true"></i> Simpan &amp; Akumulasikan Nilai Skuad
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    function toggleAllSquadCheckboxes(state) {
        document.querySelectorAll('.squad-include-cb').forEach(cb => {
            cb.checked = state;
            handleSquadCheckboxChange(cb);
        });
    }

    function handleSquadCheckboxChange(cb) {
        const card = cb.closest('.squad-player-card');
        if (!card) return;
        if (cb.checked) {
            card.classList.remove('opacity-70', 'bg-[#FBFBFB]');
            card.classList.add('border-l-[6px]', 'border-l-[#111111]');
        } else {
            card.classList.add('opacity-70', 'bg-[#FBFBFB]');
            card.classList.remove('border-l-[6px]', 'border-l-[#111111]');
        }
    }
</script>
@endsection
