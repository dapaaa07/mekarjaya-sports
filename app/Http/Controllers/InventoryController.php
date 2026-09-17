<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $inventories = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.inventories.index', compact('inventories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|string',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Inventory::create($validated);
        return redirect()->route('admin.inventories.index')->with('success', 'Barang inventaris berhasil ditambahkan.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventories.index')->with('success', 'Data inventaris berhasil dihapus.');
    }
}
