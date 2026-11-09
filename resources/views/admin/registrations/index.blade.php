@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran Siswa - Mekar Jaya Sport Subang')
@section('page-header', 'Verifikasi Pendaftaran Online')

@section('content')

<div class="space-y-6">

    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 editorial-card p-6 border-l-[6px] border-l-[#FF0000]">
        <div>
            <h2 class="font-bold text-[#111111] text-base sm:text-lg flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-[#CC0000]" aria-hidden="true"></i> Permohonan Pendaftaran Siswa Baru
            </h2>
            <p class="text-xs text-[#525252] mt-0.5">Pendaftaran yang disetujui secara otomatis dikonversi menjadi data pemain aktif SSB beserta arsip Kartu Keluarga.</p>
        </div>
        <span class="badge-primary font-mono self-start sm:self-center">Verifikasi Berkas KK</span>
    </div>

    <!-- Registrations Data Table -->
    <div class="editorial-card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                    <tr>
                        <th class="p-4">Kode &amp; Nama Calon Siswa</th>
                        <th class="p-4">Tgl Lahir &amp; Usia</th>
                        <th class="p-4">Posisi Diminati</th>
                        <th class="p-4">Orang Tua / WA</th>
                        <th class="p-4">Sekolah Asal</th>
                        <th class="p-4">Dokumen KK</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-4">
                                <span class="font-bold text-[#111111] text-sm block leading-tight">{{ $reg->full_name }}</span>
                                <span class="text-xs text-[#CC0000] font-mono font-bold">{{ $reg->registration_code }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-[#111111] text-[#FFFF00] font-mono font-bold text-xs inline-block">
                                    {{ $reg->birth_year }}
                                </span>
                                <span class="text-xs text-[#111111] font-bold ml-1">({{ date('Y') - $reg->birth_year }} Thn)</span>
                                <span class="block text-[11px] font-mono text-[#525252] mt-0.5">{{ date('d M Y', strtotime($reg->birth_date)) }}</span>
                            </td>
                            <td class="p-4 font-bold text-[#111111]">
                                {{ $reg->position_preference }}
                            </td>
                            <td class="p-4">
                                <span class="block font-bold text-[#111111]">{{ $reg->parent_name }}</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->parent_phone) }}" target="_blank" class="text-xs font-mono text-[#166534] font-bold hover:underline">
                                    <i class="fa-brands fa-whatsapp mr-1" aria-hidden="true"></i> {{ $reg->parent_phone }}
                                </a>
                            </td>
                            <td class="p-4 text-[#525252]">
                                {{ $reg->school_name ?? '-' }}
                            </td>
                            <td class="p-4">
                                @if($reg->kk_document)
                                    <a href="{{ asset('storage/' . $reg->kk_document) }}" target="_blank"
                                       class="min-h-[38px] inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#FFFF00] hover:bg-[#E6E600] text-[#111111] border-2 border-[#111111] text-xs font-bold transition-colors">
                                        <i class="fa-solid fa-file-image" aria-hidden="true"></i> Lihat KK
                                    </a>
                                @else
                                    <span class="text-xs text-[#525252] font-mono">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($reg->status == 'pending')
                                    <span class="badge-primary uppercase font-mono">Pending</span>
                                @elseif($reg->status == 'approved')
                                    <span class="badge-success uppercase font-mono">Approved</span>
                                @else
                                    <span class="badge-danger uppercase font-mono">{{ $reg->status }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                @if($reg->status == 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-primary text-xs py-2 px-3 min-h-[40px]">
                                                <i class="fa-solid fa-check text-xs" aria-hidden="true"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.registrations.reject', $reg->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran ini?')">
                                            @csrf
                                            <button type="submit" class="btn-secondary text-xs py-2 px-3 min-h-[40px] text-[#991B1B] border-[#991B1B] hover:bg-[#FEE2E2]">
                                                <i class="fa-solid fa-xmark text-xs" aria-hidden="true"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs font-mono text-[#525252]">Selesai Diverifikasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-[#525252]">
                                Belum ada permohonan pendaftaran online.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-[#111111] bg-white">
            {{ $registrations->links() }}
        </div>
    </div>

</div>

@endsection
