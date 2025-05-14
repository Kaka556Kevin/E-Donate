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
        
        // Validasi awal
        if (!isset($payload->transaction_status)) {
            Log::warning('Payload tidak valid, transaction_status tidak ditemukan');
            return response()->json(['message' => 'Payload tidak valid'], 400);
        }

        // Proses hanya jika statusnya settlement atau capture (berhasil)
        if (in_array($payload->transaction_status, ['settlement', 'capture'])) {
            try {
                // Ambil data dari custom_field
                $customField3 = json_decode($payload->custom_field3 ?? '{}');
                $nama = $payload->custom_field2 ?? 'Anonim';
                $nominal = isset($customField3->nominal) ? (int) $customField3->nominal : 0;

                // Simpan ke form_donasi
                $formDonasi = FormDonasi::create([
                    'kelola_donasi_id' => $payload->custom_field1 ?? null,
                    'nama' => $nama,
                    'nominal' => $nominal,
                    'kontak' => $customField3->kontak ?? '-',
                    'pesan' => $customField3->pesan ?? null,
                    'transaction_status' => $payload->transaction_status,
                    'transaction_id' => $payload->order_id ?? null,
                ]);

                // Update donasi_terkumpul di kelola_donasi
                $kelolaDonasi = KelolaDonasi::find($formDonasi->kelola_donasi_id);
                if ($kelolaDonasi) {
                    $kelolaDonasi->donasi_terkumpul += $formDonasi->nominal;
                    $kelolaDonasi->save();
                    Log::info('Donasi ditambahkan ke kelola_donasi', [
                        'id' => $kelolaDonasi->id,
                        'nominal' => $formDonasi->nominal
                    ]);
                } else {
                    Log::warning('KelolaDonasi tidak ditemukan:', ['id' => $formDonasi->kelola_donasi_id]);
                }

                return response()->json([
                    'message' => 'Donasi berhasil diproses',
                    'status' => $payload->transaction_status
                ], 200);
            } catch (\Exception $e) {
                Log::error('Gagal memproses callback:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['message' => 'Gagal memproses callback'], 500);
            }
        } else {
            // Jika status pending, expire, cancel, dll
            Log::info('Callback diterima, tetapi status bukan settlement/capture:', [
                'status' => $payload->transaction_status,
                'order_id' => $payload->order_id ?? null
            ]);
            return response()->json(['message' => 'Status belum berhasil, tidak disimpan'], 200);
        }
    }
}
