@extends('layouts.admin')

@section('title', 'Presensi Latihan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Presensi & Absensi Latihan Harian')

@section('content')

<div class="space-y-6">

    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <a href="{{ route('admin.schedules.index') }}"
           class="min-h-[44px] px-4 py-2 bg-white hover:bg-[#FFFF00] text-[#111111] border-2 border-[#111111] text-xs font-mono font-bold inline-flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Kembali ke Kelola Jadwal Latihan</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="text-xs font-mono text-[#525252]">Total Siswa Aktif Sesi Ini: <strong class="text-[#111111]">{{ $players->count() }}</strong></span>
        </div>
    </div>

    <!-- Active Correlated Schedule Banner -->
    <div class="bg-[#111111] text-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#FFFFFF]" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="px-2.5 py-0.5 bg-[#FFFF00] text-[#111111] font-mono font-bold text-xs border border-[#FFFFFF]">
                        SESI #{{ $selectedSchedule->id }}
                    </span>
                    <h2 class="font-bold text-white text-lg sm:text-xl">{{ $selectedSchedule->title }}</h2>
                    {!! $selectedSchedule->status_badge !!}
                </div>
                <div class="flex flex-wrap items-center gap-y-1 gap-x-3 text-xs text-[#D4D4D4] font-mono">
                    <span><i class="fa-solid fa-calendar-day text-[#FFFF00] mr-1" aria-hidden="true"></i> {{ date('l, d F Y', strtotime($selectedSchedule->schedule_date)) }}</span>
                    <span class="text-[#525252]">&bull;</span>
                    <span><i class="fa-solid fa-clock text-[#FFFF00] mr-1" aria-hidden="true"></i> {{ $selectedSchedule->formatted_time }} WIB</span>
                    <span class="text-[#525252]">&bull;</span>
                    <span><i class="fa-solid fa-location-dot text-[#FFFF00] mr-1" aria-hidden="true"></i> {{ $selectedSchedule->location }}</span>
                    <span class="text-[#525252]">&bull;</span>
                    <span><i class="fa-solid fa-user-shield text-[#FFFF00] mr-1" aria-hidden="true"></i> Pelatih: {{ $selectedSchedule->coach_in_charge ?? 'Tim Pelatih' }}</span>
                    <span class="text-[#525252]">&bull;</span>
                    <span class="text-[#FFFF00] font-bold"><i class="fa-solid fa-users text-[#FFFF00] mr-1" aria-hidden="true"></i> Target KU: {{ $selectedSchedule->target_ku }}</span>
                </div>
            </div>

            <!-- Filter Tahun Lahir / KU inside this session -->
            <form action="{{ route('admin.attendances.index') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-[#181818] p-3 border border-[#333333]">
                <input type="hidden" name="schedule_id" value="{{ $selectedSchedule->id }}">
                <input type="hidden" name="date" value="{{ $date }}">
                <label for="year" class="text-xs font-mono uppercase font-bold text-[#D4D4D4]">Filter Usia:</label>
                <select id="year" name="year" onchange="this.form.submit()" class="ds-input text-xs py-1.5 px-3 bg-white text-[#111111]">
                    <option value="">-- Semua Siswa Sesi --</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                            Kelahiran {{ $yr }} (Usia {{ date('Y') - $yr }} Thn)
                        </option>
                    @endforeach
                </select>
                @if(request('year'))
                    <a href="{{ route('admin.attendances.index', ['schedule_id' => $selectedSchedule->id, 'date' => $date]) }}"
                       class="text-xs text-[#FFFF00] hover:underline font-mono ml-1">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Attendance Form -->
    <form action="{{ route('admin.attendances.store') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="schedule_id" value="{{ $selectedSchedule ? $selectedSchedule->id : '' }}">

        <div class="editorial-card p-0 overflow-hidden">

            <div class="p-5 sm:p-6 bg-[#F4F4F4] border-b-2 border-[#111111] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="font-bold text-[#111111] text-base sm:text-lg">
                        Checklist Presensi: {{ date('l, d F Y', strtotime($date)) }}
                    </h3>
                    <p class="text-xs text-[#525252] mt-0.5">
                        @if($selectedSchedule)
                            Pilih status kehadiran siswa untuk sesi <strong class="text-[#111111]">{{ $selectedSchedule->title }}</strong> (Target: {{ $selectedSchedule->target_ku }}).
                        @else
                            Pilih status kehadiran untuk setiap siswa yang mengikuti latihan harian.
                        @endif
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <button type="button" id="btn-mark-all-hadir" class="btn-yellow text-xs py-2.5 px-4">
                        <i class="fa-solid fa-check-double" aria-hidden="true"></i> Tandai Semua Hadir
                    </button>
                    <button type="submit" class="btn-primary text-xs py-2.5 px-5 font-bold">
                        <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i> Simpan Presensi Sesi Ini
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#111111]">
                    <thead class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                        <tr>
                            <th class="p-4 text-center">No</th>
                            <th class="p-4">Siswa &amp; NIS</th>
                            <th class="p-4">Tahun Lahir &amp; KU</th>
                            <th class="p-4">Posisi</th>
                            <th class="p-4 text-center">Status Kehadiran (Hadir / Izin / Sakit / Alpa)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#111111] bg-white">
                        @forelse($players as $index => $player)
                            @php
                                $att = $attendances->get($player->id);
                                $currentStatus = $att ? $att->status : 'hadir';
                            @endphp
                            <tr class="hover:bg-[#F4F4F4] transition-colors">
                                <td class="p-4 text-[#525252] font-mono font-bold text-center">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <span class="font-bold text-[#111111] text-sm block leading-tight">{{ $player->full_name }}</span>
                                    <span class="text-xs text-[#525252] font-mono">{{ $player->nis }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs">
                                        {{ $player->birth_year }}
                                    </span>
                                    <span class="text-xs text-[#111111] font-bold ml-1">({{ $player->age_category_badge }})</span>
                                </td>
                                <td class="p-4 font-bold text-[#111111]">
                                    {{ $player->position }}
                                </td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex flex-wrap items-center justify-center gap-3 bg-[#F4F4F4] p-2.5 border-2 border-[#111111]">
                                        <label class="flex items-center gap-1.5 cursor-pointer min-h-[32px] px-1.5">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="hadir" {{ $currentStatus == 'hadir' ? 'checked' : '' }} class="w-4 h-4 accent-[#166534]">
                                            <span class="font-bold text-[#14532D] text-xs">Hadir</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer min-h-[32px] px-1.5">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="izin" {{ $currentStatus == 'izin' ? 'checked' : '' }} class="w-4 h-4 accent-[#0000FF]">
                                            <span class="font-bold text-[#111111] text-xs">Izin</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer min-h-[32px] px-1.5">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="sakit" {{ $currentStatus == 'sakit' ? 'checked' : '' }} class="w-4 h-4 accent-[#111111]">
                                            <span class="font-bold text-[#111111] text-xs">Sakit</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer min-h-[32px] px-1.5">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="alpa" {{ $currentStatus == 'alpa' ? 'checked' : '' }} class="w-4 h-4 accent-[#B91C1C]">
                                            <span class="font-bold text-[#991B1B] text-xs">Alpa</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-[#525252]">
                                    Tidak ada pemain aktif untuk kriteria ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 bg-[#F4F4F4] border-t-2 border-[#111111] flex justify-end">
                <button type="submit" class="btn-primary text-xs py-2.5 px-6 font-bold">
                    <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i> Simpan Presensi Sesi Ini
                </button>
            </div>

        </div>
    </form>

</div>

<script>
    (function() {
        const markBtn = document.getElementById('btn-mark-all-hadir');
        if (!markBtn) return;
        markBtn.addEventListener('click', function() {
            document.querySelectorAll("input[type='radio'][value='hadir']").forEach((radio) => {
                radio.checked = true;
            });
            const orig = markBtn.innerHTML;
            markBtn.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i> Semua Hadir Ditandai';
            setTimeout(() => { markBtn.innerHTML = orig; }, 1600);
        });
    })();
</script>

@endsection
