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
                                <a href="{{ route('admin.registrations.show', $reg->id) }}"
                                   class="font-bold text-[#111111] text-sm block leading-tight hover:text-[#0000FF] hover:underline"
                                   title="Buka detail pendaftaran {{ $reg->full_name }}">
                                    {{ $reg->full_name }}
                                </a>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-xs text-[#CC0000] font-mono font-bold">{{ $reg->registration_code }}</span>
                                    @if($reg->health_notes && strtolower(trim($reg->health_notes)) !== 'sehat' && strtolower(trim($reg->health_notes)) !== 'tidak ada')
                                        <a href="{{ route('admin.registrations.show', $reg->id) }}"
                                           class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-[#FEF2F2] border border-[#FCA5A5] text-[#991B1B] text-[9px] font-mono font-bold uppercase hover:bg-[#FEE2E2]"
                                           title="Ada riwayat medis: {{ Str::limit($reg->health_notes, 60) }}">
                                            <i class="fa-solid fa-notes-medical text-[8px]" aria-hidden="true"></i> Medis
                                        </a>
                                    @endif
                                </div>
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
                                @if($reg->height_cm || $reg->weight_kg)
                                    <span class="block text-[11px] font-mono text-[#525252] font-normal mt-0.5">
                                        {{ $reg->height_cm ? $reg->height_cm . ' cm' : '-' }} / {{ $reg->weight_kg ? $reg->weight_kg . ' kg' : '-' }}
                                    </span>
                                @endif
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
                                    <span class="badge-danger uppercase font-mono">Ditolak</span>
                                    @if($reg->rejection_notes)
                                        <div class="text-[11px] text-[#991B1B] mt-1.5 font-sans leading-tight bg-[#FEF2F2] border border-[#FCA5A5] p-2 max-w-xs">
                                            <strong class="font-mono uppercase text-[9px] block text-[#7F1D1D]">Alasan Penolakan:</strong>
                                            {{ $reg->rejection_notes }}
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                    <a href="{{ route('admin.registrations.show', $reg->id) }}"
                                       class="min-h-[38px] px-2.5 py-1.5 bg-[#FFFF00] hover:bg-[#E6E600] text-[#111111] border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-1 transition-colors"
                                       title="Lihat Detail Lengkap Pendaftaran">
                                        <i class="fa-solid fa-eye text-xs" aria-hidden="true"></i>
                                        <span>Detail</span>
                                    </a>

                                    @if($reg->status == 'pending')
                                        <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-primary text-xs py-1.5 px-2.5 min-h-[38px]" title="Setujui pendaftaran">
                                                <i class="fa-solid fa-check text-xs" aria-hidden="true"></i> Setujui
                                            </button>
                                        </form>
                                        <button type="button"
                                                onclick="openRejectModal({{ $reg->id }}, '{{ addslashes($reg->full_name) }}', '{{ $reg->registration_code }}')"
                                                class="btn-secondary text-xs py-1.5 px-2.5 min-h-[38px] text-[#991B1B] border-[#991B1B] hover:bg-[#FEE2E2] cursor-pointer"
                                                title="Tolak pendaftaran">
                                            <i class="fa-solid fa-xmark text-xs" aria-hidden="true"></i> Tolak
                                        </button>
                                    @elseif($reg->status == 'rejected')
                                        @php
                                            $waReject = \App\Notifications\RegistrationStatusUpdatedNotification::buildWaPayload($reg, 'rejected');
                                        @endphp
                                        @if(!empty($waReject['url']))
                                            <a href="{{ $waReject['url'] }}" target="_blank" rel="noopener noreferrer"
                                               class="min-h-[38px] px-2.5 py-1.5 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-1 transition-colors"
                                               title="Kirim pesan penolakan &amp; catatan ke WA orang tua">
                                                <i class="fa-brands fa-whatsapp text-xs" aria-hidden="true"></i>
                                                <span>WA Alasan</span>
                                            </a>
                                        @endif
                                    @else
                                        @php
                                            $matchedPlayer = \App\Models\Player::where('full_name', $reg->full_name)->first();
                                            $waApprove = \App\Notifications\RegistrationStatusUpdatedNotification::buildWaPayload($reg, 'approved', $matchedPlayer);
                                        @endphp
                                        @if(!empty($waApprove['url']))
                                            <a href="{{ $waApprove['url'] }}" target="_blank" rel="noopener noreferrer"
                                               class="min-h-[38px] px-2.5 py-1.5 bg-[#166534] hover:bg-[#14532D] text-white border-2 border-[#111111] text-xs font-bold inline-flex items-center gap-1 transition-colors"
                                               title="Kirim konfirmasi kelulusan siswa ke WA orang tua">
                                                <i class="fa-brands fa-whatsapp text-xs" aria-hidden="true"></i>
                                                <span>WA Ortu</span>
                                            </a>
                                        @endif
                                    @endif
                                </div>
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

    <form id="reject-registration-form" action="" method="POST" class="p-5 space-y-4 bg-white text-xs">
        @csrf

        <div class="p-3 bg-[#F4F4F4] border-2 border-[#111111] space-y-1">
            <span class="text-[10px] font-mono uppercase text-[#525252] block">Calon Siswa:</span>
            <div class="font-bold text-sm text-[#111111]" id="reject-modal-player-name">-</div>
            <div class="text-xs font-mono text-[#CC0000] font-bold" id="reject-modal-reg-code">-</div>
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
