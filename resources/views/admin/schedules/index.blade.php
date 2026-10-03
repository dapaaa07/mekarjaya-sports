@extends('layouts.admin')

@section('title', 'Kelola Jadwal Latihan - Mekar Jaya Sport Subang')
@section('page-header', 'Manajemen & Kelola Jadwal Latihan SSB')

@section('content')

<div class="space-y-6">

    <!-- Header Control Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 editorial-card p-6">
        <div>
            <h2 class="font-extrabold text-[#111111] text-base flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#FF6B00]"></i> Master Kelola Jadwal Latihan
            </h2>
            <p class="text-xs text-[#666666]">Jadwal latihan terhubung langsung dengan modul Presensi / Absensi Harian Siswa.</p>
        </div>

        <a href="{{ route('admin.schedules.create') }}" class="btn-primary text-xs py-2.5 px-4 flex items-center gap-1.5 rounded-xl font-medium shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Sesi Latihan Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.schedules.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4 items-end text-xs">
            
            <div class="md:col-span-5">
                <label for="status" class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Status Sesi Latihan</label>
                <select id="status" name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-[#EAEAEA] bg-white text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    <option value="">-- Semua Status --</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal (Scheduled)</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <div class="md:col-span-5">
                <label for="ku" class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Kelompok Umur (KU)</label>
                <select id="ku" name="ku" class="w-full px-3.5 py-2.5 rounded-xl border border-[#EAEAEA] bg-white text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                    <option value="">-- Semua KU --</option>
                    @foreach($ageCategories as $cat)
                        <option value="{{ $cat->code }}" {{ request('ku') == $cat->code ? 'selected' : '' }}>{{ $cat->code }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-1.5">
                <button type="submit" class="w-full btn-primary text-xs py-2.5 rounded-xl flex items-center justify-center gap-1 font-medium shadow-sm">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                @if(request()->hasAny(['status', 'ku']))
                    <a href="{{ route('admin.schedules.index') }}" class="btn-secondary text-xs py-2.5 px-3 rounded-xl flex items-center justify-center font-medium">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Schedules Data Table -->
    <div class="editorial-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#FAFAFA] text-[#111111] font-semibold uppercase text-[11px] border-b border-[#EAEAEA]">
                    <tr>
                        <th class="p-4">Tanggal & Jam</th>
                        <th class="p-4">Nama Sesi Latihan</th>
                        <th class="p-4">Target KU & Lokasi</th>
                        <th class="p-4">Pelatih Penanggung Jawab</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Presensi & Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAEAEA]">
                    @forelse($schedules as $sched)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                            
                            <!-- Date & Time -->
                            <td class="p-4">
                                <span class="font-mono font-bold text-sm block leading-tight">{{ date('d M Y', strtotime($sched->schedule_date)) }}</span>
                                <span class="text-[11px] text-[#FF6B00] font-mono"><i class="fa-solid fa-clock mr-1"></i> {{ $sched->formatted_time }}</span>
                            </td>

                            <!-- Title & Notes -->
                            <td class="p-4">
                                <span class="font-bold text-[#111111] text-sm block leading-tight">{{ $sched->title }}</span>
                                @if($sched->notes)
                                    <span class="text-[11px] text-[#666666] italic truncate max-w-xs block mt-0.5">{{ $sched->notes }}</span>
                                @endif
                            </td>

                            <!-- KU & Location -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg bg-[#111111] text-white font-mono font-bold text-[11px] inline-block mb-1">
                                    {{ $sched->target_ku }}
                                </span>
                                <span class="block text-[11px] text-[#666666]"><i class="fa-solid fa-location-dot text-[#16A34A] mr-1"></i> {{ $sched->location }}</span>
                            </td>

                            <!-- Coach -->
                            <td class="p-4 text-[#111111] font-medium">
                                {{ $sched->coach_in_charge ?? '-' }}
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4">
                                {!! $sched->status_badge !!}
                            </td>

                            <!-- Action & Attendance Link -->
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Direct Correlation to Attendance Flow -->
                                    <a href="{{ route('admin.attendances.index', ['schedule_id' => $sched->id, 'date' => $sched->schedule_date->toDateString()]) }}" 
                                       class="btn-primary text-[11px] py-1.5 px-3 rounded-xl flex items-center gap-1 shadow-sm font-medium" title="Kelola / Isi Presensi Untuk Sesi Ini">
                                        <i class="fa-solid fa-clipboard-user text-xs"></i> Presensi
                                    </a>

                                    <a href="{{ route('admin.schedules.edit', $sched->id) }}" 
                                       class="w-8 h-8 rounded-xl bg-[#FAFAFA] text-[#111111] hover:bg-[#FF6B00] hover:text-white flex items-center justify-center transition-colors border border-[#EAEAEA]" title="Edit Sesi">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.schedules.destroy', $sched->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal latihan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-[#FAFAFA] text-[#EF4444] hover:bg-[#EF4444] hover:text-white flex items-center justify-center transition-colors border border-[#EAEAEA]" title="Hapus Sesi">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-[#666666]">
                                Belum ada jadwal latihan yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#EAEAEA]">
            {{ $schedules->links() }}
        </div>
    </div>

</div>

@endsection
