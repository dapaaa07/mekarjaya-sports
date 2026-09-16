@extends('layouts.admin')

@section('title', 'Tambah Jadwal Latihan Baru - Mekar Jaya Sport Subang')
@section('page-header', 'Tambah Sesi Latihan SSB Baru')

@section('content')

<div class="max-w-2xl mx-auto editorial-card p-8 space-y-6">
    
    <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-4">
        <div>
            <h2 class="font-bold text-[#111111] text-base">Tambah Sesi Latihan Baru</h2>
            <p class="text-xs text-[#626260]">Jadwal ini akan menjadi acuan presensi dan tampil di portal orang tua.</p>
        </div>
        <a href="{{ route('admin.schedules.index') }}" class="text-xs text-[#ff5600] font-semibold hover:underline">
            &larr; Kembali Ke Daftar Jadwal
        </a>
    </div>

    @if($errors->any())
        <div class="p-3 bg-[#ebe7e1] border border-[#c41c1c] text-[#c41c1c] text-xs rounded-md">
            <i class="fa-solid fa-circle-exclamation mr-1"></i> Mohon lengkapi semua field yang wajib diisi.
        </div>
    @endif

    <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div class="sm:col-span-2">
                <label for="title" class="block font-medium text-[#626260] uppercase mb-1">Judul / Nama Sesi Latihan *</label>
                <input type="text" id="title" name="title" required value="{{ old('title', 'Latihan Rutin Taktik & Fisik') }}"
                    placeholder="Contoh: Latihan Rutin KU U-12"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-bold">
            </div>

            <div>
                <label for="schedule_date" class="block font-medium text-[#626260] uppercase mb-1">Tanggal Sesi *</label>
                <input type="date" id="schedule_date" name="schedule_date" required value="{{ old('schedule_date', date('Y-m-d')) }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111] font-semibold">
            </div>

            <div>
                <label for="target_ku" class="block font-medium text-[#626260] uppercase mb-1">Target Kelompok Umur (KU) *</label>
                <select id="target_ku" name="target_ku" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    <option value="Semua KU">Semua Kelompok Umur (Semua KU)</option>
                    @foreach($ageCategories as $cat)
                        <option value="{{ $cat->code }}" {{ old('target_ku') == $cat->code ? 'selected' : '' }}>{{ $cat->code }} ({{ $cat->min_birth_year }}-{{ $cat->max_birth_year }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_time" class="block font-medium text-[#626260] uppercase mb-1">Jam Mulai *</label>
                <input type="time" id="start_time" name="start_time" required value="{{ old('start_time', '15:30') }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="end_time" class="block font-medium text-[#626260] uppercase mb-1">Jam Selesai *</label>
                <input type="time" id="end_time" name="end_time" required value="{{ old('end_time', '17:30') }}"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="location" class="block font-medium text-[#626260] uppercase mb-1">Lokasi Sesi Latihan *</label>
                <input type="text" id="location" name="location" required value="{{ old('location', 'Lapangan Veteran Dangdeur Subang') }}"
                    placeholder="Lapangan Veteran / Mini Soccer Cigadung"
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
            </div>

            <div>
                <label for="coach_in_charge" class="block font-medium text-[#626260] uppercase mb-1">Pelatih Penanggung Jawab</label>
                <select id="coach_in_charge" name="coach_in_charge" class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    <option value="">-- Pilih Pelatih --</option>
                    @foreach($coaches as $coach)
                        <option value="{{ $coach->name }}" {{ old('coach_in_charge') == $coach->name ? 'selected' : '' }}>{{ $coach->name }} ({{ $coach->license }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block font-medium text-[#626260] uppercase mb-1">Status Sesi *</label>
                <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal (Scheduled)</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label for="notes" class="block font-medium text-[#626260] uppercase mb-1">Catatan Materi / Instruksi Latihan</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Contoh: Fokus latihan passing pendek, koordinasi fisik & game 7v7."
                    class="w-full px-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">{{ old('notes') }}</textarea>
            </div>

        </div>

        <div class="pt-4 border-t border-[#ebe7e1] flex justify-end gap-3">
            <a href="{{ route('admin.schedules.index') }}" class="btn-secondary text-xs py-2 px-4">
                Batal
            </a>
            <button type="submit" class="btn-fin text-xs py-2 px-5">
                Simpan Jadwal Latihan
            </button>
        </div>

    </form>

</div>

@endsection
