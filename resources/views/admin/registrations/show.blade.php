@extends('layouts.admin')

@section('title', 'Detail Calon Siswa - ' . $registration->full_name)
@section('page-header', 'Detail Permohonan Pendaftaran Calon Siswa')

@section('content')

<div class="space-y-6">

    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <a href="{{ route('admin.registrations.index') }}"
           class="min-h-[44px] px-4 py-2 bg-white hover:bg-[#FFFF00] text-[#111111] border-2 border-[#111111] text-xs font-mono font-bold inline-flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Kembali ke Daftar Permohonan</span>
        </a>

        <div class="flex flex-wrap items-center gap-2">
            @if($registration->status == 'pending')
                <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran {{ addslashes($registration->full_name) }}? Calon siswa akan resmi masuk ke data pemain aktif.')"
                            class="min-h-[44px] px-5 py-2 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 transition-colors cursor-pointer">
                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                        <span>Setujui Pendaftaran</span>
                    </button>
                </form>

                <button type="button"
                        onclick="openRejectModal({{ $registration->id }}, '{{ addslashes($registration->full_name) }}', '{{ $registration->registration_code }}')"
                        class="min-h-[44px] px-4 py-2 bg-[#CC0000] hover:bg-[#991B1B] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    <span>Tolak Pendaftaran</span>
                </button>
            @elseif($registration->status == 'rejected')
                @if(!empty($waPayload['url']))
                    <a href="{{ $waPayload['url'] }}" target="_blank" rel="noopener noreferrer"
                       class="min-h-[44px] px-4 py-2 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i>
                        <span>Kirim Pesan Alasan ke WA Ortu</span>
                    </a>
                @endif
            @else
                @if(!empty($waPayload['url']))
                    <a href="{{ $waPayload['url'] }}" target="_blank" rel="noopener noreferrer"
                       class="min-h-[44px] px-4 py-2 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i>
                        <span>Kirim Konfirmasi Kelulusan WA</span>
                    </a>
                @endif
                @if($matchedPlayer)
                    <a href="{{ route('admin.players.show', $matchedPlayer->id) }}"
                       class="min-h-[44px] px-4 py-2 bg-[#0000FF] hover:bg-[#0000CC] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 transition-colors">
                        <i class="fa-solid fa-id-card" aria-hidden="true"></i>
                        <span>Buka Profil Pemain</span>
                    </a>
                @endif
            @endif

            <a href="https://wa.me/{{ $registration->clean_parent_phone }}" target="_blank" rel="noopener noreferrer"
               class="min-h-[44px] px-4 py-2 bg-[#FFFF00] hover:bg-[#E6E600] text-[#111111] border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 transition-colors">
                <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i>
                <span>Chat WA Orang Tua</span>
            </a>
        </div>
    </div>

    <!-- Top Candidate Banner (De Stijl Abstrato Header) -->
    <div class="bg-[#111111] text-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#FFFFFF]" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center gap-5">
                <div class="w-16 h-16 bg-[#0000FF] text-white font-mono font-bold text-3xl flex items-center justify-center border-2 border-[#FFFFFF] shrink-0">
                    {{ strtoupper(substr($registration->full_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-white">{{ $registration->full_name }}</h2>
                        <span class="px-2.5 py-0.5 bg-[#FFFF00] text-[#111111] border border-[#FFFFFF] font-mono font-bold text-xs uppercase">
                            {{ $registration->position_preference }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 mt-2 text-xs font-mono">
                        <span class="text-[#FFFF00] font-bold">KODE: {{ $registration->registration_code }}</span>
                        <span class="text-[#D4D4D4]">&bull;</span>
                        <span class="text-[#D4D4D4]">Masuk: {{ $registration->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                        <span class="px-3 py-1 bg-[#181818] text-[#FFFF00] font-mono font-bold border border-[#525252]">
                            Lahir {{ $registration->birth_year }} (Usia {{ $registration->age }} Thn)
                        </span>
                        <span class="px-3 py-1 bg-[#181818] text-white font-mono border border-[#525252]">
                            {{ $registration->age_category_badge }}
                        </span>
                        @if($registration->jersey_size)
                            <span class="px-3 py-1 bg-[#181818] text-white font-mono border border-[#525252]">
                                Jersey: <strong class="text-[#FFFF00]">{{ $registration->jersey_size }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-start lg:items-end gap-2 shrink-0">
                <span class="text-[11px] font-mono uppercase tracking-wider text-[#A3A3A3]">Status Permohonan:</span>
                @if($registration->status == 'pending')
                    <span class="badge-primary uppercase font-mono text-sm px-3.5 py-1.5">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5" aria-hidden="true"></i> Pending Verifikasi
                    </span>
                @elseif($registration->status == 'approved')
                    <span class="badge-success uppercase font-mono text-sm px-3.5 py-1.5">
                        <i class="fa-solid fa-circle-check mr-1.5" aria-hidden="true"></i> Disetujui
                    </span>
                @else
                    <span class="badge-danger uppercase font-mono text-sm px-3.5 py-1.5">
                        <i class="fa-solid fa-circle-xmark mr-1.5" aria-hidden="true"></i> Ditolak
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Callouts -->
    @if($registration->status == 'rejected' && $registration->rejection_notes)
        <div class="bg-[#FEF2F2] border-2 border-[#CC0000] p-5 shadow-[0_2px_8px_rgba(0,0,0,0.08)] space-y-2">
            <div class="flex items-center gap-2 text-[#991B1B] font-bold text-sm uppercase tracking-wider font-mono">
                <i class="fa-solid fa-triangle-exclamation text-base" aria-hidden="true"></i>
                <span>Catatan / Alasan Penolakan Pendaftaran</span>
            </div>
            <p class="text-sm text-[#7F1D1D] leading-relaxed font-sans bg-white p-3 border border-[#FCA5A5]">
                {{ $registration->rejection_notes }}
            </p>
            <p class="text-[11px] font-mono text-[#991B1B]">
                Catatan di atas telah otomatis disiapkan ke dalam format pesan WhatsApp pemberitahuan penolakan untuk orang tua/wali siswa.
            </p>
        </div>
    @elseif($registration->status == 'approved')
        <div class="bg-[#F0FDF4] border-2 border-[#166534] p-5 shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-[#166534] font-bold text-sm uppercase tracking-wider font-mono">
                    <i class="fa-solid fa-circle-check text-base" aria-hidden="true"></i>
                    <span>Pendaftaran Telah Disetujui</span>
                </div>
                <p class="text-xs text-[#14532D]">
                    Calon siswa telah resmi menjadi pemain aktif SSB Mekar Jaya Subang.
                    @if($matchedPlayer)
                        Nomor Induk Siswa (NIS): <strong class="font-mono">{{ $matchedPlayer->nis }}</strong>.
                    @endif
                </p>
            </div>
            @if($matchedPlayer)
                <a href="{{ route('admin.players.show', $matchedPlayer->id) }}"
                   class="min-h-[40px] px-4 py-2 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-2 self-start sm:self-auto transition-colors">
                    <span>Lihat Profil &amp; Rapor Siswa</span>
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            @endif
        </div>
    @endif

    <!-- MAIN GRID: Medical History & Biometrics & Bio & Documents -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Health & Biometrics & Identity (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- FOCUSED SECTION: CATATAN RIWAYAT KESEHATAN & PENYAKIT -->
            <div class="bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="p-4 sm:p-5 border-b-2 border-[#111111] bg-[#111111] text-white flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-[#CC0000] text-white flex items-center justify-center border border-white font-mono shrink-0">
                            <i class="fa-solid fa-notes-medical text-sm" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm sm:text-base leading-tight uppercase font-mono tracking-wider">
                                Catatan Riwayat Kesehatan &amp; Penyakit
                            </h3>
                            <span class="text-[11px] text-[#D4D4D4] font-sans">Informasi kondisi medis dan pantangan calon atlet</span>
                        </div>
                    </div>

                    @if(!empty($registration->health_notes) && trim($registration->health_notes) !== '' && strtolower(trim($registration->health_notes)) !== 'sehat' && strtolower(trim($registration->health_notes)) !== 'tidak ada')
                        <span class="px-2.5 py-1 bg-[#CC0000] text-white border border-white font-mono text-[11px] font-bold uppercase shrink-0">
                            Perlu Perhatian
                        </span>
                    @else
                        <span class="px-2.5 py-1 bg-[#166534] text-white border border-white font-mono text-[11px] font-bold uppercase shrink-0">
                            Kondisi Baik
                        </span>
                    @endif
                </div>

                <div class="p-5 sm:p-6 space-y-4">
                    @if(!empty($registration->health_notes) && trim($registration->health_notes) !== '')
                        <div class="p-4 bg-[#FFFBEB] border-2 border-[#111111] border-l-[6px] border-l-[#CC0000] space-y-2">
                            <span class="text-[11px] font-mono uppercase tracking-wider text-[#92400E] font-bold block">
                                Deskripsi Riwayat Medis / Penyakit yang Dilaporkan:
                            </span>
                            <div class="text-sm sm:text-base text-[#111111] leading-relaxed font-sans font-medium whitespace-pre-line bg-white p-3.5 border border-[#D4D4D4]">
                                {{ $registration->health_notes }}
                            </div>
                        </div>

                        <div class="p-3 bg-[#F4F4F4] border-2 border-[#111111] flex items-start gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-[#CC0000] text-base shrink-0 mt-0.5" aria-hidden="true"></i>
                            <p class="text-xs text-[#525252] leading-relaxed">
                                <strong class="text-[#111111]">Instruksi Pelatih Fisik &amp; Medis:</strong> Harap verifikasi kembali riwayat kondisi fisik ini dengan orang tua saat tes fisik awal, terutama mengenai porsi lari endurance, riwayat asma, alergi obat, atau cedera sendi/tulang yang pernah dialami.
                            </p>
                        </div>
                    @else
                        <div class="p-5 bg-[#F0FDF4] border-2 border-[#166534] flex items-start gap-3.5">
                            <div class="w-9 h-9 bg-[#166534] text-white border border-[#111111] flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-circle-check text-base" aria-hidden="true"></i>
                            </div>
                            <div class="space-y-1">
                                <p class="font-bold text-sm text-[#14532D]">Tidak Ada Catatan Riwayat Penyakit Khusus</p>
                                <p class="text-xs text-[#166534] leading-relaxed">
                                    Orang tua/wali menyatakan calon siswa dalam kondisi fisik sehat dan tidak memiliki catatan penyakit kronis, alergi khusus, ataupun riwayat cedera berat pada formulir pendaftaran.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BIODATA CALON SISWA -->
            <div class="bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="p-4 sm:p-5 border-b-2 border-[#111111] bg-[#F4F4F4] flex items-center justify-between gap-3">
                    <h3 class="font-bold text-sm uppercase tracking-wider font-mono text-[#111111] flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-[#0000FF]" aria-hidden="true"></i>
                        Biodata Lengkap Calon Siswa
                    </h3>
                    <span class="text-xs font-mono text-[#525252]">Data Pendaftaran Online</span>
                </div>

                <div class="p-5 sm:p-6 divide-y-2 divide-[#F4F4F4]">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-3 first:pt-0">
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] uppercase block">Nama Lengkap Siswa</span>
                            <span class="font-bold text-sm text-[#111111]">{{ $registration->full_name }}</span>
                        </div>
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] uppercase block">Kode Pendaftaran</span>
                            <span class="font-mono font-bold text-sm text-[#CC0000]">{{ $registration->registration_code }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-3">
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] uppercase block">Tempat, Tanggal Lahir</span>
                            <span class="font-bold text-sm text-[#111111]">
                                {{ $registration->birth_place }}, {{ $registration->birth_date->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] uppercase block">Usia &amp; Kelompok Umur (KU)</span>
                            <span class="font-bold text-sm text-[#111111]">
                                {{ $registration->age }} Tahun &bull; <span class="font-mono text-[#0000FF]">{{ $registration->age_category_badge }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-3">
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] uppercase block">Posisi Bermain Favorit</span>
                            <span class="inline-block mt-1 px-2.5 py-0.5 bg-[#FFFF00] text-[#111111] border border-[#111111] font-bold text-xs">
                                {{ $registration->position_preference }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-mono text-[#525252] uppercase block">Asal Sekolah Siswa</span>
                            <span class="font-bold text-sm text-[#111111]">{{ $registration->school_name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="py-3 last:pb-0">
                        <span class="text-[11px] font-mono text-[#525252] uppercase block">Alamat Tempat Tinggal</span>
                        <p class="font-medium text-sm text-[#111111] leading-relaxed mt-0.5">
                            {{ $registration->address ?? 'Alamat belum dilengkapi' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- DATA FISIK & POSTUR ATLET -->
            <div class="bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="p-4 sm:p-5 border-b-2 border-[#111111] bg-[#F4F4F4] flex items-center justify-between gap-3">
                    <h3 class="font-bold text-sm uppercase tracking-wider font-mono text-[#111111] flex items-center gap-2">
                        <i class="fa-solid fa-child-reaching text-[#CC0000]" aria-hidden="true"></i>
                        Postur Fisik &amp; Ukuran Jersey Tim
                    </h3>
                    <button type="button" onclick="openJerseyModal()"
                            class="text-xs text-[#0000FF] hover:underline font-mono font-bold inline-flex items-center gap-1 cursor-pointer">
                        <i class="fa-solid fa-ruler-combined text-[11px]" aria-hidden="true"></i> Panduan Ukuran
                    </button>
                </div>

                <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 bg-[#F4F4F4] border-2 border-[#111111] text-center space-y-1">
                        <span class="text-[11px] font-mono uppercase text-[#525252] block">Tinggi Badan</span>
                        <span class="text-2xl font-bold font-mono text-[#111111] block">
                            {{ $registration->height_cm ? $registration->height_cm . ' cm' : '-' }}
                        </span>
                        <span class="text-[10px] text-[#525252] block">Postur Vertikal</span>
                    </div>

                    <div class="p-4 bg-[#F4F4F4] border-2 border-[#111111] text-center space-y-1">
                        <span class="text-[11px] font-mono uppercase text-[#525252] block">Berat Badan</span>
                        <span class="text-2xl font-bold font-mono text-[#111111] block">
                            {{ $registration->weight_kg ? $registration->weight_kg . ' kg' : '-' }}
                        </span>
                        <span class="text-[10px] text-[#525252] block">Massa Tubuh</span>
                    </div>

                    <div class="p-4 bg-[#FFFF00] border-2 border-[#111111] text-center space-y-1">
                        <span class="text-[11px] font-mono uppercase text-[#111111] font-bold block">Ukuran Jersey</span>
                        <span class="text-2xl font-bold font-mono text-[#111111] block">
                            Size {{ $registration->jersey_size ?? 'M' }}
                        </span>
                        <span class="text-[10px] text-[#111111] font-medium block">Pilihan Pendaftaran</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Parents, Documents, Metadata (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">

            <!-- KONTAK ORANG TUA / WALI -->
            <div class="bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="p-4 sm:p-5 border-b-2 border-[#111111] bg-[#111111] text-white flex items-center justify-between gap-3">
                    <h3 class="font-bold text-sm uppercase tracking-wider font-mono flex items-center gap-2">
                        <i class="fa-solid fa-users text-[#FFFF00]" aria-hidden="true"></i>
                        Orang Tua / Wali
                    </h3>
                    <span class="text-xs font-mono text-[#D4D4D4]">Kontak Langsung</span>
                </div>

                <div class="p-5 sm:p-6 space-y-4">
                    <div class="space-y-1">
                        <span class="text-[11px] font-mono uppercase text-[#525252] block">Nama Orang Tua / Wali Siswa:</span>
                        <p class="text-base font-bold text-[#111111]">{{ $registration->parent_name }}</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[11px] font-mono uppercase text-[#525252] block">Nomor WhatsApp / Telepon:</span>
                        <p class="text-base font-bold font-mono text-[#166534]">{{ $registration->parent_phone }}</p>
                    </div>

                    <div class="pt-2 flex flex-col gap-2">
                        <a href="https://wa.me/{{ $registration->clean_parent_phone }}" target="_blank" rel="noopener noreferrer"
                           class="w-full min-h-[44px] px-4 py-2.5 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center justify-center gap-2 transition-colors">
                            <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                            <span>Chat WhatsApp Orang Tua</span>
                        </a>

                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $registration->parent_phone) }}"
                           class="w-full min-h-[44px] px-4 py-2.5 bg-white hover:bg-[#F4F4F4] text-[#111111] border-2 border-[#111111] text-xs font-bold inline-flex items-center justify-center gap-2 transition-colors">
                            <i class="fa-solid fa-phone text-xs" aria-hidden="true"></i>
                            <span>Hubungi via Panggilan Telepon</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- DOKUMEN KARTU KELUARGA (KK) -->
            <div class="bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                <div class="p-4 sm:p-5 border-b-2 border-[#111111] bg-[#F4F4F4] flex items-center justify-between gap-3">
                    <h3 class="font-bold text-sm uppercase tracking-wider font-mono text-[#111111] flex items-center gap-2">
                        <i class="fa-solid fa-file-contract text-[#0000FF]" aria-hidden="true"></i>
                        Dokumen Kartu Keluarga (KK)
                    </h3>
                    @if($registration->kk_document)
                        <span class="badge-success text-[10px] font-mono uppercase">Terlampir</span>
                    @else
                        <span class="badge-danger text-[10px] font-mono uppercase">Belum Diunggah</span>
                    @endif
                </div>

                <div class="p-5 sm:p-6 space-y-4">
                    @if($registration->kk_document)
                        @php
                            $isImage = in_array(strtolower(pathinfo($registration->kk_document, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp']);
                        @endphp

                        @if($isImage)
                            <div class="border-2 border-[#111111] overflow-hidden bg-[#F4F4F4] max-h-72 flex items-center justify-center">
                                <img src="{{ asset('storage/' . $registration->kk_document) }}"
                                     alt="Dokumen KK {{ $registration->full_name }}"
                                     class="w-full h-auto max-h-72 object-contain hover:scale-105 transition-transform duration-200">
                            </div>
                        @else
                            <div class="p-6 border-2 border-[#111111] bg-[#F4F4F4] text-center space-y-2">
                                <i class="fa-solid fa-file-pdf text-4xl text-[#CC0000]" aria-hidden="true"></i>
                                <p class="text-xs font-mono font-bold text-[#111111]">Dokumen Berkas (PDF / Non-Image)</p>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ asset('storage/' . $registration->kk_document) }}" target="_blank" rel="noopener noreferrer"
                               class="flex-1 min-h-[44px] px-3 py-2 bg-[#FFFF00] hover:bg-[#E6E600] text-[#111111] border-2 border-[#111111] text-xs font-bold inline-flex items-center justify-center gap-1.5 transition-colors">
                                <i class="fa-solid fa-up-right-from-square text-xs" aria-hidden="true"></i>
                                <span>Buka Dokumen Penuh</span>
                            </a>
                            <a href="{{ asset('storage/' . $registration->kk_document) }}" download
                               class="min-h-[44px] px-4 py-2 bg-white hover:bg-[#F4F4F4] text-[#111111] border-2 border-[#111111] text-xs font-bold inline-flex items-center justify-center gap-1.5 transition-colors">
                                <i class="fa-solid fa-download text-xs" aria-hidden="true"></i>
                                <span>Unduh</span>
                            </a>
                        </div>

                        <p class="text-[11px] text-[#525252] leading-tight font-sans">
                            Dokumen ini dijaga kerahasiaannya sesuai ketentuan UU PDP Nomor 27 Tahun 2022 dan hanya digunakan untuk verifikasi data usia/KU siswa.
                        </p>
                    @else
                        <div class="p-6 bg-[#FEF2F2] border-2 border-[#CC0000] text-center space-y-2">
                            <i class="fa-solid fa-triangle-exclamation text-3xl text-[#CC0000]" aria-hidden="true"></i>
                            <p class="text-sm font-bold text-[#991B1B]">Dokumen KK Belum Diunggah</p>
                            <p class="text-xs text-[#7F1D1D] leading-relaxed">
                                Calon pendaftar tidak melampirkan foto/file Kartu Keluarga saat mengisi formulir. Hubungi orang tua via WhatsApp untuk meminta foto KK demi validasi KU siswa.
                            </p>
                            <a href="https://wa.me/{{ $registration->clean_parent_phone }}?text={{ rawurlencode('Halo Bapak/Ibu ' . $registration->parent_name . ', mohon dapat mengirimkan foto Kartu Keluarga (KK) calon siswa ananda ' . $registration->full_name . ' untuk melengkapi berkas pendaftaran SSB Mekar Jaya Subang. Terima kasih.') }}"
                               target="_blank" rel="noopener noreferrer"
                               class="mt-2 min-h-[40px] px-3 py-2 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center justify-center gap-1.5 transition-colors">
                                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                <span>Minta Dokumen via WhatsApp</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- METADATA PERMOHONAN -->
            <div class="bg-white border-2 border-[#111111] p-5 shadow-[0_2px_8px_rgba(0,0,0,0.08)] space-y-3">
                <h4 class="font-bold text-xs uppercase tracking-wider font-mono text-[#525252]">Informasi Sistem Pendaftaran</h4>
                <div class="text-xs font-mono space-y-2">
                    <div class="flex items-center justify-between border-b border-[#F4F4F4] pb-1.5">
                        <span class="text-[#525252]">ID Record:</span>
                        <span class="font-bold text-[#111111]">#{{ $registration->id }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-[#F4F4F4] pb-1.5">
                        <span class="text-[#525252]">Waktu Submit:</span>
                        <span class="font-bold text-[#111111]">{{ $registration->created_at->format('Y-m-d H:i:s') }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-[#F4F4F4] pb-1.5">
                        <span class="text-[#525252]">Pembaruan Terakhir:</span>
                        <span class="font-bold text-[#111111]">{{ $registration->updated_at->format('Y-m-d H:i:s') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#525252]">Persetujuan S&amp;K:</span>
                        <span class="font-bold text-[#166534]">Menyetujui (Checked)</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- REJECTION REASON DIALOG MODAL -->
<dialog id="reject-registration-modal" aria-labelledby="reject-modal-title" closedby="any"
        class="fixed inset-0 z-[300] m-auto w-[calc(100%-2rem)] max-w-lg p-0 bg-white border-2 border-[#111111] text-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex-col overflow-hidden">

    <div class="grid grid-cols-12 h-2 border-b-2 border-[#111111] shrink-0" aria-hidden="true">
        <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
        <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
        <div class="col-span-3 bg-[#FFFF00]"></div>
    </div>

    <div class="p-5 border-b-2 border-[#111111] flex items-start justify-between gap-3 bg-white shrink-0">
        <div class="space-y-0.5">
            <span class="text-xs font-mono font-bold text-[#CC0000] uppercase tracking-wider block">Verifikasi Pendaftaran</span>
            <h3 id="reject-modal-title" class="font-bold text-[#111111] text-base sm:text-lg">
                Tolak Pendaftaran Calon Siswa
            </h3>
        </div>
        <button type="button" onclick="closeRejectModal()" aria-label="Tutup dialog penolakan"
                class="w-10 h-10 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] flex items-center justify-center transition-colors cursor-pointer">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>

    <form id="reject-registration-form" action="{{ route('admin.registrations.reject', $registration->id) }}" method="POST" class="p-5 space-y-4 bg-white text-xs">
        @csrf

        <div class="p-3 bg-[#F4F4F4] border-2 border-[#111111] space-y-1">
            <span class="text-[10px] font-mono uppercase text-[#525252] block">Calon Siswa:</span>
            <div class="font-bold text-sm text-[#111111]" id="reject-modal-player-name">{{ $registration->full_name }}</div>
            <div class="text-xs font-mono text-[#CC0000] font-bold" id="reject-modal-reg-code">{{ $registration->registration_code }}</div>
        </div>

        <div>
            <label for="reject-notes-input" class="block font-bold text-[#111111] uppercase tracking-wider mb-1.5">
                Alasan / Catatan Penolakan (Akan Masuk ke Pesan WhatsApp):
            </label>
            <textarea id="reject-notes-input" name="rejection_notes" rows="3" maxlength="500"
                      placeholder="Contoh: Berkas foto KK buram/tidak terbaca. Mohon kirimkan ulang foto KK yang jelas."
                      class="ds-input text-xs leading-relaxed"></textarea>
        </div>

        <div class="space-y-1.5">
            <span class="text-[10px] uppercase font-mono font-bold text-[#525252] block">Pilihan Alasan Cepat (Klik untuk memilih):</span>
            <div class="flex flex-wrap gap-1.5">
                <button type="button" onclick="setRejectPreset('Foto dokumen KK buram atau tidak terbaca dengan jelas. Mohon kirimkan foto ulang yang jelas.')"
                        class="px-2.5 py-1 bg-white hover:bg-[#FFFF00] text-[#111111] border border-[#111111] text-[11px] font-medium transition-colors cursor-pointer">
                    Foto KK Buram
                </button>
                <button type="button" onclick="setRejectPreset('Tahun lahir calon siswa tidak sesuai dengan kuota Kelompok Umur (KU) yang tersedia.')"
                        class="px-2.5 py-1 bg-white hover:bg-[#FFFF00] text-[#111111] border border-[#111111] text-[11px] font-medium transition-colors cursor-pointer">
                    Usia Tidak Sesuai KU
                </button>
                <button type="button" onclick="setRejectPreset('Kuota pendaftaran untuk kelompok umur ini telah penuh untuk musim latihan berjalan.')"
                        class="px-2.5 py-1 bg-white hover:bg-[#FFFF00] text-[#111111] border border-[#111111] text-[11px] font-medium transition-colors cursor-pointer">
                    Kuota KU Penuh
                </button>
                <button type="button" onclick="setRejectPreset('Data nomor kontak WhatsApp orang tua tidak dapat dihubungi atau tidak valid.')"
                        class="px-2.5 py-1 bg-white hover:bg-[#FFFF00] text-[#111111] border border-[#111111] text-[11px] font-medium transition-colors cursor-pointer">
                    Kontak Tidak Valid
                </button>
            </div>
        </div>

        <div class="pt-3 border-t-2 border-[#111111] flex flex-col sm:flex-row items-center justify-end gap-2.5">
            <button type="button" onclick="closeRejectModal()" class="w-full sm:w-auto btn-secondary text-xs py-2.5 px-4 cursor-pointer">
                Batal
            </button>
            <button type="submit" class="w-full sm:w-auto min-h-[44px] px-5 py-2.5 bg-[#FF0000] text-black border-2 border-[#111111] font-bold text-xs hover:bg-[#CC0000] transition-colors cursor-pointer inline-flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-xmark text-xs" aria-hidden="true"></i>
                <span>Tolak &amp; Siapkan Pesan WA</span>
            </button>
        </div>
    </form>
</dialog>

<script>
    function openRejectModal(id, name, code) {
        const modal = document.getElementById('reject-registration-modal');
        const form = document.getElementById('reject-registration-form');
        const titleName = document.getElementById('reject-modal-player-name');
        const titleCode = document.getElementById('reject-modal-reg-code');
        const notesInput = document.getElementById('reject-notes-input');

        if (!modal || !form) return;

        form.action = `/admin/registrations/${id}/reject`;
        if (titleName) titleName.textContent = name;
        if (titleCode) titleCode.textContent = code;
        if (notesInput) notesInput.value = '';

        if (typeof modal.showModal === 'function') {
            modal.showModal();
        } else {
            modal.setAttribute('open', '');
        }
    }

    function closeRejectModal() {
        const modal = document.getElementById('reject-registration-modal');
        if (!modal) return;
        if (typeof modal.close === 'function') {
            modal.close();
        } else {
            modal.removeAttribute('open');
        }
    }

    function setRejectPreset(text) {
        const notesInput = document.getElementById('reject-notes-input');
        if (notesInput) {
            notesInput.value = text;
            notesInput.focus();
        }
    }

    (function() {
        const modal = document.getElementById('reject-registration-modal');
        if (!modal || ('closedBy' in HTMLDialogElement.prototype)) return;

        const isOutside = (e) => {
            const r = modal.getBoundingClientRect();
            return e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom;
        };

        let pressedOutside = false;
        modal.addEventListener('pointerdown', (e) => {
            pressedOutside = isOutside(e);
        });
        modal.addEventListener('pointerup', (e) => {
            if (pressedOutside && isOutside(e)) {
                modal.close();
            }
            pressedOutside = false;
        });
    })();
</script>

@endsection
