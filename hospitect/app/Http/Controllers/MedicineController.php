<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian nama dan parameter sorting
        $search = $request->get('search', ''); // Default pencarian kosong
        $sortBy = $request->get('sortBy', 'name'); // Default sorting berdasarkan nama
        $sortDirection = $request->get('sortDirection', 'asc'); // Default urutkan secara ascending

        // Filter dan sorting berdasarkan input
        $medicines = Medicine::query()
            ->where('name', 'like', '%' . $search . '%') // Filter berdasarkan nama obat
            ->orderBy($sortBy, $sortDirection)
            ->get();

        return view('admin.medicines.index', compact('medicines', 'search', 'sortBy', 'sortDirection'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'type', 'stock']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }


        Medicine::create($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'type', 'stock']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil dihapus');
    }
}
