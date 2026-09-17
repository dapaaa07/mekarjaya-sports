@extends('layouts.admin')

@section('title', 'FM Tactical Pitch - ' . $match->match_title)
@section('page-header', 'Football Manager Tactics & Lineup Builder')

@section('content')
<div x-data="tacticsManager()" class="space-y-6">

    <!-- Header Banner & Action Buttons -->
    <div class="tile flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="bg-[#111111] text-[#ff5600] font-mono text-xs px-2 py-0.5 rounded font-bold uppercase">{{ $match->match_type }}</span>
                <span class="text-xs text-[#626260] font-mono font-bold">KU: {{ $match->target_ku }}</span>
            </div>
            <h2 class="font-bold text-xl text-[#111111] tracking-tight mt-1">{{ $match->match_title }}</h2>
            <p class="text-xs text-[#626260]">
                <i class="fa-solid fa-calendar text-[#ff5600] mr-1"></i> {{ $match->match_date->format('d F Y') }}
                @if($match->opponent_name) | <strong class="text-[#111111]">vs {{ $match->opponent_name }}</strong> @endif
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.matches.index') }}" class="btn-secondary text-xs py-2 px-4">
                &larr; Kembali Ke List Match
            </a>
            <button type="button" @click="submitForm()" class="btn-fin text-xs py-2 px-5 flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Formasi & Lineup
            </button>
        </div>
    </div>

    <!-- Main FM Pitch Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Controls: Formation Selector & Squad Options -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="tile space-y-4">
                <h3 class="font-bold text-sm text-[#111111] border-b border-[#ebe7e1] pb-2.5 flex items-center justify-between">
                    <span><i class="fa-solid fa-sliders text-[#ff5600] mr-1.5"></i> Skema Formasi Taktis</span>
                    <span class="text-[10px] font-mono text-[#9c9fa5] bg-[#111111] text-white px-2 py-0.5 rounded">FM STYLE</span>
                </h3>

                <div>
                    <label class="block text-[11px] font-bold text-[#626260] uppercase mb-1">Pilih Formasi Tim *</label>
                    <select x-model="formation" @change="changeFormation()" class="w-full bg-[#f5f1ec] border border-[#d3cec6] rounded-md px-3.5 py-2.5 text-xs font-bold text-[#111111] focus:ring-[#ff5600] focus:border-[#ff5600]">
                        <option value="4-3-3">4 - 3 - 3 (Klasik Penyerang Sayap)</option>
                        <option value="4-4-2">4 - 4 - 2 (Dual Striker Offensif)</option>
                        <option value="3-5-2">3 - 5 - 2 (Wing-Back Dominasi Tengah)</option>
                        <option value="4-2-3-1">4 - 2 - 3 - 1 (Poros Ganda & Playmaker)</option>
                        <option value="3-4-3">3 - 4 - 3 (Total Football Penyerangan)</option>
                    </select>
                </div>

                <div class="p-3 bg-[#f5f1ec] rounded-md border border-[#d3cec6] text-xs space-y-1">
                    <span class="font-semibold text-[#111111] block">Petunjuk Pengaturan Lineup:</span>
                    <p class="text-[11px] text-[#626260]">Pilih nama pemain SSB pada masing-masing posisi di atas papan lapangan hijau. Susunan pemain akan tersimpan otomatis dan dapat dilihat di portal publik.</p>
                </div>
            </div>

            <!-- Available Players Quick Reference -->
            <div class="tile space-y-3">
                <h3 class="font-bold text-sm text-[#111111] border-b border-[#ebe7e1] pb-2 flex items-center justify-between">
                    <span><i class="fa-solid fa-users text-[#16A34A] mr-1.5"></i> Skuad SSB Mekar Jaya ({{ count($availablePlayers) }})</span>
                    <span class="text-[10px] font-mono text-[#16A34A] bg-[#16A34A]/10 px-2 py-0.5 rounded font-bold">AKTIF</span>
                </h3>

                <div class="max-h-72 overflow-y-auto space-y-1.5 pr-1">
                    @forelse($availablePlayers as $p)
                        <div class="p-2 rounded bg-[#f5f1ec] hover:bg-[#ebe7e1] border border-[#d3cec6] flex items-center justify-between text-xs transition-colors">
                            <div>
                                <span class="font-bold text-[#111111] block leading-tight">{{ $p->full_name }}</span>
                                <span class="text-[10px] text-[#626260]">NIS: {{ $p->nis }} | Lahir {{ $p->birth_year }}</span>
                            </div>
                            <span class="text-[10px] font-semibold bg-[#111111] text-white px-2 py-0.5 rounded">{{ $p->position }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-[#626260] text-center py-4">Tidak ada data pemain untuk KU ini.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Side: VISUAL FOOTBALL MANAGER GREEN PITCH -->
        <div class="lg:col-span-8">
            <div class="bg-[#081c15] p-4 sm:p-6 rounded-2xl border-4 border-[#1b4332] shadow-2xl relative overflow-hidden min-h-[640px] flex flex-col justify-between">

                <!-- Pitch Background Markings & Lines -->
                <div class="absolute inset-0 pointer-events-none opacity-40">
                    <!-- Outer Boundary -->
                    <div class="absolute inset-3 border-2 border-white rounded-lg"></div>
                    <!-- Center Line -->
                    <div class="absolute top-1/2 left-3 right-3 h-0.5 bg-white -translate-y-1/2"></div>
                    <!-- Center Circle -->
                    <div class="absolute top-1/2 left-1/2 w-32 h-32 border-2 border-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <!-- Penalty Area Top -->
                    <div class="absolute top-3 left-1/2 w-64 h-28 border-2 border-t-0 border-white -translate-x-1/2"></div>
                    <!-- Goal Area Top -->
                    <div class="absolute top-3 left-1/2 w-32 h-12 border-2 border-t-0 border-white -translate-x-1/2"></div>
                    <!-- Penalty Area Bottom -->
                    <div class="absolute bottom-3 left-1/2 w-64 h-28 border-2 border-b-0 border-white -translate-x-1/2"></div>
                    <!-- Goal Area Bottom -->
                    <div class="absolute bottom-3 left-1/2 w-32 h-12 border-2 border-b-0 border-white -translate-x-1/2"></div>
                </div>

                <!-- FM Pitch Header Badge -->
                <div class="relative z-10 flex items-center justify-between text-white border-b border-white/20 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-[#ff5600] fa-soccer-ball text-[#ff5600] text-lg"></i>
                        <span class="font-extrabold text-sm tracking-wider uppercase">PAPAN TAKTIK FORMASI <span class="text-[#ff5600]" x-text="formation"></span></span>
                    </div>
                    <span class="text-[10px] font-mono bg-[#ff5600] text-white px-2 py-0.5 rounded font-bold uppercase">SSB MEKAR JAYA SUBANG</span>
                </div>

                <!-- Dynamic Pitch Nodes Container -->
                <form id="tactics-form" action="{{ route('admin.matches.tactics.update', $match->id) }}" method="POST" class="relative z-10 flex-grow flex flex-col justify-between space-y-6">
                    @csrf
                    <input type="hidden" name="formation" :value="formation">

                    <!-- Positions Rows Grid -->
                    <template x-for="(row, rowIndex) in currentRows" :key="rowIndex">
                        <div class="flex items-center justify-around gap-2 my-2">
                            <template x-for="(pos, posIndex) in row" :key="pos.key">
                                <div class="flex flex-col items-center text-center group relative w-28 sm:w-32">
                                    <!-- Position Label Badge -->
                                    <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded bg-[#111111] text-[#ff5600] border border-[#ff5600]/40 mb-1 shadow-md"
                                          x-text="pos.role"></span>

                                    <!-- Circular FM Player Icon -->
                                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#ff5600] to-[#111111] border-2 border-white flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-shirt text-xs"></i>
                                    </div>

                                    <!-- Player Select Dropdown -->
                                    <select :name="'lineup[' + pos.key + ']'" 
                                            x-model="lineup[pos.key]"
                                            class="mt-1 w-full bg-[#111111]/90 text-white border border-white/30 rounded px-1.5 py-1 text-[10px] font-semibold focus:ring-1 focus:ring-[#ff5600] focus:border-[#ff5600] truncate text-center">
                                        <option value="">-- Pilih Pemain --</option>
                                        @foreach($availablePlayers as $p)
                                            <option value="{{ $p->full_name }} ({{ $p->position }})">{{ $p->full_name }} [{{ $p->position }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                            </template>
                        </div>
                    </template>
                </form>

                <!-- Pitch Footer Legend -->
                <div class="relative z-10 flex items-center justify-between text-[10px] text-white/80 border-t border-white/20 pt-3 mt-4">
                    <span>⚽ Direction of Attack: <strong class="text-[#ff5600]">Ke Atas Gawang Lawan</strong></span>
                    <span>Strategi Laga SSB Mekar Jaya Subang</span>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- Alpine.js FM Tactics Manager Script -->
<script>
    function tacticsManager() {
        const savedLineup = @json($match->lineup_json ?? []);
        const defaultFormation = "{{ $match->formation ?? '4-3-3' }}";

        const formationsLayouts = {
            '4-3-3': [
                [{ key: 'fw1', role: 'Penyerang Sayap (LW)' }, { key: 'fw2', role: 'Striker Utama (ST)' }, { key: 'fw3', role: 'Penyerang Sayap (RW)' }],
                [{ key: 'mf1', role: 'Gelandang (CM)' }, { key: 'mf2', role: 'Gelandang Serang (CAM)' }, { key: 'mf3', role: 'Gelandang (CM)' }],
                [{ key: 'df1', role: 'Bek Sayap (LB)' }, { key: 'df2', role: 'Bek Tengah (CB)' }, { key: 'df3', role: 'Bek Tengah (CB)' }, { key: 'df4', role: 'Bek Sayap (RB)' }],
                [{ key: 'gk', role: 'Kiper Utama (GK)' }]
            ],
            '4-4-2': [
                [{ key: 'fw1', role: 'Striker Kiri (ST)' }, { key: 'fw2', role: 'Striker Kanan (ST)' }],
                [{ key: 'mf1', role: 'Sayap Kiri (LM)' }, { key: 'mf2', role: 'Gelandang (CM)' }, { key: 'mf3', role: 'Gelandang (CM)' }, { key: 'mf4', role: 'Sayap Kanan (RM)' }],
                [{ key: 'df1', role: 'Bek Sayap (LB)' }, { key: 'df2', role: 'Bek Tengah (CB)' }, { key: 'df3', role: 'Bek Tengah (CB)' }, { key: 'df4', role: 'Bek Sayap (RB)' }],
                [{ key: 'gk', role: 'Kiper Utama (GK)' }]
            ],
            '3-5-2': [
                [{ key: 'fw1', role: 'Striker Depan (ST)' }, { key: 'fw2', role: 'Striker Depan (ST)' }],
                [{ key: 'mf1', role: 'Wing Back (LWB)' }, { key: 'mf2', role: 'Gelandang (CM)' }, { key: 'mf3', role: 'Playmaker (CAM)' }, { key: 'mf4', role: 'Gelandang (CM)' }, { key: 'mf5', role: 'Wing Back (RWB)' }],
                [{ key: 'df1', role: 'Bek Tengah (CB)' }, { key: 'df2', role: 'Bek Tengah (CB)' }, { key: 'df3', role: 'Bek Tengah (CB)' }],
                [{ key: 'gk', role: 'Kiper Utama (GK)' }]
            ],
            '4-2-3-1': [
                [{ key: 'fw1', role: 'Striker Tunggal (ST)' }],
                [{ key: 'am1', role: 'Sayap Kiri (LAM)' }, { key: 'am2', role: 'Playmaker (CAM)' }, { key: 'am3', role: 'Sayap Kanan (RAM)' }],
                [{ key: 'dm1', role: 'Poros Ganda (CDM)' }, { key: 'dm2', role: 'Poros Ganda (CDM)' }],
                [{ key: 'df1', role: 'Bek Sayap (LB)' }, { key: 'df2', role: 'Bek Tengah (CB)' }, { key: 'df3', role: 'Bek Tengah (CB)' }, { key: 'df4', role: 'Bek Sayap (RB)' }],
                [{ key: 'gk', role: 'Kiper Utama (GK)' }]
            ],
            '3-4-3': [
                [{ key: 'fw1', role: 'Penyerang Kiri (LW)' }, { key: 'fw2', role: 'Striker Tengah (ST)' }, { key: 'fw3', role: 'Penyerang Kanan (RW)' }],
                [{ key: 'mf1', role: 'Gelandang Kiri (LM)' }, { key: 'mf2', role: 'Gelandang (CM)' }, { key: 'mf3', role: 'Gelandang (CM)' }, { key: 'mf4', role: 'Gelandang Kanan (RM)' }],
                [{ key: 'df1', role: 'Bek Tengah (CB)' }, { key: 'df2', role: 'Bek Tengah (CB)' }, { key: 'df3', role: 'Bek Tengah (CB)' }],
                [{ key: 'gk', role: 'Kiper Utama (GK)' }]
            ]
        };

        return {
            formation: defaultFormation,
            lineup: savedLineup || {},
            currentRows: formationsLayouts[defaultFormation] || formationsLayouts['4-3-3'],

            changeFormation() {
                this.currentRows = formationsLayouts[this.formation] || formationsLayouts['4-3-3'];
            },

            submitForm() {
                document.getElementById('tactics-form').submit();
            }
        };
    }
</script>
@endsection
