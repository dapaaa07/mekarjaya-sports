<!-- NATIVE DIALOG MODAL: SYARAT & KETENTUAN SERTA KEBIJAKAN PRIVASI DOKUMEN KK -->
<dialog id="privacy-modal" aria-labelledby="privacy-modal-title" closedby="any"
        class="fixed inset-0 z-[300] m-auto w-[calc(100%-2rem)] max-w-2xl max-h-[90dvh] p-0 bg-white border-2 border-[#111111] text-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex-col overflow-hidden">

    <!-- Mondrian Top Strip -->
    <div class="grid grid-cols-12 h-2 border-b-2 border-[#111111] shrink-0" aria-hidden="true">
        <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
        <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
        <div class="col-span-3 bg-[#FFFF00]"></div>
    </div>

    <!-- Modal Header -->
    <div class="p-5 sm:p-6 border-b-2 border-[#111111] flex items-start justify-between gap-4 bg-white shrink-0">
        <div class="space-y-1">
            <span class="text-xs font-mono font-bold text-[#0000FF] uppercase tracking-wider block">Standar Perlindungan Data Pribadi</span>
            <h3 id="privacy-modal-title" class="font-bold text-[#111111] text-lg sm:text-xl leading-tight">
                Syarat & Ketentuan serta Kebijakan Privasi Dokumen KK
            </h3>
        </div>
        <button type="button" onclick="closePrivacyModal()" aria-label="Tutup dialog kebijakan privasi"
                class="w-11 h-11 shrink-0 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] flex items-center justify-center text-base transition-colors cursor-pointer">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>

    <!-- Modal Body (Scrollable) -->
    <div class="p-5 sm:p-6 overflow-y-auto text-sm text-[#111111] space-y-5 leading-relaxed bg-white">

        <div class="p-4 bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] flex items-start gap-3.5">
            <div class="w-10 h-10 bg-[#0000FF] text-white border-2 border-[#111111] flex items-center justify-center shrink-0">
                <i class="fa-solid fa-shield-halved text-sm" aria-hidden="true"></i>
            </div>
            <p class="text-xs sm:text-sm leading-relaxed text-[#111111]">
                SSB Mekar Jaya Subang menjaga keamanan dan kerahasiaan data pribadi calon atlet dan orang tua sesuai ketentuan <strong>Undang-Undang Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong>.
            </p>
        </div>

        <div class="space-y-1.5 border-b border-[#D4D4D4] pb-4">
            <h4 class="font-bold text-sm text-[#111111] flex items-center gap-2.5">
                <span class="w-6 h-6 bg-[#111111] text-white flex items-center justify-center text-xs font-mono font-bold shrink-0">1</span>
                Tujuan Pengumpulan Dokumen Kartu Keluarga (KK)
            </h4>
            <p class="text-xs sm:text-sm text-[#525252] pl-8.5">
                Pengunggahan foto atau salinan Kartu Keluarga diwajibkan untuk verifikasi faktual usia, tanggal, dan tahun kelahiran calon siswa guna penetapan Kelompok Umur (KU) serta keabsahan registrasi turnamen resmi binaan Askab PSSI Subang.
            </p>
        </div>

        <div class="space-y-1.5 border-b border-[#D4D4D4] pb-4">
            <h4 class="font-bold text-sm text-[#111111] flex items-center gap-2.5">
                <span class="w-6 h-6 bg-[#0000FF] text-white border border-[#111111] flex items-center justify-center text-xs font-mono font-bold shrink-0">2</span>
                Batasan Akses & Kerahasiaan Dokumen
            </h4>
            <p class="text-xs sm:text-sm text-[#525252] pl-8.5">
                Dokumen Kartu Keluarga hanya dapat dibuka oleh administrator resmi SSB Mekar Jaya Subang saat proses verifikasi pendaftaran. Berkas tidak diperjualbelikan, dipublikasikan secara terbuka, atau dibagikan di luar registrasi kompetisi resmi.
            </p>
        </div>

        <div class="space-y-1.5 border-b border-[#D4D4D4] pb-4">
            <h4 class="font-bold text-sm text-[#111111] flex items-center gap-2.5">
                <span class="w-6 h-6 bg-[#FF0000] text-[#000000] border border-[#111111] flex items-center justify-center text-xs font-mono font-bold shrink-0">3</span>
                Keamanan Penyimpanan & Kompresi Otomatis
            </h4>
            <p class="text-xs sm:text-sm text-[#525252] pl-8.5">
                Berkas dokumen disimpan pada direktori penyimpanan server dengan kontrol akses internal. Apabila foto KK melebihi 2 MB, sistem mengompresi ukuran file secara otomatis tanpa mengurangi keterbacaan angka dan nama pada dokumen.
            </p>
        </div>

        <div class="space-y-1.5 border-b border-[#D4D4D4] pb-4">
            <h4 class="font-bold text-sm text-[#111111] flex items-center gap-2.5">
                <span class="w-6 h-6 bg-[#FFFF00] text-[#111111] border border-[#111111] flex items-center justify-center text-xs font-mono font-bold shrink-0">4</span>
                Masa Simpan & Hak Penghapusan Arsip
            </h4>
            <p class="text-xs sm:text-sm text-[#525252] pl-8.5">
                Dokumen KK tersimpan selama siswa berstatus aktif di SSB Mekar Jaya Subang. Ketika siswa lulus atau mengundurkan diri, orang tua berhak mengajukan penghapusan permanen arsip berkas KK melalui sekretariat resmi SSB.
            </p>
        </div>

        <div class="space-y-1.5">
            <h4 class="font-bold text-sm text-[#111111] flex items-center gap-2.5">
                <span class="w-6 h-6 bg-[#111111] text-white flex items-center justify-center text-xs font-mono font-bold shrink-0">5</span>
                Tanggung Jawab Keaslian Dokumen
            </h4>
            <p class="text-xs sm:text-sm text-[#525252] pl-8.5">
                Orang tua/wali menjamin bahwa salinan Kartu Keluarga yang diunggah adalah dokumen asli dan sah. Pihak SSB berhak membatalkan status pendaftaran apabila ditemukan manipulasi tahun lahir atau pemalsuan berkas.
            </p>
        </div>

    </div>

    <!-- Modal Footer -->
    <div class="p-4 sm:p-5 border-t-2 border-[#111111] flex flex-col sm:flex-row items-center justify-between gap-3 bg-[#F4F4F4] shrink-0">
        <span class="text-xs font-mono text-[#525252] text-center sm:text-left">
            Diperbarui: Oktober 2026 | SSB Mekar Jaya Subang
        </span>
        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <button type="button" onclick="closePrivacyModal()" class="w-full sm:w-auto btn-secondary text-xs py-2.5 px-4">
                Tutup
            </button>
            <button type="button" onclick="acceptPrivacyAndClose()" autofocus class="w-full sm:w-auto btn-primary text-xs py-2.5 px-5 font-bold">
                Saya Mengerti & Setuju
            </button>
        </div>
    </div>

</dialog>

<script>
    function openPrivacyModal() {
        const modal = document.getElementById('privacy-modal');
        if (modal && typeof modal.showModal === 'function') {
            if (!modal.open) modal.showModal();
        }
    }

    function closePrivacyModal() {
        const modal = document.getElementById('privacy-modal');
        if (modal && modal.open) {
            modal.close();
        }
    }

    function acceptPrivacyAndClose() {
        const checkbox = document.getElementById('terms_agreement');
        if (checkbox) {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        }
        closePrivacyModal();
    }

    // Light dismiss fallback for browsers lacking native closedby="any"
    (function() {
        const modal = document.getElementById('privacy-modal');
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
