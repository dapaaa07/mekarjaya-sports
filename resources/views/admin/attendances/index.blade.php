@extends('layouts.admin')

@section('title', 'Presensi Latihan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Presensi & Absensi Latihan Harian')

@section('content')

<div class="space-y-6">

    <!-- Date & Schedule Filter Controls (DESIGN.md Editorial Card) -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.attendances.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end text-xs">
            
            <div class="md:col-span-3">
                <label for="date" class="block font-medium text-[#626260] uppercase mb-1">Tanggal Sesi Latihan *</label>
                <input type="date" id="date" name="date" value="{{ $date }}" 
                    class="w-full px-3.5 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-bold">
            </div>

            <div class="md:col-span-4">
                <label for="schedule_id" class="block font-medium text-[#626260] uppercase mb-1">Pilih Sesi Jadwal Terdaftar</label>
                <select id="schedule_id" name="schedule_id" class="w-full px-3.5 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
                    <option value="">-- Presensi Bebas Tanpa Sesi --</option>
                    @foreach($todaySchedules as $ts)
                        <option value="{{ $ts->id }}" {{ ($selectedSchedule && $selectedSchedule->id == $ts->id) ? 'selected' : '' }}>
                            {{ $ts->title }} ({{ $ts->formatted_time }}) - {{ $ts->target_ku }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3">
                <label for="year" class="block font-medium text-[#626260] uppercase mb-1">Filter Tahun Lahir Siswa</label>
                <select id="year" name="year" class="w-full px-3.5 py-2 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-medium">
                    <option value="">-- Semua Tahun Lahir --</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                            Kelahiran {{ $yr }} (Usia {{ date('Y') - $yr }} Thn)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-1">
                <button type="submit" class="w-full btn-primary text-xs py-2 flex items-center justify-center gap-1">
                    <i class="fa-solid fa-search"></i> Tampilkan
                </button>
            </div>

        </form>
    </div>

    <!-- Active Correlated Schedule Banner -->
    @if($selectedSchedule)
        <div class="bg-[#111111] text-white p-5 rounded-xl border border-[#313130] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-xs">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded bg-[#ff5600] text-white font-mono font-bold text-[10px]">
                        SESI JADWAL #{{ $selectedSchedule->id }}
                    </span>
                    <h3 class="font-bold text-white text-sm">{{ $selectedSchedule->title }}</h3>
                </div>
                <p class="text-[#9c9fa5]">
                    <i class="fa-solid fa-clock text-[#ff5600] mr-1"></i> {{ date('l, d M Y', strtotime($selectedSchedule->schedule_date)) }} ({{ $selectedSchedule->formatted_time }})
                    <span class="mx-1 text-[#313130]">|</span>
                    <i class="fa-solid fa-location-dot text-[#16A34A] mr-1"></i> {{ $selectedSchedule->location }}
                    <span class="mx-1 text-[#313130]">|</span>
                    <i class="fa-solid fa-user-shield text-[#ff5600] mr-1"></i> Pelatih: {{ $selectedSchedule->coach_in_charge ?? 'Tim Pelatih' }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                {!! $selectedSchedule->status_badge !!}
                <a href="{{ route('admin.schedules.index') }}" class="btn-secondary text-[11px] py-1 px-3">
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

        <div class="editorial-card overflow-hidden">
            
            <div class="p-5 bg-[#ebe7e1] border-b border-[#d3cec6] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="font-bold text-[#111111] text-base">
                        Checklist Presensi: {{ date('l, d F Y', strtotime($date)) }}
                    </h3>
                    <p class="text-xs text-[#626260]">
                        @if($selectedSchedule)
                            Pilih status kehadiran siswa untuk sesi <strong>{{ $selectedSchedule->title }}</strong> (Target: {{ $selectedSchedule->target_ku }}).
                        @else
                            Pilih status kehadiran untuk setiap siswa yang mengikuti latihan harian.
                        @endif
                    </p>
                </div>

                <button type="submit" class="btn-fin text-xs py-2 px-4 flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Presensi Sesi Ini
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#111111]">
                    <thead class="bg-[#ebe7e1] text-[#111111] font-semibold uppercase border-b border-[#d3cec6]">
                        <tr>
                            <th class="p-4 text-center">No</th>
                            <th class="p-4">Siswa & NIS</th>
                            <th class="p-4">Tahun Lahir & KU</th>
                            <th class="p-4">Posisi</th>
                            <th class="p-4 text-center">Status Kehadiran (Hadir / Izin / Sakit / Alpa)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ebe7e1]">
                        @forelse($players as $index => $player)
                            @php
                                $att = $attendances->get($player->id);
                                $currentStatus = $att ? $att->status : 'hadir';
                            @endphp
                            <tr class="hover:bg-[#ebe7e1]/40 transition-colors">
                                <td class="p-4 text-[#626260] font-mono text-center">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <span class="font-bold text-[#111111] text-sm block leading-tight">{{ $player->full_name }}</span>
                                    <span class="text-[11px] text-[#626260] font-mono">{{ $player->nis }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-0.5 rounded bg-[#111111] text-white font-mono font-bold text-xs">
                                        {{ $player->birth_year }}
                                    </span>
                                    <span class="text-xs text-[#111111] font-medium ml-1">({{ $player->age_category_badge }})</span>
                                </td>
                                <td class="p-4 font-medium text-[#111111]">
                                    {{ $player->position }}
                                </td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center gap-3 bg-[#f5f1ec] p-1.5 rounded-md border border-[#d3cec6]">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="hadir" {{ $currentStatus == 'hadir' ? 'checked' : '' }} class="text-[#16A34A] focus:ring-[#16A34A]">
                                            <span class="font-semibold text-[#16A34A] text-xs">Hadir</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="izin" {{ $currentStatus == 'izin' ? 'checked' : '' }} class="text-[#111111] focus:ring-[#111111]">
                                            <span class="font-semibold text-[#111111] text-xs">Izin</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="sakit" {{ $currentStatus == 'sakit' ? 'checked' : '' }} class="text-[#ff5600] focus:ring-[#ff5600]">
                                            <span class="font-semibold text-[#ff5600] text-xs">Sakit</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $player->id }}]" value="alpa" {{ $currentStatus == 'alpa' ? 'checked' : '' }} class="text-[#c41c1c] focus:ring-[#c41c1c]">
                                            <span class="font-semibold text-[#c41c1c] text-xs">Alpa</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-[#626260]">
                                    Tidak ada pemain aktif untuk kriteria ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 bg-[#ebe7e1] border-t border-[#d3cec6] flex justify-end">
                <button type="submit" class="btn-fin text-xs py-2.5 px-6 flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Presensi Sesi Ini
                </button>
            </div>

        </div>
    </form>

</div>

@endsection
