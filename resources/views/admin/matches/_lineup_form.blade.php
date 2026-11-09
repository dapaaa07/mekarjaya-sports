@props(['players', 'match' => null, 'prefix' => 'match'])

@php
    $selectedFormation = old('formation', $match?->formation ?? '4-3-3');
    $formationTemplates = [
        '4-3-3' => ['Kiper', 'Bek', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang', 'Penyerang', 'Penyerang'],
        '4-4-2' => ['Kiper', 'Bek', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang', 'Penyerang'],
        '3-5-2' => ['Kiper', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang', 'Penyerang'],
        '4-2-3-1' => ['Kiper', 'Bek', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang'],
        '5-3-2' => ['Kiper', 'Bek', 'Bek', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang', 'Penyerang'],
    ];
    $defaultPositions = $formationTemplates[$selectedFormation] ?? $formationTemplates['4-3-3'];
    $existingLineup = is_array($match?->lineup_json) ? array_values($match->lineup_json) : [];
@endphp

<div class="space-y-4 border-t-2 border-[#111111] pt-4" data-lineup-builder="{{ $prefix }}">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
        <div>
            <label for="{{ $prefix }}_formation" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">
                Formasi Pertandingan *
            </label>
            <select id="{{ $prefix }}_formation" name="formation" required
                    class="ds-input text-sm font-mono font-bold formation-select">
                @foreach(\App\Models\MatchModel::FORMATIONS as $fmt)
                    <option value="{{ $fmt }}" {{ $selectedFormation === $fmt ? 'selected' : '' }}>{{ $fmt }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-wrap items-center justify-between sm:justify-end gap-2">
            <button type="button" onclick="autoFillLineup('{{ $prefix }}')"
                    class="btn-yellow text-xs py-2.5 px-3.5">
                <i class="fa-solid fa-wand-magic-sparkles text-xs" aria-hidden="true"></i> Rekomendasi 11 Pemain
            </button>
        </div>
    </div>

    <div class="bg-[#F4F4F4] border-2 border-[#111111] p-3 flex flex-wrap items-center justify-between gap-2 text-xs">
        <div>
            <strong class="font-mono uppercase text-[#111111] block">Susunan Starting XI (11 Pemain Inti)</strong>
            <span class="text-[11px] text-[#525252]">Wajib 11 pemain berbeda dan tepat 1 pemain di posisi Kiper.</span>
        </div>
        <div class="flex items-center gap-2 font-mono text-[11px]">
            <span id="{{ $prefix }}_unique_badge" class="badge-secondary">Unik: 0 / 11</span>
            <span id="{{ $prefix }}_kiper_badge" class="badge-secondary">Kiper: 0 / 1</span>
        </div>
    </div>

    <div class="space-y-2">
        @for($i = 0; $i < 11; $i++)
            @php
                $slotPlayer = old("lineup.{$i}.player_id", $existingLineup[$i]['player_id'] ?? '');
                $slotPos = old("lineup.{$i}.position", $existingLineup[$i]['position'] ?? $defaultPositions[$i]);
            @endphp
            <div class="grid grid-cols-12 gap-2 items-center p-2 bg-white border-2 border-[#111111]">
                <div class="col-span-2 sm:col-span-1 flex items-center justify-center">
                    <span class="w-8 h-8 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs flex items-center justify-center">
                        {{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="col-span-10 sm:col-span-7">
                    <label for="{{ $prefix }}_player_{{ $i }}" class="sr-only">Pemain Slot {{ $i + 1 }}</label>
                    <select id="{{ $prefix }}_player_{{ $i }}"
                            name="lineup[{{ $i }}][player_id]" required
                            data-player-role="{{ $slotPos }}"
                            onchange="syncLineupStatus('{{ $prefix }}')"
                            class="ds-input text-xs py-2 min-h-[44px] lineup-player-select">
                        <option value="">-- Pilih Pemain Slot #{{ $i + 1 }} --</option>
                        @foreach($players as $p)
                            <option value="{{ $p->id }}"
                                    data-orig-pos="{{ $p->position }}"
                                    {{ (string) $slotPlayer === (string) $p->id ? 'selected' : '' }}>
                                {{ $p->full_name }} ({{ $p->birth_year }} - {{ $p->position }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-4">
                    <label for="{{ $prefix }}_pos_{{ $i }}" class="sr-only">Posisi Slot {{ $i + 1 }}</label>
                    <select id="{{ $prefix }}_pos_{{ $i }}"
                            name="lineup[{{ $i }}][position]" required
                            onchange="syncLineupStatus('{{ $prefix }}')"
                            class="ds-input text-xs font-mono font-bold py-2 min-h-[44px] lineup-pos-select">
                        @foreach(\App\Models\MatchModel::LINEUP_POSITIONS as $posOpt)
                            <option value="{{ $posOpt }}" {{ $slotPos === $posOpt ? 'selected' : '' }}>{{ $posOpt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endfor
    </div>
</div>

@once
<script>
    const LINEUP_FORMATIONS = @json($formationTemplates);

    function syncLineupStatus(prefix) {
        const root = document.querySelector(`[data-lineup-builder="${prefix}"]`);
        if (!root) return;

        const playerSelects = Array.from(root.querySelectorAll('.lineup-player-select'));
        const posSelects = Array.from(root.querySelectorAll('.lineup-pos-select'));
        const selectedIds = playerSelects.map(s => s.value).filter(v => v !== '');
        const uniqueIds = new Set(selectedIds);
        const kiperCount = posSelects.filter(s => s.value === 'Kiper').length;

        const uniqueBadge = document.getElementById(`${prefix}_unique_badge`);
        const kiperBadge = document.getElementById(`${prefix}_kiper_badge`);

        if (uniqueBadge) {
            uniqueBadge.textContent = `Unik: ${uniqueIds.size} / 11`;
            uniqueBadge.className = (uniqueIds.size === 11 && selectedIds.length === 11) ? 'badge-success' : 'badge-danger';
        }
        if (kiperBadge) {
            kiperBadge.textContent = `Kiper: ${kiperCount} / 1`;
            kiperBadge.className = kiperCount === 1 ? 'badge-success' : 'badge-danger';
        }
    }

    function applyFormationPositions(prefix, formation) {
        const root = document.querySelector(`[data-lineup-builder="${prefix}"]`);
        if (!root) return;
        const posTemplate = LINEUP_FORMATIONS[formation] || LINEUP_FORMATIONS['4-3-3'];
        const posSelects = Array.from(root.querySelectorAll('.lineup-pos-select'));
        posSelects.forEach((select, idx) => {
            if (posTemplate[idx]) {
                select.value = posTemplate[idx];
            }
        });
        syncLineupStatus(prefix);
    }

    function autoFillLineup(prefix) {
        const root = document.querySelector(`[data-lineup-builder="${prefix}"]`);
        if (!root) return;
        const playerSelects = Array.from(root.querySelectorAll('.lineup-player-select'));
        if (playerSelects.length === 0) return;

        const allOptions = Array.from(playerSelects[0].options).filter(o => o.value !== '');
        if (allOptions.length < 11) {
            alert('Jumlah pemain aktif saat ini kurang dari 11 pemain.');
            return;
        }

        const kiperOpt = allOptions.find(o => (o.dataset.origPos || '').toLowerCase().includes('kiper')) || allOptions[0];
        const outfieldOpts = allOptions.filter(o => o.value !== kiperOpt.value);

        playerSelects.forEach((select, idx) => {
            if (idx === 0) {
                select.value = kiperOpt.value;
            } else if (outfieldOpts[idx - 1]) {
                select.value = outfieldOpts[idx - 1].value;
            }
        });

        const fmtSelect = document.getElementById(`${prefix}_formation`);
        if (fmtSelect) {
            applyFormationPositions(prefix, fmtSelect.value);
        } else {
            syncLineupStatus(prefix);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-lineup-builder]').forEach(root => {
            const prefix = root.getAttribute('data-lineup-builder');
            const fmtSelect = document.getElementById(`${prefix}_formation`);
            if (fmtSelect) {
                fmtSelect.addEventListener('change', () => applyFormationPositions(prefix, fmtSelect.value));
            }
            syncLineupStatus(prefix);
        });
    });
</script>
@endonce
