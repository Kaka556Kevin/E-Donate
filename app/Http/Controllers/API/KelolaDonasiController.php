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
        // Validasi data, termasuk file gambar sebagai required
        $validated = $request->validate([
            'nama' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
            'target_terkumpul' => 'required|numeric',
            'tenggat_waktu_donasi' => 'required|date',
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('', 'public');
            $validated['gambar'] = $path;
        }

        // Simpan data ke database
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
        // Validasi data, termasuk file gambar sebagai opsional
        $validated = $request->validate([
            'nama' => 'sometimes|required|string',
            'gambar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'sometimes|required|string',
            'target_terkumpul' => 'sometimes|required|numeric',
            'tenggat_waktu_donasi' => 'sometimes|required|date',
        ]);

        // Ambil data donasi berdasarkan ID
        $donation = KelolaDonasi::findOrFail($id);

        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus file gambar lama jika ada
            if ($donation->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($donation->gambar);
            }

            // Simpan file gambar baru
            $path = $request->file('gambar')->store('', 'public');
            $validated['gambar'] = $path;
        }

        // Update data di database
        $updated = $donation->update($validated);

        if ($updated) {
            // Refresh model untuk mendapatkan data terbaru dari database
            $donation->refresh();
            return response()->json($donation);
        } else {
            return response()->json(['message' => 'Update failed'], 500);
        }
    }

    // Hapus data donasi berdasarkan ID
    public function destroy($id)
    {
        $donation = KelolaDonasi::findOrFail($id);
        $donation->delete();
        return response()->json(['message' => 'Donasi berhasil dihapus'], 200);
    }
}
