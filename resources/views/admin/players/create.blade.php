@extends('layouts.admin')

@section('title', 'Tambah Pemain Baru - Mekar Jaya Sport Subang')
@section('page-header', 'Form Tambah Siswa SSB Baru')

@section('content')

<div class="max-w-3xl mx-auto editorial-card p-8 space-y-6">
    
    <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-4">
        <div>
            <h2 class="font-bold text-[#111111] text-base">Input Data Pemain Baru</h2>
            <p class="text-xs text-[#626260]">Tahun kelahiran akan secara otomatis diklasifikasikan ke Kelompok Umur (KU).</p>
        </div>
        <a href="{{ route('admin.players.index') }}" class="text-xs text-[#ff5600] font-semibold hover:underline">
            &larr; Kembali Ke List
        </a>
    </div>

    @if($errors->any())
        <div class="p-3 bg-[#ebe7e1] border border-[#c41c1c] text-[#c41c1c] text-xs rounded-md">
            <i class="fa-solid fa-circle-exclamation mr-1"></i> Mohon lengkapi semua field yang wajib diisi.
        </div>
    @endif

    <form action="{{ route('admin.players.store') }}" method="POST" class="space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div>
                <label for="full_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Lengkap Siswa *</label>
                <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                    placeholder="Contoh: Muhammad Fatih"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="nickname" class="block font-medium text-[#626260] uppercase mb-1">Nama Panggilan</label>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}"
                    placeholder="Contoh: Fatih"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="birth_place" class="block font-medium text-[#626260] uppercase mb-1">Tempat Lahir *</label>
                <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place', 'Subang') }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="birth_date" class="block font-medium text-[#626260] uppercase mb-1">Tanggal Lahir * (Penentu Tahun Lahir & KU)</label>
                <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
            </div>

            <div>
                <label for="position" class="block font-medium text-[#626260] uppercase mb-1">Posisi Utama *</label>
                <select id="position" name="position" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
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
                <label for="status" class="block font-medium text-[#626260] uppercase mb-1">Status Keanggotaan *</label>
                <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    <option value="aktif">Aktif Siswa</option>
                    <option value="alumni">Alumni</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
            </div>

            <div>
                <label for="height_cm" class="block font-medium text-[#626260] uppercase mb-1">Tinggi Badan (cm)</label>
                <input type="number" id="height_cm" name="height_cm" value="{{ old('height_cm') }}" placeholder="145"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="weight_kg" class="block font-medium text-[#626260] uppercase mb-1">Berat Badan (kg)</label>
                <input type="number" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" placeholder="38"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div class="sm:col-span-2">
                <label for="school_name" class="block font-medium text-[#626260] uppercase mb-1">Sekolah Asal</label>
                <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}" placeholder="Contoh: SDN Dangdeur 1 Subang"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="parent_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Orang Tua / Wali *</label>
                <input type="text" id="parent_name" name="parent_name" required value="{{ old('parent_name') }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="parent_phone" class="block font-medium text-[#626260] uppercase mb-1">No. WA Orang Tua *</label>
                <input type="text" id="parent_phone" name="parent_phone" required value="{{ old('parent_phone') }}" placeholder="0851-XXXX-XXXX"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="spp_status" class="block font-medium text-[#626260] uppercase mb-1">Status SPP Bulanan *</label>
                <select id="spp_status" name="spp_status" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
                    <option value="Lunas">Lunas</option>
                    <option value="Belum Bayar">Belum Bayar</option>
                </select>
            </div>

        </div>

        <div class="pt-4 border-t border-[#ebe7e1] flex justify-end gap-3">
            <a href="{{ route('admin.players.index') }}" class="btn-secondary text-xs py-2 px-4">
                Batal
            </a>
            <button type="submit" class="btn-fin text-xs py-2 px-5">
                Simpan Pemain Baru
            </button>
        </div>

    </form>

</div>

@endsection
