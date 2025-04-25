<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\KelolaDonasi;
use Illuminate\Http\Request;

class KelolaDonasiController extends Controller
{
    // Ambil semua data donasi
    public function index()
    {
        $donations = KelolaDonasi::all();
        return response()->json($donations);
    }

    // Tambah data donasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
            'target_terkumpul' => 'required|numeric',
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('public/donasi');
            $validated['gambar'] = str_replace('public/', '', $path);
        }

        $donation = KelolaDonasi::create($validated);
        return response()->json($donation, 201);
    }

    // Ambil detail data donasi berdasarkan ID
    public function show($id)
    {
        $donation = KelolaDonasi::findOrFail($id);
        return response()->json($donation);
    }

    // Update data donasi berdasarkan ID
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'sometimes|required|string',
            'target_terkumpul' => 'sometimes|required|numeric',
        ]);

        $donation = KelolaDonasi::findOrFail($id);

        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('public/donasi');
            $validated['gambar'] = str_replace('public/', '', $path);
        }

        $donation->update($validated);
        return response()->json($donation);
    }

    // Hapus data donasi berdasarkan ID
    public function destroy($id)
    {
        $donation = KelolaDonasi::findOrFail($id);
        $donation->delete();
        return response()->json(['message' => 'Donasi berhasil dihapus'], 200);
    }
}