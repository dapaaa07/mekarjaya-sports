@extends('layouts.admin')

@section('title', 'Presensi Latihan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Presensi & Absensi Latihan Harian')

@section('content')

<div class="space-y-6">

    <!-- Date & Schedule Filter Controls -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.attendances.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end text-xs">

            <div class="md:col-span-3">
                <label for="date" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Sesi Latihan *</label>
                <input type="date" id="date" name="date" value="{{ $date }}"
                       class="ds-input text-sm py-2.5 font-bold">
            </div>

            <div class="md:col-span-4">
                <label for="schedule_id" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Pilih Sesi Jadwal Terdaftar</label>
                <select id="schedule_id" name="schedule_id" class="ds-input text-sm py-2.5 font-semibold">
                    <option value="">-- Presensi Bebas Tanpa Sesi --</option>
                    @foreach($todaySchedules as $ts)
                        <option value="{{ $ts->id }}" {{ ($selectedSchedule && $selectedSchedule->id == $ts->id) ? 'selected' : '' }}>
                            {{ $ts->title }} ({{ $ts->formatted_time }}) - {{ $ts->target_ku }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3">
                <label for="year" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Filter Tahun Lahir Siswa</label>
                <select id="year" name="year" class="ds-input text-sm py-2.5 font-medium">
                    <option value="">-- Semua Tahun Lahir --</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                            Kelahiran {{ $yr }} (Usia {{ date('Y') - $yr }} Thn)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-1.5">
                <button type="submit" class="w-full btn-primary text-xs py-2.5 px-4">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Tampilkan
                </button>
            </div>

        </form>
    </div>

    <!-- Active Correlated Schedule Banner -->
    @if($selectedSchedule)
        <div class="bg-[#111111] text-white p-5 border-2 border-[#111111] dark-surface flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-xs shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 bg-[#FFFF00] text-[#111111] font-mono font-bold text-[11px] border border-[#FFFFFF]">
                        SESI JADWAL #{{ $selectedSchedule->id }}
                    </span>
                    <h3 class="font-bold text-white text-sm sm:text-base">{{ $selectedSchedule->title }}</h3>
                </div>
                <p class="text-[#D4D4D4] font-mono text-xs">
                    <i class="fa-solid fa-clock text-[#FFFF00] mr-1" aria-hidden="true"></i> {{ date('l, d M Y', strtotime($selectedSchedule->schedule_date)) }} ({{ $selectedSchedule->formatted_time }})
                    <span class="mx-1.5 text-[#525252]">|</span>
                    <i class="fa-solid fa-location-dot text-[#FFFF00] mr-1" aria-hidden="true"></i> {{ $selectedSchedule->location }}
                    <span class="mx-1.5 text-[#525252]">|</span>
                    <i class="fa-solid fa-user-shield text-[#FFFF00] mr-1" aria-hidden="true"></i> Pelatih: {{ $selectedSchedule->coach_in_charge ?? 'Tim Pelatih' }}
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                {!! $selectedSchedule->status_badge !!}
                <a href="{{ route('admin.schedules.index') }}" class="min-h-[40px] px-3 py-1.5 bg-[#181818] hover:bg-[#FFFF00] hover:text-[#111111] text-white border-2 border-[#FFFFFF] text-xs font-bold inline-flex items-center transition-colors">
                    &larr; Lihat Semua Jadwal
                </a>
            </div>
        </div>
    @endif

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
