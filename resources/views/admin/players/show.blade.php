@extends('layouts.admin')

@section('title', 'Detail Pemain - ' . $player->full_name)
@section('page-header', 'Profil & Rapor Performa Pemain')

@section('content')

<div class="space-y-8">

    <!-- Top Profile Banner (Mondrian Dark Structural Card) -->
    <div class="bg-[#111111] text-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] dark-surface">
        <!-- 3-color top bar -->
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#FFFFFF]" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="p-6 sm:p-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">

            <div class="flex items-start sm:items-center gap-5">
                <div class="w-16 h-16 bg-[#0000FF] text-white font-mono font-bold text-3xl flex items-center justify-center border-2 border-[#FFFFFF] shrink-0">
                    {{ strtoupper(substr($player->full_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h2 class="font-bold text-xl sm:text-2xl text-white">{{ $player->full_name }}</h2>
                        <span class="px-2.5 py-0.5 bg-[#FFFF00] text-[#111111] border border-[#FFFFFF] font-mono font-bold text-xs uppercase">
                            {{ $player->position }}
                        </span>
                    </div>
                    <p class="text-xs text-[#D4D4D4] font-mono mt-1">NIS: {{ $player->nis }} | Panggilan: {{ $player->nickname ?? '-' }}</p>

                    <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                        <span class="px-3 py-1 bg-[#181818] text-[#FFFF00] font-mono font-bold border border-[#FFFFFF]">
                            Lahir {{ $player->birth_year }} (Usia {{ $player->age }} Thn)
                        </span>
                        <span class="px-3 py-1 bg-[#181818] text-white font-mono border border-[#525252]">
                            KU {{ $player->age_category_badge }}
                        </span>
                        @if($player->current_spp_status == 'Lunas')
                            <span class="badge-success text-xs">
                                <i class="fa-solid fa-check mr-1" aria-hidden="true"></i> SPP Bulan Ini Lunas
                            </span>
                        @else
                            <span class="badge-danger text-xs">
                                <i class="fa-solid fa-circle-exclamation mr-1" aria-hidden="true"></i> Belum Bayar Bulan Ini
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="no-print flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.players.print-rapor', $player->id) }}" target="_blank"
                   class="min-h-[44px] px-4 py-2 bg-[#181818] hover:bg-[#FFFF00] hover:text-[#111111] border-2 border-[#FFFFFF] text-white text-xs font-bold inline-flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-print text-xs" aria-hidden="true"></i> Cetak Rapor
                </a>

                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $player->parent_phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                    $waText = rawurlencode("Halo Bapak/Ibu {$player->parent_name}, kami dari Pengurus SSB Mekar Jaya Subang mengingatkan perihal tagihan SPP bulanan untuk siswa ananda {$player->full_name} (NIS: {$player->nis}). Mohon konfirmasi jika pembayaran telah dilakukan. Terima kasih.");
                @endphp
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank"
                   class="min-h-[44px] px-4 py-2 bg-[#FFFF00] hover:bg-[#E6E600] border-2 border-[#FFFFFF] text-[#111111] text-xs font-bold inline-flex items-center gap-1.5 transition-colors">
                    <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i> Pengingat SPP WA
                </a>

                <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-primary text-xs py-2 px-4 border-[#FFFFFF]">
                    <i class="fa-solid fa-sliders text-xs" aria-hidden="true"></i> Score Rapor
                </a>
                <a href="{{ route('admin.players.edit', $player->id) }}" class="btn-blue text-xs py-2 px-4 border-[#FFFFFF]">
                    <i class="fa-solid fa-pen-to-square text-xs" aria-hidden="true"></i> Edit
                </a>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Col: Digital Card & QR + Personal Details + Attendance (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">

            <!-- Printable Digital ID Card + QR Verification -->
            <div id="admin-digital-card" class="bg-[#111111] text-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] dark-surface print-card-clean">
                <div class="grid grid-cols-12 h-2 border-b-2 border-[#FFFFFF]" aria-hidden="true">
                    <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
                    <div class="col-span-4 bg-[#FFFF00] border-r-2 border-[#111111]"></div>
                    <div class="col-span-3 bg-[#0000FF]"></div>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between gap-2 border-b border-[#333333] pb-3">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-9 w-9 object-cover border border-[#FFFFFF]">
                            <div>
                                <span class="text-xs font-bold text-white block leading-none">KARTU SISWA DIGITAL</span>
                                <span class="text-[10px] font-mono text-[#FFFF00] uppercase">SSB MEKAR JAYA SUBANG</span>
                            </div>
                        </div>
                        <button type="button" onclick="window.print()" class="no-print min-h-[44px] px-3 py-1.5 bg-white hover:bg-[#FFFF00] text-[#111111] border border-[#FFFFFF] text-[11px] font-bold inline-flex items-center gap-1 cursor-pointer transition-colors">
                            <i class="fa-solid fa-print" aria-hidden="true"></i> Cetak Kartu
                        </button>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 bg-white p-1.5 border-2 border-[#FFFFFF] qr-code-frame shrink-0" aria-label="QR Code Kartu Digital {{ $player->nis }}">
                            {!! $player->generatePortalQrSvg(96) !!}
                        </div>
                        <div class="min-w-0 space-y-1.5 text-xs">
                            <p class="font-bold text-white text-sm leading-tight truncate">{{ $player->full_name }}</p>
                            <span class="inline-block px-2 py-0.5 bg-[#181818] text-[#FFFF00] border border-[#FFFFFF] font-mono font-bold text-xs">
                                {{ $player->nis }}
                            </span>
                            <p class="text-[11px] font-mono text-[#D4D4D4] leading-snug">
                                KU: {{ $player->age_category_badge }}
                            </p>
                            <a href="{{ $player->portal_qr_url }}" target="_blank" class="no-print inline-flex items-center min-h-[44px] gap-1 text-[11px] font-mono text-[#FFFF00] hover:underline">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]" aria-hidden="true"></i> Buka Portal Ortu
                            </a>
                        </div>
                    </div>

                    <div class="pt-2.5 border-t border-[#333333] text-[10px] font-mono text-[#D4D4D4] flex justify-between items-center gap-2">
                        <span>Scan QR untuk verifikasi &amp; rapor siswa</span>
                        <span class="text-[#FFFF00] font-bold uppercase">{{ $player->status }}</span>
                    </div>
                </div>
            </div>

            <div class="editorial-card p-6 space-y-4">
                <h3 class="font-bold text-[#111111] text-sm border-b-2 border-[#111111] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-[#0000FF]" aria-hidden="true"></i> Informasi Pribadi & Orang Tua
                </h3>

                <div class="space-y-2.5 text-xs text-[#111111]">
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">Tempat, Tgl Lahir:</span>
                        <span class="font-bold text-[#111111]">{{ $player->birth_place }}, {{ date('d F Y', strtotime($player->birth_date)) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">Tahun Kelahiran:</span>
                        <span class="badge-primary font-mono">{{ $player->birth_year }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">Ukuran Jersey:</span>
                        <span class="font-mono font-bold bg-[#111111] text-white px-2 py-0.5 text-xs">{{ $player->jersey_size ?? 'M' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">Tinggi / Berat Badan:</span>
                        <span class="font-bold font-mono text-[#111111]">{{ $player->height_cm ?? '-' }} cm / {{ $player->weight_kg ?? '-' }} kg</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">Sekolah Asal:</span>
                        <span class="font-bold text-[#111111]">{{ $player->school_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">Nama Orang Tua/Wali:</span>
                        <span class="font-bold text-[#111111]">{{ $player->parent_name }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#D4D4D4]">
                        <span class="text-[#525252]">No. WA Orang Tua:</span>
                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="font-mono font-bold text-[#166534] hover:underline">
                            <i class="fa-brands fa-whatsapp mr-1" aria-hidden="true"></i> {{ $player->parent_phone }}
                        </a>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-[#525252]">Tahun Bergabung:</span>
                        <span class="font-mono font-bold text-[#111111]">{{ $player->joined_year }}</span>
                    </div>

                    @if($player->kk_document)
                        <div class="flex justify-between items-center pt-3 border-t-2 border-[#111111]">
                            <span class="text-[#525252] font-bold">Dokumen KK:</span>
                            <a href="{{ asset('storage/' . $player->kk_document) }}" target="_blank"
                               class="min-h-[40px] inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#FFFF00] hover:bg-[#E6E600] text-[#111111] border-2 border-[#111111] text-xs font-bold transition-colors">
                                <i class="fa-solid fa-file-image" aria-hidden="true"></i> Lihat Dokumen KK
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Attendance Summary -->
            <div class="editorial-card p-6 space-y-4">
                <h3 class="font-bold text-[#111111] text-sm border-b-2 border-[#111111] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-[#166534]" aria-hidden="true"></i> Histori Presensi Latihan
                </h3>

                @if($attendances->count() > 0)
                    <div class="space-y-2">
                        @foreach($attendances as $att)
                            <div class="flex justify-between items-center p-3 bg-[#F4F4F4] border-2 border-[#111111] text-xs">
                                <span class="font-mono font-bold text-[#111111]">{{ date('d M Y', strtotime($att->date)) }}</span>
                                @if($att->status == 'hadir')
                                    <span class="badge-success uppercase font-mono">Hadir</span>
                                @elseif($att->status == 'izin')
                                    <span class="badge-secondary uppercase font-mono">Izin</span>
                                @elseif($att->status == 'sakit')
                                    <span class="badge-primary uppercase font-mono">Sakit</span>
                                @else
                                    <span class="badge-danger uppercase font-mono">{{ $att->status }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-[#525252] py-4 text-center border-2 border-dashed border-[#111111]">Belum ada data presensi latihan.</p>
                @endif
            </div>

        </div>

        <!-- Right Col: RADAR CHART RAPOR EVALUASI PERFORMA (7 Cols) -->
        <div class="lg:col-span-7 editorial-card p-6 space-y-6">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
                <div>
                    <h3 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-[#0000FF]" aria-hidden="true"></i> Diagram Radar Rapor Performa Pemain
                    </h3>
                    <p class="text-xs text-[#525252]">Spesifikasi evaluasi teknik dan fisik dari SSB Mekar Jaya.</p>
                </div>
                <a href="{{ route('admin.evaluations.edit', $player->id) }}" class="btn-primary text-xs py-2 px-4">
                    Update Nilai
                </a>
            </div>

            <!-- Radar Chart Container -->
            <div class="h-72 relative flex items-center justify-center bg-white">
                <canvas id="radarEvaluationChart"></canvas>
            </div>

            <!-- Score breakdown grid -->
            @if($evaluation)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 border-t-2 border-[#111111] pt-4 text-xs">
                    <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                        <span class="text-[#525252] block text-[11px] font-bold">Passing / Operan</span>
                        <span class="text-2xl font-bold text-[#111111] font-mono">{{ $evaluation->passing_score }}</span>
                    </div>
                    <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                        <span class="text-[#525252] block text-[11px] font-bold">Dribbling / Giring</span>
                        <span class="text-2xl font-bold text-[#111111] font-mono">{{ $evaluation->dribbling_score }}</span>
                    </div>
                    <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                        <span class="text-[#525252] block text-[11px] font-bold">Shooting / Tendangan</span>
                        <span class="text-2xl font-bold text-[#111111] font-mono">{{ $evaluation->shooting_score }}</span>
                    </div>
                    <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                        <span class="text-[#525252] block text-[11px] font-bold">Fisik & Ketahanan</span>
                        <span class="text-2xl font-bold text-[#111111] font-mono">{{ $evaluation->physical_score }}</span>
                    </div>
                    <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                        <span class="text-[#525252] block text-[11px] font-bold">Kedisiplinan</span>
                        <span class="text-2xl font-bold text-[#0000FF] font-mono">{{ $evaluation->discipline_score }}</span>
                    </div>
                    <div class="bg-[#F4F4F4] p-3.5 border-2 border-[#111111] text-center">
                        <span class="text-[#525252] block text-[11px] font-bold">Pemahaman Taktik</span>
                        <span class="text-2xl font-bold text-[#111111] font-mono">{{ $evaluation->tactical_score }}</span>
                    </div>
                </div>

                @if($evaluation->coach_notes)
                    <div class="bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] p-4 text-xs text-[#111111] space-y-1">
                        <span class="font-mono font-bold block text-[#111111] uppercase tracking-wider">Catatan Evaluasi Pelatih</span>
                        <p class="text-[#525252] text-sm">"{{ $evaluation->coach_notes }}"</p>
                    </div>
                @endif
            @endif

        </div>

    </div>

    @include('admin.evaluations._history_panel', [
        'evaluations' => $evaluations,
        'evaluationTrend' => $evaluationTrend,
        'chartId' => 'progressEvaluationChart',
    ])

    <!-- SPP Payment Recording & Ledger Section -->
    <div id="spp-section" class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Form: Record SPP Payment (5 Cols) -->
        <div class="lg:col-span-5 no-print editorial-card p-6 border-t-[6px] border-t-[#FF0000] space-y-5">
            <div class="flex items-start justify-between gap-3 border-b-2 border-[#111111] pb-3.5">
                <div>
                    <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-[#CC0000]" aria-hidden="true"></i> Catat Pembayaran SPP
                    </h3>
                    <p class="text-xs text-[#525252] mt-0.5">
                        Tarif standar kelompok umur: <strong class="font-mono text-[#111111]">Rp {{ number_format($player->default_monthly_fee, 0, ',', '.') }}</strong>/bulan
                    </p>
                </div>
                @if($player->current_spp_status == 'Lunas')
                    <span class="badge-success font-mono shrink-0">Lunas</span>
                @else
                    <span class="badge-danger font-mono shrink-0">Belum Bayar</span>
                @endif
            </div>

            <form action="{{ route('admin.players.spp-payments.store', $player->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="periode_bulan" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Periode Bulan *</label>
                        <select id="periode_bulan" name="periode_bulan" required class="ds-input text-sm font-semibold">
                            @foreach(\App\Models\SppPayment::MONTHS_ID as $mNum => $mName)
                                <option value="{{ $mNum }}" {{ (int) old('periode_bulan', now()->month) === $mNum ? 'selected' : '' }}>
                                    {{ $mName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="periode_tahun" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tahun *</label>
                        <input type="number" id="periode_tahun" name="periode_tahun" min="2020" max="2099" required
                               value="{{ old('periode_tahun', now()->year) }}"
                               class="ds-input text-sm font-mono font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="jumlah" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nominal (Rp) *</label>
                        <input type="number" id="jumlah" name="jumlah" min="1000" step="1000" required
                               value="{{ old('jumlah', $player->default_monthly_fee) }}"
                               class="ds-input text-sm font-mono font-bold">
                    </div>
                    <div>
                        <label for="tanggal_bayar" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Bayar *</label>
                        <input type="date" id="tanggal_bayar" name="tanggal_bayar" required
                               value="{{ old('tanggal_bayar', now()->toDateString()) }}"
                               class="ds-input text-sm font-mono">
                    </div>
                </div>

                <div>
                    <label for="metode" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Metode Pembayaran *</label>
                    <select id="metode" name="metode" required class="ds-input text-sm font-semibold">
                        <option value="tunai" {{ old('metode', 'tunai') == 'tunai' ? 'selected' : '' }}>Tunai (Sekretariat / Lapangan)</option>
                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>Transfer Bank / QRIS</option>
                    </select>
                </div>

                <div>
                    <label for="keterangan" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Keterangan (Opsional)</label>
                    <input type="text" id="keterangan" name="keterangan" maxlength="255"
                           value="{{ old('keterangan') }}"
                           placeholder="Contoh: Diterima via transfer a.n. Orang Tua"
                           class="ds-input text-sm">
                </div>

                <button type="submit" class="w-full btn-primary text-xs py-3 font-bold">
                    <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Simpan Pembayaran SPP
                </button>
            </form>
        </div>

        <!-- Right Table: SPP Payment History Ledger (7 Cols) -->
        <div class="lg:col-span-7 editorial-card p-6 border-t-[6px] border-t-[#0000FF] space-y-5">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b-2 border-[#111111] pb-3.5">
                <div>
                    <h3 class="font-bold text-[#111111] text-base flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-[#0000FF]" aria-hidden="true"></i> Riwayat Pembayaran SPP
                    </h3>
                    <p class="text-xs text-[#525252] mt-0.5">Catatan historis iuran bulanan siswa per periode.</p>
                </div>
                <div class="px-3 py-1.5 bg-[#111111] text-[#FFFF00] font-mono text-xs font-bold border border-[#111111]">
                    Total: Rp {{ number_format($sppPayments->sum('jumlah'), 0, ',', '.') }}
                </div>
            </div>

            @if($sppPayments->count() > 0)
                <div class="overflow-x-auto border-2 border-[#111111]">
                    <table class="w-full text-left border-collapse text-xs text-[#111111]">
                        <thead>
                            <tr class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                                <th class="p-3.5">Periode</th>
                                <th class="p-3.5">Tanggal Bayar</th>
                                <th class="p-3.5">Nominal</th>
                                <th class="p-3.5">Metode</th>
                                <th class="p-3.5">Catatan</th>
                                <th class="no-print p-3.5 text-right">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-[#111111] bg-white">
                            @foreach($sppPayments as $payment)
                                <tr class="hover:bg-[#F4F4F4] transition-colors">
                                    <td class="p-3.5 font-bold font-mono">
                                        {{ $payment->period_label }}
                                        @if($payment->periode_bulan === (int) now()->month && $payment->periode_tahun === (int) now()->year)
                                            <span class="block text-[10px] text-[#14532D] uppercase mt-0.5">Bulan Berjalan</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 font-mono text-[#525252]">
                                        {{ $payment->tanggal_bayar->format('d M Y') }}
                                    </td>
                                    <td class="p-3.5 font-mono font-bold text-[#14532D]">
                                        {{ $payment->formatted_jumlah }}
                                    </td>
                                    <td class="p-3.5">
                                        @if($payment->metode === 'transfer')
                                            <span class="badge-blue font-mono uppercase text-[10px]">Transfer</span>
                                        @else
                                            <span class="badge-secondary font-mono uppercase text-[10px]">Tunai</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-[#525252]">
                                        {{ $payment->keterangan ?? '-' }}
                                    </td>
                                    <td class="no-print p-3.5 text-right">
                                        <form action="{{ route('admin.players.spp-payments.destroy', [$player->id, $payment->id]) }}" method="POST"
                                              onsubmit="return confirm('Hapus catatan pembayaran SPP periode {{ $payment->period_label }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="Hapus pembayaran periode {{ $payment->period_label }}"
                                                    class="w-11 h-11 bg-white text-[#991B1B] hover:bg-[#FF0000] hover:text-[#000000] border-2 border-[#111111] inline-flex items-center justify-center transition-colors cursor-pointer">
                                                <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center border-2 border-dashed border-[#111111] bg-[#F4F4F4] space-y-2">
                    <i class="fa-solid fa-file-invoice text-2xl text-[#525252]" aria-hidden="true"></i>
                    <p class="text-xs font-bold text-[#111111]">Belum Ada Riwayat Pembayaran SPP</p>
                    <p class="text-xs text-[#525252]">Gunakan formulir di sebelah kiri untuk mencatat pembayaran SPP siswa ini.</p>
                </div>
            @endif
        </div>

    </div>

</div>

<!-- Chart.js Radar Chart Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('radarEvaluationChart').getContext('2d');

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Passing', 'Dribbling', 'Shooting', 'Fisik', 'Kedisiplinan', 'Taktik'],
                datasets: [{
                    label: 'Performa {{ $player->nickname ?? $player->full_name }}',
                    data: [
                        {{ $evaluation->passing_score ?? 75 }},
                        {{ $evaluation->dribbling_score ?? 75 }},
                        {{ $evaluation->shooting_score ?? 75 }},
                        {{ $evaluation->physical_score ?? 75 }},
                        {{ $evaluation->discipline_score ?? 80 }},
                        {{ $evaluation->tactical_score ?? 70 }}
                    ],
                    backgroundColor: 'rgba(0, 0, 255, 0.14)',
                    borderColor: '#0000FF',
                    borderWidth: 2,
                    pointBackgroundColor: '#FF0000',
                    pointBorderColor: '#111111',
                    pointBorderWidth: 1.5,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    r: {
                        angleLines: { color: '#D4D4D4' },
                        grid: { color: '#E5E5E5' },
                        pointLabels: {
                            color: '#111111',
                            font: { family: 'Helvetica, Arial, sans-serif', weight: '700', size: 12 }
                        },
                        suggestedMin: 50,
                        suggestedMax: 100,
                        ticks: { stepSize: 10, color: '#525252' }
                    }
                }
            }
        });
    });
</script>

@endsection
