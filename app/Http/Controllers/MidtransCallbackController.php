<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormDonasi;
use Illuminate\Support\Facades\Log;
use App\Models\KelolaDonasi;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        Log::info('Midtrans Callback Raw:', ['raw' => $request->getContent()]);
        $payload = json_decode($request->getContent());
        Log::info('Callback Diterima:', (array) $payload);
    
        if (
            isset($payload->transaction_status) &&
            in_array($payload->transaction_status, ['settlement', 'capture'])
        ) {
            try {
                // Ambil data dari custom_field
                $customField3 = json_decode($payload->custom_field3 ?? '{}');
                $nama = $payload->custom_field2 ?? 'Anonim';
    
                $formDonasi = FormDonasi::create([
                    'kelola_donasi_id' => $payload->custom_field1 ?? null,
                    'nama' => $nama,
                    'nominal' => isset($customField3->nominal) ? (int) $customField3->nominal : 0,
                    'kontak' => $customField3->kontak ?? '-',
                    'pesan' => $customField3->pesan ?? null,
                ]);
    
                // Update ke kelola_donasi
                $kelolaDonasi = KelolaDonasi::find($formDonasi->kelola_donasi_id);
                if ($kelolaDonasi) {
                    $kelolaDonasi->donasi_terkumpul += $formDonasi->nominal;
                    $kelolaDonasi->save();
                } else {
                    Log::warning('KelolaDonasi tidak ditemukan:', ['id' => $formDonasi->kelola_donasi_id]);
                }
    
                return response()->json(['message' => 'Donasi berhasil disimpan'], 200);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan donasi:', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Gagal menyimpan donasi'], 500);
            }
        }
    
        return response()->json(['message' => 'Status tidak valid'], 400);
    }
}