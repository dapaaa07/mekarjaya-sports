@extends('layouts.admin')

@section('title', 'Inventaris Peralatan Latihan SSB - Mekar Jaya Sport Subang')
@section('page-header', 'Kelola Inventaris Alat Latihan')

@section('content')
<div class="space-y-6">

    <!-- Header Summary & Quick Action Button -->
    <div class="editorial-card p-6 border-l-[6px] border-l-[#FFFF00] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-base sm:text-lg text-[#111111] flex items-center gap-2">
                <i class="fa-solid fa-boxes-packing text-[#CC0000]" aria-hidden="true"></i> Master Inventaris Peralatan SSB
            </h2>
            <p class="text-xs text-[#525252] mt-0.5">Manajemen stok bola, rompi latihan, cone, gawang, dan fasilitas medis sekretariat.</p>
        </div>

        <button type="button" onclick="openAddInventoryModal()" class="btn-primary text-xs py-2.5 px-4">
            <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Tambah Barang Inventaris
        </button>
    </div>

    <!-- Inventory Filter & Search Bar -->
    <div class="editorial-card p-6">
        <form action="{{ route('admin.inventories.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Kategori Barang</label>
                <select name="category" onchange="this.form.submit()" class="ds-input text-sm py-2.5">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Bola" {{ request('category') == 'Bola' ? 'selected' : '' }}>Bola</option>
                    <option value="Rompi" {{ request('category') == 'Rompi' ? 'selected' : '' }}>Rompi Latihan</option>
                    <option value="Cone" {{ request('category') == 'Cone' ? 'selected' : '' }}>Cone &amp; Agility Ladder</option>
                    <option value="Medis" {{ request('category') == 'Medis' ? 'selected' : '' }}>Medis / P3K</option>
                    <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#111111] uppercase tracking-wider mb-1.5">Kondisi</label>
                <select name="condition" onchange="this.form.submit()" class="ds-input text-sm py-2.5">
                    <option value="">-- Semua Kondisi --</option>
                    <option value="Baik" {{ request('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>

            <div>
                <a href="{{ route('admin.inventories.index') }}" class="btn-secondary w-full text-xs py-2.5">Reset Filter</a>
            </div>
        </form>
    </div>

    <!-- Inventory Data Table -->
    <div class="editorial-card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-[#111111]">
                <thead>
                    <tr class="bg-[#111111] text-white text-[11px] font-mono font-bold uppercase tracking-wider">
                        <th class="py-4 px-4">Nama Barang</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4 text-center">Jumlah Stok</th>
                        <th class="py-4 px-4">Kondisi</th>
                        <th class="py-4 px-4">Lokasi Simpan</th>
                        <th class="py-4 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#111111] bg-white">
                    @forelse($inventories as $inv)
                        <tr class="hover:bg-[#F4F4F4] transition-colors">
                            <td class="py-3.5 px-4 font-bold text-[#111111]">
                                {{ $inv->item_name }}
                                @if($inv->notes)
                                    <span class="block text-[11px] text-[#525252] font-normal mt-0.5">{{ $inv->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="badge-secondary font-mono">{{ $inv->category }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold font-mono text-[#111111]">
                                {{ $inv->quantity }} unit
                            </td>
                            <td class="py-3.5 px-4">
                                @if($inv->condition == 'Baik')
                                    <span class="badge-success font-mono uppercase">Baik</span>
                                @elseif($inv->condition == 'Rusak Ringan')
                                    <span class="badge-primary font-mono uppercase">Rusak Ringan</span>
                                @else
                                    <span class="badge-danger font-mono uppercase">Rusak Berat</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#525252] font-medium">
                                <i class="fa-solid fa-location-dot text-[#CC0000] text-xs mr-1" aria-hidden="true"></i> {{ $inv->location }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('admin.inventories.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Hapus barang inventaris ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Hapus {{ $inv->item_name }}"
                                            class="w-10 h-10 bg-white text-[#991B1B] hover:bg-[#FF0000] hover:text-[#000000] border-2 border-[#111111] inline-flex items-center justify-center transition-colors cursor-pointer" title="Hapus Barang">
                                        <i class="fa-solid fa-trash text-xs" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-[#525252]">
                                Belum ada data inventaris barang latihan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-[#111111] bg-white">
            {{ $inventories->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Barang Inventaris (De Stijl Sharp 0px Modal) -->
<div id="modal-add-inventory" role="dialog" aria-modal="true" aria-labelledby="modal-add-inventory-title"
     class="fixed inset-0 bg-[#111111]/75 z-[300] flex items-center justify-center hidden p-4">
    <div class="bg-white max-w-md w-full border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden">
        <!-- Mondrian ribbon -->
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#111111]" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between border-b-2 border-[#111111] pb-3">
                <h3 id="modal-add-inventory-title" class="font-bold text-base text-[#111111]">Tambah Barang Inventaris Baru</h3>
                <button type="button" onclick="closeAddInventoryModal()" aria-label="Tutup dialog"
                        class="w-10 h-10 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
                </button>
            </div>

            <form action="{{ route('admin.inventories.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Nama Barang *</label>
                    <input type="text" name="item_name" required placeholder="Contoh: Bola Speeds Size 4" class="ds-input text-sm py-2.5">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kategori *</label>
                        <select name="category" required class="ds-input text-sm py-2.5">
                            <option value="Bola">Bola</option>
                            <option value="Rompi">Rompi Latihan</option>
                            <option value="Cone">Cone / Agility</option>
                            <option value="Medis">Medis / P3K</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Jumlah Unit *</label>
                        <input type="number" name="quantity" min="0" required value="10" class="ds-input text-sm py-2.5 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kondisi Barang *</label>
                        <select name="condition" required class="ds-input text-sm py-2.5">
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Lokasi Simpan *</label>
                        <input type="text" name="location" required value="Gudang Sekretariat" class="ds-input text-sm py-2.5">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="ds-input text-sm py-2.5"></textarea>
                </div>

                <div class="flex justify-end gap-2.5 pt-3 border-t-2 border-[#111111]">
                    <button type="button" onclick="closeAddInventoryModal()" class="btn-secondary text-xs py-2.5 px-4">Batal</button>
                    <button type="submit" class="btn-primary text-xs py-2.5 px-5 font-bold">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddInventoryModal() {
        const m = document.getElementById('modal-add-inventory');
        if (m) m.classList.remove('hidden');
    }
    function closeAddInventoryModal() {
        const m = document.getElementById('modal-add-inventory');
        if (m) m.classList.add('hidden');
    }
    document.getElementById('modal-add-inventory')?.addEventListener('click', function(e) {
        if (e.target === this) closeAddInventoryModal();
    });
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAddInventoryModal();
    });
</script>
@endsection
