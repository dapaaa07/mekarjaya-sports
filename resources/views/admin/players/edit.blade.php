@extends('layouts.admin')

@section('title', 'Edit Pemain - ' . $player->full_name)
@section('page-header', 'Edit Data Pemain')

@section('content')

<div class="max-w-3xl mx-auto editorial-card p-8 space-y-6">
    
    <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-4">
        <div>
            <h2 class="font-bold text-[#111111] text-base">Edit Data: {{ $player->full_name }}</h2>
            <p class="text-xs text-[#626260]">NIS: <span class="font-mono text-[#ff5600] font-bold">{{ $player->nis }}</span></p>
        </div>
        <a href="{{ route('admin.players.index') }}" class="text-xs text-[#ff5600] font-semibold hover:underline">
            &larr; Kembali Ke List
        </a>
    </div>

    <form action="{{ route('admin.players.update', $player->id) }}" method="POST" class="space-y-6 text-xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div>
                <label for="full_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Lengkap Siswa *</label>
                <input type="text" id="full_name" name="full_name" required value="{{ old('full_name', $player->full_name) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="nickname" class="block font-medium text-[#626260] uppercase mb-1">Nama Panggilan</label>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname', $player->nickname) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="birth_place" class="block font-medium text-[#626260] uppercase mb-1">Tempat Lahir *</label>
                <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place', $player->birth_place) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="birth_date" class="block font-medium text-[#626260] uppercase mb-1">Tanggal Lahir *</label>
                <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date', $player->birth_date->format('Y-m-d')) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
            </div>

            <div>
                <label for="position" class="block font-medium text-[#626260] uppercase mb-1">Posisi Utama *</label>
                <select id="position" name="position" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
                    @foreach(['Gelandang', 'Striker', 'Penyerang Sayap', 'Gelandang Serang', 'Gelandang Bertahan', 'Bek Tengah', 'Bek Sayap', 'Kiper'] as $pos)
                        <option value="{{ $pos }}" {{ old('position', $player->position) == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="jersey_size" class="block font-medium text-[#626260] uppercase mb-1">Ukuran Jersey *</label>
                <select id="jersey_size" name="jersey_size" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
                    @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $sz)
                        <option value="{{ $sz }}" {{ old('jersey_size', $player->jersey_size ?? 'M') == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block font-medium text-[#626260] uppercase mb-1">Status Keanggotaan *</label>
                <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    <option value="aktif" {{ old('status', $player->status) == 'aktif' ? 'selected' : '' }}>Aktif Siswa</option>
                    <option value="alumni" {{ old('status', $player->status) == 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="non-aktif" {{ old('status', $player->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <div>
                <label for="height_cm" class="block font-medium text-[#626260] uppercase mb-1">Tinggi Badan (cm)</label>
                <input type="number" id="height_cm" name="height_cm" value="{{ old('height_cm', $player->height_cm) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="weight_kg" class="block font-medium text-[#626260] uppercase mb-1">Berat Badan (kg)</label>
                <input type="number" id="weight_kg" name="weight_kg" value="{{ old('weight_kg', $player->weight_kg) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div class="sm:col-span-2">
                <label for="school_name" class="block font-medium text-[#626260] uppercase mb-1">Sekolah Asal</label>
                <input type="text" id="school_name" name="school_name" value="{{ old('school_name', $player->school_name) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="parent_name" class="block font-medium text-[#626260] uppercase mb-1">Nama Orang Tua / Wali *</label>
                <input type="text" id="parent_name" name="parent_name" required value="{{ old('parent_name', $player->parent_name) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="parent_phone" class="block font-medium text-[#626260] uppercase mb-1">No. WA Orang Tua *</label>
                <input type="text" id="parent_phone" name="parent_phone" required value="{{ old('parent_phone', $player->parent_phone) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="spp_status" class="block font-medium text-[#626260] uppercase mb-1">Status SPP Bulanan *</label>
                <select id="spp_status" name="spp_status" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
                    <option value="Lunas" {{ old('spp_status', $player->spp_status) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Belum Bayar" {{ old('spp_status', $player->spp_status) == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                </select>
            </div>

        </div>

        <div class="pt-4 border-t border-[#ebe7e1] flex justify-end gap-3">
            <a href="{{ route('admin.players.index') }}" class="btn-secondary text-xs py-2 px-4">
                Batal
            </a>
            <button type="submit" class="btn-fin text-xs py-2 px-5">
                Update Data Pemain
            </button>
        </div>

    </form>

</div>

@endsection
