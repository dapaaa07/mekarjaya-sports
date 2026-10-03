@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran Siswa - Mekar Jaya Sport Subang')
@section('page-header', 'Verifikasi Pendaftaran Online')

@section('content')

<div class="space-y-6">

    <!-- Header Card (Cooking App 16px Rounded Card) -->
    <div class="flex items-center justify-between editorial-card p-6">
        <div>
            <h2 class="font-extrabold text-[#111111] text-base flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-[#FF6B00]"></i> Permohonan Pendaftaran Siswa Baru
            </h2>
            <p class="text-xs text-[#666666]">Pendaftaran yang disetujui akan secara otomatis dikonversi menjadi data pemain aktif SSB.</p>
        </div>
    </div>

    <!-- Registrations Data Table -->
    <div class="editorial-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#111111]">
                <thead class="bg-[#FAFAFA] text-[#111111] font-semibold uppercase text-[11px] border-b border-[#EAEAEA]">
                    <tr>
                        <th class="p-4">Kode & Nama Calon Siswa</th>
                        <th class="p-4">Tgl Lahir & Usia</th>
                        <th class="p-4">Posisi Diminati</th>
                        <th class="p-4">Orang Tua / WA</th>
                        <th class="p-4">Sekolah Asal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAEAEA]">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                            <td class="p-4">
                                <span class="font-bold text-[#111111] text-sm block leading-tight">{{ $reg->full_name }}</span>
                                <span class="text-[11px] text-[#FF6B00] font-mono font-bold">{{ $reg->registration_code }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg bg-[#111111] text-white font-mono font-bold text-xs inline-block">
                                    {{ $reg->birth_year }}
                                </span>
                                <span class="text-xs text-[#111111] font-medium ml-1">({{ date('Y') - $reg->birth_year }} Thn)</span>
                                <span class="block text-[10px] text-[#666666]">{{ date('d M Y', strtotime($reg->birth_date)) }}</span>
                            </td>
                            <td class="p-4 font-medium text-[#111111]">
                                {{ $reg->position_preference }}
                            </td>
                            <td class="p-4">
                                <span class="block font-medium text-[#111111]">{{ $reg->parent_name }}</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->parent_phone) }}" target="_blank" class="text-[11px] text-[#16A34A] font-semibold hover:underline">
                                    <i class="fa-brands fa-whatsapp text-[#16A34A] mr-1"></i> {{ $reg->parent_phone }}
                                </a>
                            </td>
                            <td class="p-4 text-[#666666]">
                                {{ $reg->school_name ?? '-' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase {{ $reg->status == 'pending' ? 'bg-[#FFF2E8] text-[#FF6B00] border border-[#FFE0CC]' : ($reg->status == 'approved' ? 'bg-[#16A34A]/10 text-[#16A34A] border border-[#16A34A]/30' : 'bg-[#EF4444]/10 text-[#EF4444] border border-[#EF4444]/30') }}">
                                    {{ $reg->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                @if($reg->status == 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-primary text-[11px] py-1.5 px-3 rounded-xl flex items-center gap-1 font-medium shadow-sm">
                                                <i class="fa-solid fa-check text-xs"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.registrations.reject', $reg->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran ini?')">
                                            @csrf
                                            <button type="submit" class="btn-secondary text-[11px] py-1.5 px-3 rounded-xl flex items-center gap-1 text-[#EF4444] font-medium">
                                                <i class="fa-solid fa-xmark text-xs"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-[#666666] italic">Selesai Diverifikasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-[#666666]">
                                Belum ada permohonan pendaftaran online.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#EAEAEA]">
            {{ $registrations->links() }}
        </div>
    </div>

</div>

@endsection
