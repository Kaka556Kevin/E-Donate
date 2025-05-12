<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormDonasi;
use Illuminate\Support\Facades\Validator;

class FormDonasiController extends Controller
{
    /**
     * Ambil semua data form donasi.
     */
    public function index()
    {
        $formDonasi = FormDonasi::with('donasi')->get();
        return response()->json([
            'success' => true,
            'data' => $formDonasi
        ], 200);
    }

    /**
     * Simpan data form donasi baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelola_donasi_id' => 'required|exists:kelola_donasi,id',
            'nama' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'kontak' => 'required|string',
            'pesan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $formDonasi = FormDonasi::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.',
            'data' => $formDonasi
        ], 201);
    }

    /**
     * Ambil detail form donasi berdasarkan ID.
     */
    public function show($id)
    {
        $formDonasi = FormDonasi::with('donasi')->find($id);

        if (!$formDonasi) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $formDonasi
        ], 200);
    }

    /**
     * Hapus data form donasi.
     */
    public function destroy($id)
    {
        $formDonasi = FormDonasi::find($id);

        if (!$formDonasi) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $formDonasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ], 200);
    }
}