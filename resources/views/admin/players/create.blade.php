@extends('layouts.admin')

@section('title', 'Tambah Pemain Baru - Mekar Jaya Sport Subang')
@section('page-header', 'Form Tambah Siswa SSB Baru')

@section('content')

<div class="max-w-3xl mx-auto editorial-card p-6 sm:p-8 space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b-2 border-[#111111] pb-4">
        <div>
            <h2 class="font-bold text-[#111111] text-lg">Input Data Pemain Baru</h2>
            <p class="text-xs text-[#525252]">Tahun kelahiran akan otomatis diklasifikasikan ke Kelompok Umur (KU).</p>
        </div>
        <a href="{{ route('admin.players.index') }}" class="text-xs font-mono font-bold text-[#0000FF] hover:underline inline-flex items-center gap-1 min-h-[40px]">
            &larr; Kembali Ke List
        </a>
    </div>

    <form action="{{ route('admin.players.store') }}" method="POST" class="space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <label for="full_name" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Lengkap Siswa *</label>
                <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                       placeholder="Contoh: Muhammad Fatih"
                       class="ds-input text-sm">
            </div>

            <div>
                <label for="nickname" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Panggilan</label>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}"
                       placeholder="Contoh: Fatih"
                       class="ds-input text-sm">
            </div>

            <div>
                <label for="birth_place" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tempat Lahir *</label>
                <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place', 'Subang') }}"
                       class="ds-input text-sm">
            </div>

            <div>
                <label for="birth_date" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tanggal Lahir * (Penentu KU)</label>
                <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}"
                       class="ds-input text-sm font-bold">
                <div id="admin-ku-helper" class="hidden mt-1.5 px-2.5 py-1 bg-[#FFFF00] border border-[#111111] text-[11px] font-mono font-bold text-[#111111]"></div>
            </div>

            <div>
                <label for="position" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Posisi Utama *</label>
                <select id="position" name="position" required class="ds-input text-sm font-semibold">
                    <option value="Gelandang">Gelandang</option>
                    <option value="Striker">Striker</option>
                    <option value="Penyerang Sayap">Penyerang Sayap</option>
                    <option value="Gelandang Serang">Gelandang Serang</option>
                    <option value="Gelandang Bertahan">Gelandang Bertahan</option>
                    <option value="Bek Tengah">Bek Tengah</option>
                    <option value="Bek Sayap">Bek Sayap</option>
                    <option value="Kiper">Kiper</option>
                </select>
            </div>

            <div>
                <label for="jersey_size" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Ukuran Jersey *</label>
                <select id="jersey_size" name="jersey_size" required class="ds-input text-sm font-semibold">
                    <option value="S">S (Anak / Kecil)</option>
                    <option value="M" selected>M (Sedang)</option>
                    <option value="L">L (Besar)</option>
                    <option value="XL">XL (Sangat Besar)</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>

            <div>
                <label for="status" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Status Keanggotaan *</label>
                <select id="status" name="status" required class="ds-input text-sm">
                    <option value="aktif">Aktif Siswa</option>
                    <option value="alumni">Alumni</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
            </div>

            <div>
                <label for="height_cm" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Tinggi Badan (cm)</label>
                <input type="number" id="height_cm" name="height_cm" value="{{ old('height_cm') }}" placeholder="145"
                       class="ds-input text-sm font-mono">
            </div>

            <div>
                <label for="weight_kg" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Berat Badan (kg)</label>
                <input type="number" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" placeholder="38"
                       class="ds-input text-sm font-mono">
            </div>

            <div>
                <label for="spp_status" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Pembayaran SPP Bulan Pertama *</label>
                <select id="spp_status" name="spp_status" required class="ds-input text-sm font-semibold">
                    <option value="Lunas" {{ old('spp_status', 'Lunas') == 'Lunas' ? 'selected' : '' }}>Lunas (Catat Otomatis Bulan Ini)</option>
                    <option value="Belum Bayar" {{ old('spp_status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label for="school_name" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Sekolah Asal</label>
                <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}" placeholder="Contoh: SDN Dangdeur 1 Subang"
                       class="ds-input text-sm">
            </div>

            <div>
                <label for="parent_name" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Orang Tua / Wali *</label>
                <input type="text" id="parent_name" name="parent_name" required value="{{ old('parent_name') }}"
                       class="ds-input text-sm">
            </div>

            <div>
                <label for="parent_phone" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">No. WA Orang Tua *</label>
                <input type="text" id="parent_phone" name="parent_phone" required value="{{ old('parent_phone') }}" placeholder="0851-XXXX-XXXX"
                       class="ds-input text-sm font-mono">
            </div>

        </div>

        <div class="pt-5 border-t-2 border-[#111111] flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.players.index') }}" class="btn-secondary text-xs py-2.5 px-5">
                Batal
            </a>
            <button type="submit" class="btn-primary text-xs py-2.5 px-6 font-bold">
                Simpan Pemain Baru
            </button>
        </div>

    </form>

</div>

<script>
    (function() {
        const bDate = document.getElementById('birth_date');
        const helper = document.getElementById('admin-ku-helper');
        if (!bDate || !helper) return;
        const updateKu = () => {
            if (!bDate.value) { helper.classList.add('hidden'); return; }
            const yr = parseInt(bDate.value.split('-')[0], 10);
            if (isNaN(yr)) return;
            const age = new Date().getFullYear() - yr;
            let ku = 'U-10';
            if (age > 10 && age <= 12) ku = 'U-12';
            else if (age > 12 && age <= 14) ku = 'U-14';
            else if (age > 14 && age <= 16) ku = 'U-16';
            else if (age > 16) ku = 'U-18';
            helper.textContent = 'Otomatis: Angkatan ' + yr + ' -> Kategori ' + ku;
            helper.classList.remove('hidden');
        };
        bDate.addEventListener('change', updateKu);
        updateKu();
    })();
</script>

@endsection
