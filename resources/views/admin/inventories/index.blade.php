@extends('layouts.admin')

@section('title', 'Inventaris Peralatan Latihan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Kelola Inventaris Alat Latihan')

@section('content')
<div class="space-y-6">

    <!-- Header Summary & Quick Action Button (Cooking App 16px Card) -->
    <div class="editorial-card p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-extrabold text-base text-[#111111] flex items-center gap-2">
                <i class="fa-solid fa-boxes-packing text-[#FF6B00]"></i> Master Inventaris Peralatan SSB
            </h2>
            <p class="text-xs text-[#666666]">Manajemen stok bola, rompi latihan, cone, gawang, dan fasilitas medis sekretariat.</p>
        </div>
        
        <button onclick="document.getElementById('modal-add-inventory').classList.remove('hidden')" class="btn-primary text-xs py-2.5 px-4 rounded-xl flex items-center gap-2 font-medium shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Barang Inventaris
        </button>
    </div>

    <!-- Inventory Filter & Search Bar -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.inventories.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-[11px] font-semibold text-[#111111] uppercase tracking-wider mb-1.5">Kategori Barang</label>
                <select name="category" onchange="this.form.submit()" class="w-full bg-white border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-xs text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Bola" {{ request('category') == 'Bola' ? 'selected' : '' }}>Bola</option>
                    <option value="Rompi" {{ request('category') == 'Rompi' ? 'selected' : '' }}>Rompi Latihan</option>
                    <option value="Cone" {{ request('category') == 'Cone' ? 'selected' : '' }}>Cone & Agility Ladder</option>
                    <option value="Medis" {{ request('category') == 'Medis' ? 'selected' : '' }}>Medis / P3K</option>
                    <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-[#111111] uppercase tracking-wider mb-1.5">Kondisi</label>
                <select name="condition" onchange="this.form.submit()" class="w-full bg-white border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-xs text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                    <option value="">-- Semua Kondisi --</option>
                    <option value="Baik" {{ request('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>

            <div class="flex items-end">
                <a href="{{ route('admin.inventories.index') }}" class="btn-secondary w-full text-xs py-2.5 rounded-xl text-center font-medium">Reset Filter</a>
            </div>
        </form>
    </div>

    <!-- Inventory Data Table -->
    <div class="editorial-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-[#111111]">
                <thead>
                    <tr class="bg-[#FAFAFA] border-b border-[#EAEAEA] text-[11px] font-semibold text-[#111111] uppercase tracking-wider">
                        <th class="py-4 px-4">Nama Barang</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4 text-center">Jumlah Stok</th>
                        <th class="py-4 px-4">Kondisi</th>
                        <th class="py-4 px-4">Lokasi Simpan</th>
                        <th class="py-4 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAEAEA]">
                    @forelse($inventories as $inv)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                            <td class="py-3.5 px-4 font-bold text-[#111111]">
                                {{ $inv->item_name }}
                                @if($inv->notes)
                                    <span class="block text-[10px] text-[#666666] font-normal mt-0.5">{{ $inv->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="bg-[#F9F9F9] border border-[#EAEAEA] text-[#111111] px-2.5 py-1 rounded-lg text-[10px] font-mono font-medium">{{ $inv->category }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold font-mono text-[#111111]">
                                {{ $inv->quantity }} unit
                            </td>
                            <td class="py-3.5 px-4">
                                @if($inv->condition == 'Baik')
                                    <span class="badge-success text-[10px]">Baik</span>
                                @elseif($inv->condition == 'Rusak Ringan')
                                    <span class="bg-amber-50 border border-amber-200 text-amber-700 px-2.5 py-0.5 rounded-lg text-[10px] font-bold">Rusak Ringan</span>
                                @else
                                    <span class="badge-danger text-[10px]">Rusak Berat</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#666666]">
                                <i class="fa-solid fa-location-dot text-[#FF6B00] text-[10px] mr-1"></i> {{ $inv->location }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('admin.inventories.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Hapus barang inventaris ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-[#FAFAFA] text-[#EF4444] hover:bg-[#EF4444] hover:text-white flex items-center justify-center transition-colors border border-[#EAEAEA]" title="Hapus Barang">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-[#666666]">
                                Belum ada data inventaris barang latihan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-[#EAEAEA]">
            {{ $inventories->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Barang Inventaris (Cooking App 16px Rounded Dialog) -->
<div id="modal-add-inventory" class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-[#EAEAEA] space-y-4">
        <div class="flex items-center justify-between border-b border-[#EAEAEA] pb-3">
            <h3 class="font-extrabold text-base text-[#111111]">Tambah Barang Inventaris Baru</h3>
            <button onclick="document.getElementById('modal-add-inventory').classList.add('hidden')" class="text-[#666666] hover:text-[#111111]">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.inventories.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Nama Barang *</label>
                <input type="text" name="item_name" required placeholder="Contoh: Bola Speeds Size 4" class="w-full border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Kategori *</label>
                    <select name="category" required class="w-full border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                        <option value="Bola">Bola</option>
                        <option value="Rompi">Rompi Latihan</option>
                        <option value="Cone">Cone / Agility</option>
                        <option value="Medis">Medis / P3K</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Jumlah Unit *</label>
                    <input type="number" name="quantity" min="0" required value="10" class="w-full border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Kondisi Barang *</label>
                    <select name="condition" required class="w-full border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Lokasi Simpan *</label>
                    <input type="text" name="location" required value="Gudang Sekretariat" class="w-full border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Catatan Tambahan</label>
                <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="w-full border border-[#EAEAEA] rounded-xl px-3.5 py-2.5 text-[#111111] focus:ring-2 focus:ring-[#FF6B00] focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2.5 pt-2 border-t border-[#EAEAEA]">
                <button type="button" onclick="document.getElementById('modal-add-inventory').classList.add('hidden')" class="btn-secondary py-2.5 px-4 rounded-xl font-medium">Batal</button>
                <button type="submit" class="btn-primary py-2.5 px-5 rounded-xl font-semibold shadow-sm">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>
@endsection
