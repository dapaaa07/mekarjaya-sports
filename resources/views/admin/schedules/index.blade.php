@extends('layouts.admin')

@section('title', 'Kelola Jadwal Latihan - Mekar Jaya Sport Subang')
@section('page-header', 'Manajemen & Kelola Jadwal Latihan SSB')

@section('content')

<div class="space-y-6">

    <!-- Header Control Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 editorial-card p-6 border-l-[6px] border-l-[#0000FF]">
        <div>
            <h2 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#0000FF]" aria-hidden="true"></i> Master Kelola Jadwal Latihan
            </h2>
            <p class="text-xs text-[#525252] mt-0.5">Jadwal latihan terhubung langsung dengan modul Presensi Harian Siswa.</p>
        </div>

        <a href="{{ route('admin.schedules.create') }}" class="btn-primary text-xs py-2.5 px-4">
            <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Tambah Sesi Latihan Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.schedules.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4 items-end text-xs">

            <div class="md:col-span-5">
                <label for="status" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Status Sesi Latihan</label>
                <select id="status" name="status" class="ds-input text-sm py-2.5">
                    <option value="">-- Semua Status --</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal (Scheduled)</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <div class="md:col-span-5">
                <label for="ku" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kelompok Umur (KU)</label>
                <select id="ku" name="ku" class="ds-input text-sm py-2.5">
                    <option value="">-- Semua KU --</option>
                    @foreach($ageCategories as $cat)
                        <option value="{{ $cat->code }}" {{ request('ku') == $cat->code ? 'selected' : '' }}>{{ $cat->code }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-1.5">
                <button type="submit" class="w-full btn-primary text-xs py-2.5 px-4">
                    <i class="fa-solid fa-filter" aria-hidden="true"></i> Filter
                </button>
                @if(request()->hasAny(['status', 'ku']))
                    <a href="{{ route('admin.schedules.index') }}" aria-label="Reset filter" title="Reset Filter" class="btn-secondary text-xs py-2.5 px-3">
                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Schedules Data Table -->
    <div class="editorial-card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                    <tr>
                        <th class="p-4">Tanggal &amp; Jam</th>
                        <th class="p-4">Nama Sesi Latihan</th>
                        <th class="p-4">Target KU &amp; Lokasi</th>
                        <th class="p-4">Pelatih Penanggung Jawab</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Presensi &amp; Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($schedules as $sched)
                        <tr class="hover:bg-[#F4F4F4] transition-colors">

                            <!-- Date & Time -->
                            <td class="p-4">
                                <span class="font-mono font-bold text-sm block leading-tight text-[#111111]">{{ date('d M Y', strtotime($sched->schedule_date)) }}</span>
                                <span class="text-xs text-[#0000FF] font-mono font-bold"><i class="fa-solid fa-clock mr-1" aria-hidden="true"></i> {{ $sched->formatted_time }}</span>
                            </td>

                            <!-- Title & Notes -->
                            <td class="p-4">
                                <span class="font-bold text-[#111111] text-sm block leading-tight">{{ $sched->title }}</span>
                                @if($sched->notes)
                                    <span class="text-xs text-[#525252] truncate max-w-xs block mt-0.5">{{ $sched->notes }}</span>
                                @endif
                            </td>

                            <!-- KU & Location -->
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs inline-block mb-1">
                                    {{ $sched->target_ku }}
                                </span>
                                <span class="block text-xs text-[#525252]"><i class="fa-solid fa-location-dot text-[#166534] mr-1" aria-hidden="true"></i> {{ $sched->location }}</span>
                            </td>

                            <!-- Coach -->
                            <td class="p-4 text-[#111111] font-bold">
                                {{ $sched->coach_in_charge ?? '-' }}
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4">
                                {!! $sched->status_badge !!}
                            </td>

                            <!-- Action & Attendance Link -->
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.attendances.index', ['schedule_id' => $sched->id, 'date' => $sched->schedule_date->toDateString()]) }}"
                                       class="btn-blue text-xs py-2 px-3 min-h-[40px]" title="Kelola / Isi Presensi Untuk Sesi Ini">
                                        <i class="fa-solid fa-clipboard-user text-xs" aria-hidden="true"></i> Presensi
                                    </a>

                                    <a href="{{ route('admin.schedules.edit', $sched->id) }}"
                                       aria-label="Edit sesi {{ $sched->title }}"
                                       class="w-10 h-10 bg-white text-[#111111] hover:bg-[#FFFF00] border-2 border-[#111111] flex items-center justify-center transition-colors" title="Edit Sesi">
                                        <i class="fa-solid fa-pen-to-square text-xs" aria-hidden="true"></i>
                                    </a>

                                    <form action="{{ route('admin.schedules.destroy', $sched->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal latihan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Hapus sesi {{ $sched->title }}"
                                                class="w-10 h-10 bg-white text-[#991B1B] hover:bg-[#FF0000] hover:text-[#000000] border-2 border-[#111111] flex items-center justify-center transition-colors cursor-pointer" title="Hapus Sesi">
                                            <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-[#525252]">
                                Belum ada jadwal latihan yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-[#111111] bg-white">
            {{ $schedules->links() }}
        </div>
    </div>

</div>

@endsection
