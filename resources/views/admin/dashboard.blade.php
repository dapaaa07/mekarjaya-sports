@extends('layouts.admin')

@section('title', 'Dashboard Admin - Mekar Jaya Sport Subang')
@section('page-header', 'Dashboard Ringkasan Utama')

@section('content')

<div class="space-y-8">

    <!-- ASYMMETRIC MONDRIAN KPI STRIP (No 4-column equal cards) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        <!-- 1. Total Active Siswa (Dark Focus Hero Tile - 5 cols) -->
        <div class="lg:col-span-5 bg-[#111111] text-white border-2 border-[#111111] p-6 flex flex-col justify-between gap-4 dark-surface shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <span class="text-xs font-mono font-bold text-[#FFFF00] uppercase tracking-wider block">Total Siswa Aktif</span>
                    <span class="text-4xl font-bold font-mono text-white mt-2 block">{{ $totalPlayers }}</span>
                </div>
                <div class="w-12 h-12 bg-[#0000FF] text-white border-2 border-[#FFFFFF] flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-user-graduate" aria-hidden="true"></i>
                </div>
            </div>
            <div class="pt-3 border-t border-[#333333] flex items-center justify-between gap-2 text-xs">
                <span class="text-[#D4D4D4]"><i class="fa-solid fa-users text-[#FFFF00] mr-1" aria-hidden="true"></i> Terdaftar di SSB Mekar Jaya</span>
                @if(Auth::user()?->isAdmin())
                    <a href="{{ route('admin.players.index') }}" class="font-mono font-bold text-[#FFFF00] hover:underline whitespace-nowrap shrink-0">Buka Roster</a>
                @else
                    <a href="{{ route('admin.evaluations.index') }}" class="font-mono font-bold text-[#FFFF00] hover:underline whitespace-nowrap shrink-0">Evaluasi Siswa</a>
                @endif
            </div>
        </div>

        <!-- 2. Pending Registrations (Admin) or Match Center Quick Stat (Coach) (4 cols) -->
        @if(Auth::user()?->isAdmin())
            <div class="lg:col-span-4 {{ $pendingRegistrations > 0 ? 'bg-[#FFFF00]' : 'bg-white' }} border-2 border-[#111111] p-6 flex flex-col justify-between gap-4 shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-mono font-bold text-[#111111] uppercase tracking-wider block">Pendaftaran Baru</span>
                        <span class="text-4xl font-bold font-mono text-[#111111] mt-2 block">{{ $pendingRegistrations }}</span>
                    </div>
                    <div class="w-12 h-12 bg-[#FF0000] text-[#000000] border-2 border-[#111111] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="pt-3 border-t-2 border-[#111111] flex items-center justify-between gap-2 text-xs">
                    <span class="font-bold text-[#111111]">Verifikasi KK</span>
                    <a href="{{ route('admin.registrations.index') }}" class="font-mono font-bold bg-[#111111] text-white px-2.5 py-1 hover:bg-[#0000FF] transition-colors whitespace-nowrap shrink-0">
                        Cek Antrean
                    </a>
                </div>
            </div>
        @else
            @php $upcomingScheduleCnt = \App\Models\TrainingSchedule::where('status', 'scheduled')->count(); @endphp
            <div class="lg:col-span-4 bg-[#FFFF00] border-2 border-[#111111] p-6 flex flex-col justify-between gap-4 shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-mono font-bold text-[#111111] uppercase tracking-wider block">Jadwal Terjadwal</span>
                        <span class="text-4xl font-bold font-mono text-[#111111] mt-2 block">{{ $upcomingScheduleCnt }}</span>
                    </div>
                    <div class="w-12 h-12 bg-[#FF0000] text-[#000000] border-2 border-[#111111] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="pt-3 border-t-2 border-[#111111] flex items-center justify-between gap-2 text-xs">
                    <span class="font-bold text-[#111111]">Agenda Latihan</span>
                    <a href="{{ route('admin.schedules.index') }}" class="font-mono font-bold bg-[#111111] text-white px-2.5 py-1 hover:bg-[#0000FF] transition-colors whitespace-nowrap shrink-0">
                        Buka Jadwal
                    </a>
                </div>
            </div>
        @endif

        <!-- 3. Presensi Today (White Structural Tile with Blue Accent - 3 cols) -->
        <div class="lg:col-span-3 bg-white border-2 border-[#111111] border-t-[6px] border-t-[#0000FF] p-6 flex flex-col justify-between gap-4 shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-mono font-bold text-[#0000FF] uppercase tracking-wider block">Presensi Hari Ini</span>
                    <span class="text-4xl font-bold font-mono text-[#111111] mt-2 block">{{ $todayHadir }}</span>
                </div>
                <div class="w-11 h-11 bg-[#F4F4F4] text-[#111111] border-2 border-[#111111] flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-clipboard-user" aria-hidden="true"></i>
                </div>
            </div>
            <div class="pt-3 border-t border-[#D4D4D4] flex items-center justify-between gap-2 text-xs text-[#525252]">
                <span>Dari {{ $todayAtt }} siswa hadir</span>
                <a href="{{ route('admin.attendances.index') }}" class="font-mono font-bold text-[#0000FF] hover:underline whitespace-nowrap shrink-0">Input Presensi</a>
            </div>
        </div>

    </div>

    <!-- SECONDARY FULL-WIDTH SPP LEDGER STRIP (Admin Only) -->
    @if(Auth::user()?->isAdmin())
        @php
            $sppTotal = max(1, $sppLunas + $sppMenunggak);
            $lunasPct = round(($sppLunas / $sppTotal) * 100);
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
            <div class="lg:col-span-7 p-5 sm:p-6 border-b-2 lg:border-b-0 lg:border-r-2 border-[#111111] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-mono font-bold text-[#525252] uppercase tracking-wider block">Status SPP Bulanan</span>
                    <div class="flex flex-wrap items-center gap-3 mt-1.5">
                        <span class="badge-success text-sm font-mono">{{ $sppLunas }} Lunas</span>
                        <span class="badge-danger text-sm font-mono">{{ $sppMenunggak }} Tunggak</span>
                        <span class="text-xs text-[#525252]">Bulan Berjalan ({{ $lunasPct }}% Terbayar)</span>
                    </div>
                </div>
                <div class="w-full sm:w-44 shrink-0">
                    <div class="w-full h-4 border-2 border-[#111111] bg-[#FEE2E2]">
                        <div class="h-full bg-[#166534] border-r border-[#111111]" style="width: {{ $lunasPct }}%"></div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-5 p-5 sm:p-6 bg-[#F4F4F4] flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs font-mono font-bold text-[#111111] uppercase">Aksi Cepat Hari Ini</span>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.attendances.index') }}" class="btn-blue text-xs py-2 px-3.5">
                        <i class="fa-solid fa-check-double" aria-hidden="true"></i> Presensi Latihan
                    </a>
                    <a href="{{ route('admin.schedules.create') }}" class="btn-secondary text-xs py-2 px-3.5">
                        <i class="fa-solid fa-calendar-plus" aria-hidden="true"></i> Jadwal Baru
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- CORE ANALYTICS: DISTRIBUTION OF PLAYERS BY BIRTH YEAR -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Chart & Distribution Table (8 Cols) -->
        <div class="{{ Auth::user()?->isAdmin() ? 'lg:col-span-8' : 'lg:col-span-12' }} editorial-card p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b-2 border-[#111111] pb-4">
                <div>
                    <h3 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-[#0000FF]" aria-hidden="true"></i> Distribusi Data Pemain Berdasarkan Tahun Lahir
                    </h3>
                    <p class="text-xs text-[#525252]">Pengelompokan siswa SSB Mekar Jaya Subang per angkatan kelahiran.</p>
                </div>
                @if(Auth::user()?->isAdmin())
                    <a href="{{ route('admin.players.index') }}" class="btn-secondary text-xs py-2 px-4 self-start">
                        Filter Pemain <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
                    </a>
                @else
                    <a href="{{ route('admin.evaluations.index') }}" class="btn-secondary text-xs py-2 px-4 self-start">
                        Input Evaluasi <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
                    </a>
                @endif
            </div>

            <!-- Visual Bar Chart -->
            <div class="h-64 bg-white">
                <canvas id="birthYearChart"></canvas>
            </div>

            <!-- Detailed Year Breakdown Table -->
            <div class="overflow-x-auto border-2 border-[#111111]">
                <table class="w-full text-left text-xs text-[#111111]">
                    <thead class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                        <tr>
                            <th class="p-3.5">Tahun Lahir</th>
                            <th class="p-3.5">Perkiraan Usia</th>
                            <th class="p-3.5">Kelompok Umur (KU)</th>
                            <th class="p-3.5">Jumlah Siswa</th>
                            <th class="p-3.5 text-right">Aksi Filter</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#111111] font-medium bg-white">
                        @foreach($playersByYear as $py)
                            @php
                                $age = date('Y') - $py->birth_year;
                                $kuLabel = 'U-10';
                                if ($age > 10 && $age <= 12) $kuLabel = 'U-12';
                                elseif ($age > 12 && $age <= 14) $kuLabel = 'U-14';
                                elseif ($age > 14 && $age <= 16) $kuLabel = 'U-16';
                                elseif ($age > 16) $kuLabel = 'U-18';
                            @endphp
                            <tr class="hover:bg-[#F4F4F4] transition-colors">
                                <td class="p-3.5 font-bold text-[#111111]">
                                    <span class="px-2.5 py-1 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs inline-block">
                                        {{ $py->birth_year }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-[#111111] font-medium">{{ $age }} Tahun</td>
                                <td class="p-3.5">
                                    <span class="badge-secondary font-mono">{{ $kuLabel }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-[#166534] text-xs font-mono">{{ $py->total }} Pemain</td>
                                <td class="p-3.5 text-right">
                                    @if(Auth::user()?->isAdmin())
                                        <a href="{{ route('admin.players.index', ['year' => $py->birth_year]) }}"
                                           class="btn-primary text-xs py-1.5 px-3 min-h-[40px]">
                                            Lihat List {{ $py->birth_year }}
                                        </a>
                                    @else
                                        <a href="{{ route('admin.evaluations.index', ['year' => $py->birth_year]) }}"
                                           class="btn-blue text-xs py-1.5 px-3 min-h-[40px]">
                                            Evaluasi {{ $py->birth_year }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Recent Online Registrations Sidebar (Admin Only - 4 Cols) -->
        @if(Auth::user()?->isAdmin())
            <div class="lg:col-span-4 editorial-card p-6 space-y-4">
                <div class="flex items-center justify-between border-b-2 border-[#111111] pb-3">
                    <h3 class="font-bold text-[#111111] text-sm flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-[#CC0000]" aria-hidden="true"></i> Pendaftaran Terbaru
                    </h3>
                    <a href="{{ route('admin.registrations.index') }}" class="text-xs text-[#0000FF] font-mono font-bold hover:underline">Lihat Semua</a>
                </div>

                @if($recentRegs->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentRegs as $reg)
                            <div class="p-4 border-2 border-[#111111] bg-[#F4F4F4] space-y-2.5">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <h4 class="font-bold text-[#111111] text-xs">{{ $reg->full_name }}</h4>
                                        <span class="text-[11px] font-mono text-[#525252]">Lahir {{ date('d M Y', strtotime($reg->birth_date)) }} ({{ $reg->birth_year }})</span>
                                    </div>
                                    @if($reg->status == 'pending')
                                        <span class="badge-primary text-[10px] font-mono uppercase">Pending</span>
                                    @elseif($reg->status == 'approved')
                                        <span class="badge-success text-[10px] font-mono uppercase">Approved</span>
                                    @else
                                        <span class="badge-danger text-[10px] font-mono uppercase">{{ $reg->status }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between pt-2.5 border-t border-[#111111] text-xs">
                                    <span class="text-[#111111] font-mono text-[11px]"><i class="fa-solid fa-phone text-[#166534] mr-1" aria-hidden="true"></i> {{ $reg->parent_phone }}</span>
                                    @if($reg->status == 'pending')
                                        <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-primary text-xs py-1.5 px-3 min-h-[36px]">
                                                Setujui
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-10 text-center space-y-2 border-2 border-dashed border-[#111111]">
                        <i class="fa-solid fa-inbox text-2xl text-[#525252]" aria-hidden="true"></i>
                        <p class="text-xs text-[#525252]">Belum ada pendaftaran siswa baru.</p>
                    </div>
                @endif
            </div>
        @endif

    </div>

</div>

<!-- Chart.js Script for Birth Year Analytics -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('birthYearChart').getContext('2d');
        const labels = [@foreach($playersByYear as $py) 'Tahun {{ $py->birth_year }}', @endforeach];
        const data = [@foreach($playersByYear as $py) {{ $py->total }}, @endforeach];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Siswa SSB',
                    data: data,
                    backgroundColor: '#0000FF',
                    borderColor: '#111111',
                    borderWidth: 2,
                    borderRadius: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#111111', font: { family: 'JetBrains Mono, monospace', weight: '700' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#E5E5E5' },
                        ticks: { stepSize: 1, color: '#111111' }
                    }
                }
            }
        });
    });
</script>

@endsection
