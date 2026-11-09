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
    $existingStarters = $match ? $match->starters : [];
    $existingSubstitutes = $match ? $match->substitutes : [];

    $oldSubstitutes = old('substitutes');
    if (is_array($oldSubstitutes)) {
        $initialSubstitutes = array_values($oldSubstitutes);
    } elseif (count($existingSubstitutes) > 0) {
        $initialSubstitutes = $existingSubstitutes;
    } else {
        $initialSubstitutes = [
            ['player_id' => '', 'position' => 'Kiper'],
            ['player_id' => '', 'position' => 'Bek'],
            ['player_id' => '', 'position' => 'Gelandang'],
        ];
    }
@endphp

<div class="space-y-5 border-t-2 border-[#111111] pt-4" data-lineup-builder="{{ $prefix }}">
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
                <i class="fa-solid fa-wand-magic-sparkles text-xs" aria-hidden="true"></i> Rekomendasi Skuad (XI + Cadangan)
            </button>
        </div>
    </div>

    <!-- Starting XI Header -->
    <div class="bg-[#F4F4F4] border-2 border-[#111111] p-3 flex flex-wrap items-center justify-between gap-2 text-xs">
        <div>
            <strong class="font-mono uppercase text-[#111111] block">Susunan Starting XI (11 Pemain Inti)</strong>
            <span class="text-[11px] text-[#525252]">Wajib 11 pemain berbeda dan tepat 1 pemain di posisi Kiper inti.</span>
        </div>
        <div class="flex flex-wrap items-center gap-2 font-mono text-[11px]">
            <span id="{{ $prefix }}_unique_badge" class="badge-secondary">Inti: 0 / 11</span>
            <span id="{{ $prefix }}_kiper_badge" class="badge-secondary">Kiper Inti: 0 / 1</span>
            <span id="{{ $prefix }}_sub_badge" class="badge-secondary">Cadangan: 0</span>
        </div>
    </div>

    <!-- Starting XI Slots (11) -->
    <div class="space-y-2">
        @for($i = 0; $i < 11; $i++)
            @php
                $slotPlayer = old("lineup.{$i}.player_id", $existingStarters[$i]['player_id'] ?? '');
                $slotPos = old("lineup.{$i}.position", $existingStarters[$i]['position'] ?? $defaultPositions[$i]);
            @endphp
            <div class="grid grid-cols-12 gap-2 items-center p-2 bg-white border-2 border-[#111111]">
                <div class="col-span-2 sm:col-span-1 flex items-center justify-center">
                    <span class="w-8 h-8 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs flex items-center justify-center">
                        {{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="col-span-10 sm:col-span-7">
                    <label for="{{ $prefix }}_player_{{ $i }}" class="sr-only">Pemain Inti Slot {{ $i + 1 }}</label>
                    <select id="{{ $prefix }}_player_{{ $i }}"
                            name="lineup[{{ $i }}][player_id]" required
                            onchange="syncLineupStatus('{{ $prefix }}')"
                            class="ds-input text-xs py-2 min-h-[44px] lineup-player-select">
                        <option value="">-- Pilih Pemain Inti #{{ $i + 1 }} --</option>
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
                    <label for="{{ $prefix }}_pos_{{ $i }}" class="sr-only">Posisi Inti Slot {{ $i + 1 }}</label>
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

    <!-- Substitutes Section -->
    <div class="border-t-2 border-[#111111] pt-4 space-y-3">
        <div class="bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] p-3 flex flex-wrap items-center justify-between gap-2 text-xs">
            <div>
                <strong class="font-mono uppercase text-[#111111] block">Daftar Pemain Cadangan (Substitutes)</strong>
                <span class="text-[11px] text-[#525252]">Opsional, dapat ditambah hingga 15 pemain dan harus berbeda dari Starting XI.</span>
            </div>
            <button type="button" onclick="addSubstituteRow('{{ $prefix }}')"
                    class="btn-blue text-xs py-2 px-3 min-h-[44px]">
                <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Tambah Cadangan
            </button>
        </div>

        <div id="{{ $prefix }}_subs_container" class="space-y-2" data-next-sub-index="{{ count($initialSubstitutes) }}">
            @foreach($initialSubstitutes as $sIdx => $subRow)
                @php
                    $subPlayer = is_array($subRow) ? ($subRow['player_id'] ?? '') : '';
                    $subPos = is_array($subRow) ? ($subRow['position'] ?? 'Gelandang') : 'Gelandang';
                @endphp
                <div class="grid grid-cols-12 gap-2 items-center p-2 bg-white border-2 border-[#111111] sub-row">
                    <div class="col-span-2 sm:col-span-1 flex items-center justify-center">
                        <span class="w-8 h-8 bg-[#0000FF] text-white font-mono font-bold text-xs flex items-center justify-center sub-slot-badge">
                            C{{ $loop->iteration }}
                        </span>
                    </div>
                    <div class="col-span-10 sm:col-span-6">
                        <label for="{{ $prefix }}_sub_player_{{ $sIdx }}" class="sr-only">Pemain Cadangan {{ $loop->iteration }}</label>
                        <select id="{{ $prefix }}_sub_player_{{ $sIdx }}"
                                name="substitutes[{{ $sIdx }}][player_id]"
                                onchange="syncLineupStatus('{{ $prefix }}')"
                                class="ds-input text-xs py-2 min-h-[44px] sub-player-select">
                            <option value="">-- Pilih Pemain Cadangan (Opsional) --</option>
                            @foreach($players as $p)
                                <option value="{{ $p->id }}"
                                        data-orig-pos="{{ $p->position }}"
                                        {{ (string) $subPlayer === (string) $p->id ? 'selected' : '' }}>
                                    {{ $p->full_name }} ({{ $p->birth_year }} - {{ $p->position }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-9 sm:col-span-4">
                        <label for="{{ $prefix }}_sub_pos_{{ $sIdx }}" class="sr-only">Posisi Cadangan {{ $loop->iteration }}</label>
                        <select id="{{ $prefix }}_sub_pos_{{ $sIdx }}"
                                name="substitutes[{{ $sIdx }}][position]"
                                onchange="syncLineupStatus('{{ $prefix }}')"
                                class="ds-input text-xs font-mono font-bold py-2 min-h-[44px] sub-pos-select">
                            @foreach(\App\Models\MatchModel::LINEUP_POSITIONS as $posOpt)
                                <option value="{{ $posOpt }}" {{ $subPos === $posOpt ? 'selected' : '' }}>{{ $posOpt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3 sm:col-span-1 flex justify-end">
                        <button type="button" onclick="removeSubstituteRow(this, '{{ $prefix }}')"
                                aria-label="Hapus slot cadangan"
                                class="w-11 h-11 bg-white hover:bg-[#FF0000] hover:text-[#000000] text-[#991B1B] border-2 border-[#111111] flex items-center justify-center cursor-pointer transition-colors">
                            <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Template row for dynamic JS addition -->
        <template id="{{ $prefix }}_sub_template">
            <div class="grid grid-cols-12 gap-2 items-center p-2 bg-white border-2 border-[#111111] sub-row">
                <div class="col-span-2 sm:col-span-1 flex items-center justify-center">
                    <span class="w-8 h-8 bg-[#0000FF] text-white font-mono font-bold text-xs flex items-center justify-center sub-slot-badge">
                        C#
                    </span>
                </div>
                <div class="col-span-10 sm:col-span-6">
                    <select name="substitutes[__IDX__][player_id]"
                            onchange="syncLineupStatus('{{ $prefix }}')"
                            class="ds-input text-xs py-2 min-h-[44px] sub-player-select">
                        <option value="">-- Pilih Pemain Cadangan (Opsional) --</option>
                        @foreach($players as $p)
                            <option value="{{ $p->id }}" data-orig-pos="{{ $p->position }}">
                                {{ $p->full_name }} ({{ $p->birth_year }} - {{ $p->position }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-9 sm:col-span-4">
                    <select name="substitutes[__IDX__][position]"
                            onchange="syncLineupStatus('{{ $prefix }}')"
                            class="ds-input text-xs font-mono font-bold py-2 min-h-[44px] sub-pos-select">
                        @foreach(\App\Models\MatchModel::LINEUP_POSITIONS as $posOpt)
                            <option value="{{ $posOpt }}" {{ $posOpt === 'Gelandang' ? 'selected' : '' }}>{{ $posOpt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3 sm:col-span-1 flex justify-end">
                    <button type="button" onclick="removeSubstituteRow(this, '{{ $prefix }}')"
                            aria-label="Hapus slot cadangan"
                            class="w-11 h-11 bg-white hover:bg-[#FF0000] hover:text-[#000000] text-[#991B1B] border-2 border-[#111111] flex items-center justify-center cursor-pointer transition-colors">
                        <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

@once
<script>
    const LINEUP_FORMATIONS = @json($formationTemplates);

    function mapPlayerOrigPosToRole(origPos) {
        const lower = (origPos || '').toLowerCase();
        if (lower.includes('kiper')) return 'Kiper';
        if (lower.includes('bek')) return 'Bek';
        if (lower.includes('striker') || lower.includes('penyerang')) return 'Penyerang';
        return 'Gelandang';
    }

    function renumberSubstituteBadges(prefix) {
        const container = document.getElementById(`${prefix}_subs_container`);
        if (!container) return;
        const badges = container.querySelectorAll('.sub-slot-badge');
        badges.forEach((badge, idx) => {
            badge.textContent = `C${idx + 1}`;
        });
    }

    function addSubstituteRow(prefix) {
        const container = document.getElementById(`${prefix}_subs_container`);
        const tmpl = document.getElementById(`${prefix}_sub_template`);
        if (!container || !tmpl) return;

        const currentRows = container.querySelectorAll('.sub-row').length;
        if (currentRows >= 15) {
            alert('Maksimal 15 pemain cadangan dapat ditambahkan.');
            return;
        }

        const nextIdx = parseInt(container.dataset.nextSubIndex || String(currentRows), 10);
        container.dataset.nextSubIndex = String(nextIdx + 1);

        const html = tmpl.innerHTML.replace(/__IDX__/g, String(nextIdx));
        container.insertAdjacentHTML('beforeend', html);
        renumberSubstituteBadges(prefix);
        syncLineupStatus(prefix);
    }

    function removeSubstituteRow(button, prefix) {
        const row = button.closest('.sub-row');
        if (row) {
            row.remove();
            renumberSubstituteBadges(prefix);
            syncLineupStatus(prefix);
        }
    }

    function syncLineupStatus(prefix) {
        const root = document.querySelector(`[data-lineup-builder="${prefix}"]`);
        if (!root) return;

        const starterSelects = Array.from(root.querySelectorAll('.lineup-player-select'));
        const posSelects = Array.from(root.querySelectorAll('.lineup-pos-select'));
        const starterIds = starterSelects.map(s => s.value).filter(v => v !== '');
        const uniqueStarterIds = new Set(starterIds);
        const kiperCount = posSelects.filter(s => s.value === 'Kiper').length;

        const subSelects = Array.from(root.querySelectorAll('.sub-player-select'));
        const subIds = subSelects.map(s => s.value).filter(v => v !== '');
        const uniqueSubIds = new Set(subIds);
        const hasCrossDuplicate = subIds.some(id => uniqueStarterIds.has(id)) || uniqueSubIds.size !== subIds.length;

        const uniqueBadge = document.getElementById(`${prefix}_unique_badge`);
        const kiperBadge = document.getElementById(`${prefix}_kiper_badge`);
        const subBadge = document.getElementById(`${prefix}_sub_badge`);

        if (uniqueBadge) {
            uniqueBadge.textContent = `Inti: ${uniqueStarterIds.size} / 11`;
            uniqueBadge.className = (uniqueStarterIds.size === 11 && starterIds.length === 11) ? 'badge-success' : 'badge-danger';
        }
        if (kiperBadge) {
            kiperBadge.textContent = `Kiper Inti: ${kiperCount} / 1`;
            kiperBadge.className = kiperCount === 1 ? 'badge-success' : 'badge-danger';
        }
        if (subBadge) {
            if (hasCrossDuplicate) {
                subBadge.textContent = `Cadangan: ${subIds.length} (Duplikat!)`;
                subBadge.className = 'badge-danger';
            } else {
                subBadge.textContent = `Cadangan: ${subIds.length}`;
                subBadge.className = subIds.length > 0 ? 'badge-primary' : 'badge-secondary';
            }
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
        const starterSelects = Array.from(root.querySelectorAll('.lineup-player-select'));
        if (starterSelects.length === 0) return;

        const allOptions = Array.from(starterSelects[0].options).filter(o => o.value !== '');
        if (allOptions.length < 11) {
            alert('Jumlah pemain aktif saat ini kurang dari 11 pemain.');
            return;
        }

        const kiperOpt = allOptions.find(o => (o.dataset.origPos || '').toLowerCase().includes('kiper')) || allOptions[0];
        const remainingOpts = allOptions.filter(o => o.value !== kiperOpt.value);

        const chosenStarterIds = new Set();
        starterSelects.forEach((select, idx) => {
            if (idx === 0) {
                select.value = kiperOpt.value;
                chosenStarterIds.add(kiperOpt.value);
            } else if (remainingOpts[idx - 1]) {
                select.value = remainingOpts[idx - 1].value;
                chosenStarterIds.add(remainingOpts[idx - 1].value);
            }
        });

        // Fill substitute slots with remaining unused active players
        const benchPool = remainingOpts.slice(10);
        const container = document.getElementById(`${prefix}_subs_container`);
        if (container) {
            const desiredBenchCount = Math.min(5, benchPool.length);
            while (container.querySelectorAll('.sub-row').length < desiredBenchCount) {
                addSubstituteRow(prefix);
            }
            const subRows = Array.from(container.querySelectorAll('.sub-row'));
            subRows.forEach((row, idx) => {
                const pSel = row.querySelector('.sub-player-select');
                const posSel = row.querySelector('.sub-pos-select');
                const benchOpt = benchPool[idx];
                if (pSel) {
                    pSel.value = benchOpt ? benchOpt.value : '';
                }
                if (posSel && benchOpt) {
                    posSel.value = mapPlayerOrigPosToRole(benchOpt.dataset.origPos || '');
                }
            });
        }

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
            renumberSubstituteBadges(prefix);
            syncLineupStatus(prefix);
        });
    });
</script>
@endonce
