<dialog id="jersey-size-modal" aria-labelledby="jersey-size-modal-title" closedby="any"
        class="fixed inset-0 z-[300] m-auto w-[calc(100%-2rem)] max-w-3xl max-h-[90dvh] p-0 bg-white border-2 border-[#111111] text-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex-col overflow-hidden">

    <div class="grid grid-cols-12 h-2 border-b-2 border-[#111111] shrink-0" aria-hidden="true">
        <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
        <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
        <div class="col-span-3 bg-[#FFFF00]"></div>
    </div>

    <div class="p-5 sm:p-6 border-b-2 border-[#111111] flex items-start justify-between gap-4 bg-white shrink-0">
        <div class="space-y-1">
            <span class="text-xs font-mono font-bold text-[#0000FF] uppercase tracking-wider block">Standar Apparel Resmi SSB Mekar Jaya Subang</span>
            <h3 id="jersey-size-modal-title" class="font-bold text-[#111111] text-lg sm:text-xl leading-tight">
                Panduan Pemilihan Ukuran Jersey Siswa (Size Chart)
            </h3>
        </div>
        <button type="button" onclick="closeJerseyModal()" aria-label="Tutup dialog panduan ukuran jersey"
                class="w-11 h-11 shrink-0 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] flex items-center justify-center text-base transition-colors cursor-pointer">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>

    <div class="p-5 sm:p-6 overflow-y-auto flex-1 min-h-0 text-sm text-[#111111] space-y-6 leading-relaxed bg-white">

        <div class="p-4 bg-[#F4F4F4] border-2 border-[#111111] border-l-[6px] border-l-[#0000FF] flex items-start gap-3.5">
            <div class="w-10 h-10 bg-[#0000FF] text-white border-2 border-[#111111] flex items-center justify-center shrink-0">
                <i class="fa-solid fa-shirt text-sm" aria-hidden="true"></i>
            </div>
            <div class="text-xs sm:text-sm text-[#111111] space-y-1">
                <p class="font-bold">Standar Pola Jersey Latihan & Tanding:</p>
                <p class="text-[#525252] leading-relaxed">
                    Ukuran menggunakan standar konveksi jersey olahraga sepak bola SSB Mekar Jaya. Jika postur siswa berada di antara dua batas ukuran, disarankan memilih <strong>satu ukuran lebih besar</strong> agar tetap leluasa saat memakai rompi atau pelindung tulang kering (shin guard) dan tahan bertumbuh selama 1-2 musim.
                </p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between gap-2">
                <h4 class="font-bold text-sm text-[#111111] uppercase tracking-wider font-mono">
                    <i class="fa-solid fa-table text-[#CC0000] mr-1.5" aria-hidden="true"></i> Tabel Dimensi & Rekomendasi Ukuran
                </h4>
                <span class="text-[11px] font-mono text-[#525252]">*Toleransi ±1 - 2 cm</span>
            </div>

            <div class="overflow-x-auto border-2 border-[#111111]">
                <table class="w-full text-left border-collapse text-xs text-[#111111]">
                    <thead>
                        <tr class="bg-[#111111] text-white font-mono font-bold uppercase text-[11px]">
                            <th class="p-3 text-center">Ukuran</th>
                            <th class="p-3 text-center">Panjang (cm)</th>
                            <th class="p-3 text-center">Lebar Dada (cm)</th>
                            <th class="p-3 text-center">Tinggi Badan (cm)</th>
                            <th class="p-3 text-center">Berat Badan (kg)</th>
                            <th class="p-3">Rekomendasi KU / Usia</th>
                            <th class="p-3 text-right">Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#111111] bg-white font-mono">
                        <tr id="jersey-row-S" class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-3 text-center font-bold">
                                <span class="px-2 py-0.5 bg-[#111111] text-[#FFFF00] border border-[#111111]">S</span>
                            </td>
                            <td class="p-3 text-center font-bold">56 cm</td>
                            <td class="p-3 text-center font-bold">40 cm</td>
                            <td class="p-3 text-center text-[#525252]">120 - 135 cm</td>
                            <td class="p-3 text-center text-[#525252]">25 - 35 kg</td>
                            <td class="p-3 font-sans">
                                <strong>KU U-10</strong> (Usia 7 - 10 Tahun)
                            </td>
                            <td class="p-3 text-right">
                                <button type="button" onclick="selectJerseySize('S')"
                                        class="min-h-[36px] px-3 py-1.5 bg-white hover:bg-[#0000FF] hover:text-white text-[#111111] border-2 border-[#111111] text-xs font-bold font-sans transition-colors cursor-pointer">
                                    Pilih S
                                </button>
                            </td>
                        </tr>
                        <tr id="jersey-row-M" class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-3 text-center font-bold">
                                <span class="px-2 py-0.5 bg-[#0000FF] text-white border border-[#111111]">M</span>
                            </td>
                            <td class="p-3 text-center font-bold">62 cm</td>
                            <td class="p-3 text-center font-bold">44 cm</td>
                            <td class="p-3 text-center text-[#525252]">135 - 150 cm</td>
                            <td class="p-3 text-center text-[#525252]">35 - 45 kg</td>
                            <td class="p-3 font-sans">
                                <strong>KU U-12</strong> (Usia 11 - 13 Tahun)
                            </td>
                            <td class="p-3 text-right">
                                <button type="button" onclick="selectJerseySize('M')"
                                        class="min-h-[36px] px-3 py-1.5 bg-white hover:bg-[#0000FF] hover:text-white text-[#111111] border-2 border-[#111111] text-xs font-bold font-sans transition-colors cursor-pointer">
                                    Pilih M
                                </button>
                            </td>
                        </tr>
                        <tr id="jersey-row-L" class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-3 text-center font-bold">
                                <span class="px-2 py-0.5 bg-[#FF0000] text-black border border-[#111111]">L</span>
                            </td>
                            <td class="p-3 text-center font-bold">66 cm</td>
                            <td class="p-3 text-center font-bold">48 cm</td>
                            <td class="p-3 text-center text-[#525252]">150 - 162 cm</td>
                            <td class="p-3 text-center text-[#525252]">45 - 55 kg</td>
                            <td class="p-3 font-sans">
                                <strong>KU U-14 &amp; U-16</strong> (Usia 14 - 15 Tahun)
                            </td>
                            <td class="p-3 text-right">
                                <button type="button" onclick="selectJerseySize('L')"
                                        class="min-h-[36px] px-3 py-1.5 bg-white hover:bg-[#0000FF] hover:text-white text-[#111111] border-2 border-[#111111] text-xs font-bold font-sans transition-colors cursor-pointer">
                                    Pilih L
                                </button>
                            </td>
                        </tr>
                        <tr id="jersey-row-XL" class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-3 text-center font-bold">
                                <span class="px-2 py-0.5 bg-[#111111] text-white border border-[#111111]">XL</span>
                            </td>
                            <td class="p-3 text-center font-bold">70 cm</td>
                            <td class="p-3 text-center font-bold">52 cm</td>
                            <td class="p-3 text-center text-[#525252]">162 - 175 cm</td>
                            <td class="p-3 text-center text-[#525252]">55 - 68 kg</td>
                            <td class="p-3 font-sans">
                                <strong>KU U-18</strong> (Usia 16 - 18 Tahun)
                            </td>
                            <td class="p-3 text-right">
                                <button type="button" onclick="selectJerseySize('XL')"
                                        class="min-h-[36px] px-3 py-1.5 bg-white hover:bg-[#0000FF] hover:text-white text-[#111111] border-2 border-[#111111] text-xs font-bold font-sans transition-colors cursor-pointer">
                                    Pilih XL
                                </button>
                            </td>
                        </tr>
                        <tr id="jersey-row-XXL" class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="p-3 text-center font-bold">
                                <span class="px-2 py-0.5 bg-[#FFFF00] text-[#111111] border border-[#111111]">XXL</span>
                            </td>
                            <td class="p-3 text-center font-bold">74 cm</td>
                            <td class="p-3 text-center font-bold">56 cm</td>
                            <td class="p-3 text-center text-[#525252]">&gt; 175 cm</td>
                            <td class="p-3 text-center text-[#525252]">&gt; 68 kg</td>
                            <td class="p-3 font-sans">
                                <strong>Senior / Dewasa</strong> (Postur Besar)
                            </td>
                            <td class="p-3 text-right">
                                <button type="button" onclick="selectJerseySize('XXL')"
                                        class="min-h-[36px] px-3 py-1.5 bg-white hover:bg-[#0000FF] hover:text-white text-[#111111] border-2 border-[#111111] text-xs font-bold font-sans transition-colors cursor-pointer">
                                    Pilih XXL
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <div class="border-2 border-[#111111] p-4 bg-[#F4F4F4] space-y-2">
                <h5 class="font-bold text-xs uppercase tracking-wider text-[#111111] flex items-center gap-2">
                    <span class="w-5 h-5 bg-[#111111] text-white flex items-center justify-center text-[10px] font-mono">1</span>
                    Cara Mengukur Lebar Dada (Width)
                </h5>
                <p class="text-xs text-[#525252] leading-relaxed">
                    Bentangkan kaos yang biasa pas dipakai siswa di atas permukaan datar. Ukur secara mendatar dari jahitan ketiak kiri tepat ke jahitan ketiak kanan.
                </p>
            </div>

            <div class="border-2 border-[#111111] p-4 bg-[#F4F4F4] space-y-2">
                <h5 class="font-bold text-xs uppercase tracking-wider text-[#111111] flex items-center gap-2">
                    <span class="w-5 h-5 bg-[#0000FF] text-white flex items-center justify-center text-[10px] font-mono">2</span>
                    Cara Mengukur Panjang Baju (Length)
                </h5>
                <p class="text-xs text-[#525252] leading-relaxed">
                    Ukur secara vertikal dari titik sambungan pundak tertinggi (dekat kerah leher) lurus ke bawah sampai ke ujung kelim bawah jersey.
                </p>
            </div>
        </div>

    </div>

    <div class="p-4 sm:p-5 border-t-2 border-[#111111] flex flex-col sm:flex-row items-center justify-between gap-3 bg-[#F4F4F4] shrink-0">
        <span class="text-xs font-mono text-[#525252]">
            Apparel SSB Mekar Jaya &bull; Subang
        </span>
        <button type="button" onclick="closeJerseyModal()" class="w-full sm:w-auto btn-secondary text-xs py-2.5 px-6 font-bold">
            Tutup Panduan
        </button>
    </div>

</dialog>

<script>
    function openJerseyModal() {
        const modal = document.getElementById('jersey-size-modal');
        if (!modal) return;

        const hInput = document.getElementById('height_cm');
        const wInput = document.getElementById('weight_kg');
        const hVal = (hInput && hInput.value.trim() !== '' && !isNaN(hInput.value)) ? parseInt(hInput.value, 10) : null;
        const wVal = (wInput && wInput.value.trim() !== '' && !isNaN(wInput.value)) ? parseInt(wInput.value, 10) : null;

        ['S', 'M', 'L', 'XL', 'XXL'].forEach((sz) => {
            const row = document.getElementById('jersey-row-' + sz);
            if (row) {
                row.classList.remove('bg-[#FFFF00]', 'font-bold');
            }
        });

        const recommended = calculateRecommendedJersey(hVal, wVal);
        if (recommended) {
            const targetRow = document.getElementById('jersey-row-' + recommended);
            if (targetRow) {
                targetRow.classList.add('bg-[#FFFF00]', 'font-bold');
            }
        }

        if (typeof modal.showModal === 'function') {
            modal.showModal();
        } else {
            modal.setAttribute('open', '');
        }
    }

    function closeJerseyModal() {
        const modal = document.getElementById('jersey-size-modal');
        if (!modal) return;
        if (typeof modal.close === 'function') {
            modal.close();
        } else {
            modal.removeAttribute('open');
        }
    }

    function selectJerseySize(size) {
        const select = document.getElementById('jersey_size');
        if (select) {
            select.value = size;
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }
        closeJerseyModal();
    }

    function calculateRecommendedJersey(height, weight) {
        if ((!height || isNaN(height)) && (!weight || isNaN(weight))) return null;

        if (height && !isNaN(height)) {
            if (height <= 135) return 'S';
            if (height <= 150) return 'M';
            if (height <= 162) return 'L';
            if (height <= 175) return 'XL';
            return 'XXL';
        }

        if (weight && !isNaN(weight)) {
            if (weight <= 35) return 'S';
            if (weight <= 45) return 'M';
            if (weight <= 55) return 'L';
            if (weight <= 68) return 'XL';
            return 'XXL';
        }

        return null;
    }

    window.openJerseyModal = openJerseyModal;
    window.closeJerseyModal = closeJerseyModal;
    window.selectJerseySize = selectJerseySize;
    window.calculateRecommendedJersey = calculateRecommendedJersey;

    (function() {
        const modal = document.getElementById('jersey-size-modal');
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

    function initJerseySuggestion() {
        const hInput = document.getElementById('height_cm');
        const wInput = document.getElementById('weight_kg');
        const helperBox = document.getElementById('jersey-size-suggestion');

        if (!helperBox || (!hInput && !wInput)) return;

        function updateJerseySuggestion() {
            const hVal = (hInput && hInput.value.trim() !== '' && !isNaN(hInput.value)) ? parseInt(hInput.value, 10) : null;
            const wVal = (wInput && wInput.value.trim() !== '' && !isNaN(wInput.value)) ? parseInt(wInput.value, 10) : null;
            const rec = calculateRecommendedJersey(hVal, wVal);

            if (rec) {
                helperBox.innerHTML = `
                    <div class="mt-2 p-2 bg-[#F4F4F4] border-2 border-[#111111] text-[11px] flex items-center justify-between gap-2">
                        <span>Saran otomatis berdasarkan postur: <strong class="font-mono text-[#0000FF] font-bold">Size ${rec}</strong></span>
                        <button type="button" onclick="selectJerseySize('${rec}')" class="px-2 py-0.5 bg-[#111111] text-[#FFFF00] font-mono font-bold hover:bg-[#0000FF] hover:text-white transition-colors">
                            Terapkan
                        </button>
                    </div>
                `;
                helperBox.classList.remove('hidden');
            } else {
                helperBox.innerHTML = '';
                helperBox.classList.add('hidden');
            }
        }

        if (hInput) hInput.addEventListener('input', updateJerseySuggestion);
        if (wInput) wInput.addEventListener('input', updateJerseySuggestion);
        updateJerseySuggestion();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initJerseySuggestion);
    } else {
        initJerseySuggestion();
    }
</script>
