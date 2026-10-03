@extends('layouts.admin')

@section('title', 'Dashboard Admin - Mekar Jaya Sport Subang')
@section('page-header', 'Dashboard Ringkasan Utama')

@section('content')

<div class="space-y-8">

    <!-- Quick Stats Cards (Cooking App 16px Tiles) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Active Siswa -->
        <div class="editorial-card p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#666666] uppercase tracking-wider block">Total Siswa Aktif</span>
                <span class="text-3xl font-extrabold font-mono text-[#111111] mt-1 block">{{ $totalPlayers }}</span>
                <span class="text-xs text-[#16A34A] font-semibold flex items-center gap-1 mt-1">
                    <i class="fa-solid fa-users"></i> Terdaftar di SSB
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#FFF2E8] text-[#FF6B00] flex items-center justify-center text-xl font-bold border border-[#FFE0CC]">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Presensi Today -->
        <div class="editorial-card p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#666666] uppercase tracking-wider block">Presensi Hari Ini</span>
                <span class="text-3xl font-extrabold font-mono text-[#111111] mt-1 block">{{ $todayHadir }}</span>
                <span class="text-xs text-[#666666] mt-1 block">Dari {{ $todayAtt }} siswa hadir</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#F9F9F9] text-[#111111] flex items-center justify-center text-xl font-bold border border-[#EAEAEA]">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
        </div>

        <!-- Pending Registrations -->
        <div class="editorial-card p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#666666] uppercase tracking-wider block">Pendaftaran Baru</span>
                <span class="text-3xl font-extrabold font-mono text-[#FF6B00] mt-1 block">{{ $pendingRegistrations }}</span>
                <span class="text-xs text-[#FF6B00] font-semibold mt-1 block">Membutuhkan Verifikasi</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#FFF2E8] text-[#FF6B00] flex items-center justify-center text-xl font-bold border border-[#FFE0CC]">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <!-- SPP Status -->
        <div class="editorial-card p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#666666] uppercase tracking-wider block">Status SPP Bulanan</span>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xl font-bold text-[#16A34A] font-mono">{{ $sppLunas }} <span class="text-xs font-normal text-[#666666]">Lunas</span></span>
                    <span class="text-[#EAEAEA]">|</span>
                    <span class="text-xl font-bold text-[#EF4444] font-mono">{{ $sppMenunggak }} <span class="text-xs font-normal text-[#666666]">Tunggak</span></span>
                </div>
                <span class="text-xs text-[#666666] mt-1 block">Bulan Berjalan</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#F9F9F9] text-[#111111] flex items-center justify-center text-xl font-bold border border-[#EAEAEA]">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

    </div>


    <!-- CORE ANALYTICS: DISTRIBUTION OF PLAYERS BY BIRTH YEAR -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Chart & Distribution Table -->
        <div class="lg:col-span-8 editorial-card p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#EAEAEA] pb-4">
                <div>
                    <h3 class="font-extrabold text-[#111111] text-base flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-[#FF6B00]"></i> Distribusi Data Pemain Berdasarkan Tahun Lahir
                    </h3>
                    <p class="text-xs text-[#666666]">Pengelompokan siswa SSB Mekar Jaya Subang per angkatan kelahiran.</p>
                </div>
                <a href="{{ route('admin.players.index') }}" class="btn-secondary text-xs py-2 px-4 rounded-xl self-start">
                    Filter Pemain <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                </a>
            </div>

            <!-- Visual Bar Chart -->
            <div class="h-64">
                <canvas id="birthYearChart"></canvas>
            </div>

            <!-- Detailed Year Breakdown Table -->
            <div class="overflow-x-auto border border-[#EAEAEA] rounded-xl">
                <table class="w-full text-left text-xs text-[#111111]">
                    <thead class="bg-[#FAFAFA] text-[#111111] font-semibold uppercase text-[11px] border-b border-[#EAEAEA]">
                        <tr>
                            <th class="p-3.5">Tahun Lahir</th>
                            <th class="p-3.5">Perkiraan Usia</th>
                            <th class="p-3.5">Kelompok Umur (KU)</th>
                            <th class="p-3.5">Jumlah Siswa</th>
                            <th class="p-3.5 text-right">Aksi Filter</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAEAEA] font-medium">
                        @foreach($playersByYear as $py)
                            @php
                                $age = date('Y') - $py->birth_year;
                                $kuLabel = 'U-10';
                                if ($age > 10 && $age <= 12) $kuLabel = 'U-12';
                                elseif ($age > 12 && $age <= 14) $kuLabel = 'U-14';
                                elseif ($age > 14 && $age <= 16) $kuLabel = 'U-16';
                                elseif ($age > 16) $kuLabel = 'U-18';
                            @endphp
                            <tr class="hover:bg-[#FAFAFA] transition-colors">
                                <td class="p-3.5 font-bold text-[#111111]">
                                    <span class="px-2.5 py-1 bg-[#111111] text-white rounded-lg font-mono font-bold text-xs">
                                        {{ $py->birth_year }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-[#111111] font-medium">{{ $age }} Tahun</td>
                                <td class="p-3.5">
                                    <span class="px-2.5 py-1 rounded-lg bg-[#F9F9F9] text-[#111111] font-semibold text-[11px] border border-[#EAEAEA]">
                                        {{ $kuLabel }}
                                    </span>
                                </td>
                                <td class="p-3.5 font-bold text-[#16A34A] text-xs font-mono">{{ $py->total }} Pemain</td>
                                <td class="p-3.5 text-right">
                                    <a href="{{ route('admin.players.index', ['year' => $py->birth_year]) }}" 
                                       class="btn-primary text-[11px] py-1.5 px-3 rounded-xl inline-block">
                                        Lihat List {{ $py->birth_year }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Recent Online Registrations Sidebar -->
        <div class="lg:col-span-4 editorial-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#EAEAEA] pb-3">
                <h3 class="font-extrabold text-[#111111] text-sm flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-[#FF6B00]"></i> Pendaftaran Terbaru
                </h3>
                <a href="{{ route('admin.registrations.index') }}" class="text-xs text-[#FF6B00] font-semibold hover:underline">Lihat Semua</a>
            </div>

            @if($recentRegs->count() > 0)
                <div class="space-y-3">
                    @foreach($recentRegs as $reg)
                        <div class="p-4 rounded-xl border border-[#EAEAEA] bg-[#FAFAFA] space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-[#111111] text-xs">{{ $reg->full_name }}</h4>
                                    <span class="text-[10px] text-[#666666]">Lahir {{ date('d M Y', strtotime($reg->birth_date)) }} ({{ $reg->birth_year }})</span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase {{ $reg->status == 'pending' ? 'bg-[#FFF2E8] text-[#FF6B00] border border-[#FFE0CC]' : ($reg->status == 'approved' ? 'bg-[#16A34A]/10 text-[#16A34A]' : 'bg-[#EF4444]/10 text-[#EF4444]') }}">
                                    {{ $reg->status }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between pt-2.5 border-t border-[#EAEAEA] text-xs">
                                <span class="text-[#666666] text-[11px]"><i class="fa-solid fa-phone text-[#16A34A] mr-1"></i> {{ $reg->parent_phone }}</span>
                                @if($reg->status == 'pending')
                                    <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary text-[10px] py-1 px-2.5 rounded-lg">
                                            Setujui
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-[#666666] py-6 text-center">Belum ada pendaftaran siswa baru.</p>
            @endif
        </div>

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
                    backgroundColor: '#FF6B00',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    });
</script>

@endsection
