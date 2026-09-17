@extends('layouts.admin')

@section('title', 'Inventaris Peralatan Latihan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Kelola Inventaris Alat Latihan')

@section('content')
<div class="space-y-6">

    <!-- Header Summary & Quick Action Button -->
    <div class="tile flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-lg text-[#111111] flex items-center gap-2">
                <i class="fa-solid fa-boxes-packing text-[#ff5600]"></i> Master Inventaris Peralatan SSB
            </h2>
            <p class="text-xs text-[#626260]">Manajemen stok bola, rompi latihan, cone, gawang, dan fasilitas medis sekretariat.</p>
        </div>
        
        <button onclick="document.getElementById('modal-add-inventory').classList.remove('hidden')" class="btn-fin text-xs py-2 px-4 flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Barang Inventaris
        </button>
    </div>

    <!-- Inventory Filter & Search Bar -->
    <div class="tile">
        <form action="{{ route('admin.inventories.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-[11px] font-bold text-[#626260] uppercase mb-1">Kategori Barang</label>
                <select name="category" onchange="this.form.submit()" class="w-full bg-[#f5f1ec] border border-[#d3cec6] rounded-md px-3 py-2 text-xs focus:ring-[#ff5600] focus:border-[#ff5600]">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Bola" {{ request('category') == 'Bola' ? 'selected' : '' }}>Bola</option>
                    <option value="Rompi" {{ request('category') == 'Rompi' ? 'selected' : '' }}>Rompi Latihan</option>
                    <option value="Cone" {{ request('category') == 'Cone' ? 'selected' : '' }}>Cone & Agility Ladder</option>
                    <option value="Medis" {{ request('category') == 'Medis' ? 'selected' : '' }}>Medis / P3K</option>
                    <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-[#626260] uppercase mb-1">Kondisi</label>
                <select name="condition" onchange="this.form.submit()" class="w-full bg-[#f5f1ec] border border-[#d3cec6] rounded-md px-3 py-2 text-xs focus:ring-[#ff5600] focus:border-[#ff5600]">
                    <option value="">-- Semua Kondisi --</option>
                    <option value="Baik" {{ request('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>

            <div class="flex items-end">
                <a href="{{ route('admin.inventories.index') }}" class="btn-secondary w-full text-xs py-2 text-center">Reset Filter</a>
            </div>
        </form>
    </div>

    <!-- Inventory Data Table -->
    <div class="tile overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f5f1ec] border-b border-[#d3cec6] text-[11px] font-bold text-[#626260] uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Barang</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4 text-center">Jumlah Stok</th>
                        <th class="py-3 px-4">Kondisi</th>
                        <th class="py-3 px-4">Lokasi Simpan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ebe7e1] text-xs">
                    @forelse($inventories as $inv)
                        <tr class="hover:bg-[#f5f1ec]/50 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-[#111111]">
                                {{ $inv->item_name }}
                                @if($inv->notes)
                                    <span class="block text-[10px] text-[#626260] font-normal mt-0.5">{{ $inv->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="bg-[#ebe7e1] text-[#111111] px-2 py-0.5 rounded text-[10px] font-mono font-medium">{{ $inv->category }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-[#111111]">
                                {{ $inv->quantity }} unit
                            </td>
                            <td class="py-3.5 px-4">
                                @if($inv->condition == 'Baik')
                                    <span class="badge-success text-[10px]">Baik</span>
                                @elseif($inv->condition == 'Rusak Ringan')
                                    <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded text-[10px] font-bold">Rusak Ringan</span>
                                @else
                                    <span class="badge-danger text-[10px]">Rusak Berat</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#626260]">
                                <i class="fa-solid fa-location-dot text-[#ff5600] text-[10px] mr-1"></i> {{ $inv->location }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('admin.inventories.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Hapus barang inventaris ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1 text-xs">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#626260]">
                                Belum ada data inventaris barang latihan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-[#ebe7e1]">
            {{ $inventories->links() }}
        </div>
    </div>
</div>

<!-- Modal Modal Tambah Barang Inventaris -->
<div id="modal-add-inventory" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-xl border border-[#d3cec6] space-y-4">
        <div class="flex items-center justify-between border-b border-[#ebe7e1] pb-3">
            <h3 class="font-bold text-sm text-[#111111]">Tambah Barang Inventaris Baru</h3>
            <button onclick="document.getElementById('modal-add-inventory').classList.add('hidden')" class="text-[#626260] hover:text-[#111111]">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="{{ route('admin.inventories.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Nama Barang *</label>
                <input type="text" name="item_name" required placeholder="Contoh: Bola Speeds Size 4" class="w-full border border-[#d3cec6] rounded px-3 py-2 focus:ring-[#ff5600] focus:border-[#ff5600]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold mb-1">Kategori *</label>
                    <select name="category" required class="w-full border border-[#d3cec6] rounded px-3 py-2 focus:ring-[#ff5600]">
                        <option value="Bola">Bola</option>
                        <option value="Rompi">Rompi Latihan</option>
                        <option value="Cone">Cone / Agility</option>
                        <option value="Medis">Medis / P3K</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Jumlah Unit *</label>
                    <input type="number" name="quantity" min="0" required value="10" class="w-full border border-[#d3cec6] rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold mb-1">Kondisi Barang *</label>
                    <select name="condition" required class="w-full border border-[#d3cec6] rounded px-3 py-2">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Lokasi Simpan *</label>
                    <input type="text" name="location" required value="Gudang Sekretariat" class="w-full border border-[#d3cec6] rounded px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Catatan Tambahan</label>
                <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="w-full border border-[#d3cec6] rounded px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-inventory').classList.add('hidden')" class="btn-secondary py-2 px-4">Batal</button>
                <button type="submit" class="btn-fin py-2 px-4">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>
@endsection
