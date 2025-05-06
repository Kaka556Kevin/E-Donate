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
        
        // Validasi payload
        if (!isset($payload->transaction_status)) {
            Log::warning('Payload tidak valid, transaction_status tidak ditemukan');
            return response()->json(['message' => 'Payload tidak valid'], 400);
        }
        
        try {
            // Ambil data dari custom_field
            $customField3 = json_decode($payload->custom_field3 ?? '{}');
            $nama = $payload->custom_field2 ?? 'Anonim';
            $nominal = isset($customField3->nominal) ? (int) $customField3->nominal : 0;
            
            // Simpan semua transaksi yang masuk dengan status apapun
            $formDonasi = FormDonasi::create([
                'kelola_donasi_id' => $payload->custom_field1 ?? null,
                'nama' => $nama,
                'nominal' => $nominal,
                'kontak' => $customField3->kontak ?? '-',
                'pesan' => $customField3->pesan ?? null,
                'transaction_status' => $payload->transaction_status, // Tambahkan field transaction_status
                'transaction_id' => $payload->order_id ?? null, // Simpan ID transaksi untuk referensi
            ]);
            
            // Update ke kelola_donasi hanya jika status settlement atau capture
            if (in_array($payload->transaction_status, ['settlement', 'capture'])) {
                $kelolaDonasi = KelolaDonasi::find($formDonasi->kelola_donasi_id);
                if ($kelolaDonasi) {
                    $kelolaDonasi->donasi_terkumpul += $formDonasi->nominal;
                    $kelolaDonasi->save();
                    Log::info('Donasi berhasil ditambahkan ke kelola_donasi', [
                        'id' => $kelolaDonasi->id,
                        'nominal' => $formDonasi->nominal,
                        'total_terkumpul' => $kelolaDonasi->donasi_terkumpul
                    ]);
                } else {
                    Log::warning('KelolaDonasi tidak ditemukan:', ['id' => $formDonasi->kelola_donasi_id]);
                }
            } else {
                // Log untuk status selain settlement atau capture
                Log::info('Transaksi disimpan dengan status: ' . $payload->transaction_status, [
                    'order_id' => $payload->order_id ?? null,
                    'nominal' => $nominal
                ]);
            }
            
            return response()->json([
                'message' => 'Callback diterima',
                'status' => $payload->transaction_status
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Gagal memproses callback:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Gagal memproses callback'], 500);
        }
    }
    
    /**
     * Metode untuk memperbarui status transaksi jika ada perubahan
     * Bisa digunakan untuk menangani callback dari status pending ke settlement
     */
    public function updateStatus(Request $request)
    {
        Log::info('Update Status Callback:', ['raw' => $request->getContent()]);
        $payload = json_decode($request->getContent());
        
        if (!isset($payload->order_id) || !isset($payload->transaction_status)) {
            return response()->json(['message' => 'Data tidak lengkap'], 400);
        }
        
        try {
            // Cari transaksi berdasarkan order_id
            $formDonasi = FormDonasi::where('transaction_id', $payload->order_id)->first();
            
            if (!$formDonasi) {
                Log::warning('Transaksi tidak ditemukan:', ['order_id' => $payload->order_id]);
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }
            
            // Update status transaksi
            $oldStatus = $formDonasi->transaction_status;
            $formDonasi->transaction_status = $payload->transaction_status;
            $formDonasi->save();
            
            Log::info('Status transaksi diperbarui:', [
                'order_id' => $payload->order_id,
                'old_status' => $oldStatus,
                'new_status' => $payload->transaction_status
            ]);
            
            // Jika status berubah menjadi settlement atau capture, update kelola_donasi
            if (in_array($payload->transaction_status, ['settlement', 'capture']) && 
                !in_array($oldStatus, ['settlement', 'capture'])) {
                
                $kelolaDonasi = KelolaDonasi::find($formDonasi->kelola_donasi_id);
                if ($kelolaDonasi) {
                    $kelolaDonasi->donasi_terkumpul += $formDonasi->nominal;
                    $kelolaDonasi->save();
                    
                    Log::info('Donasi ditambahkan ke kelola_donasi setelah update status', [
                        'id' => $kelolaDonasi->id,
                        'nominal' => $formDonasi->nominal
                    ]);
                }
            }
            
            return response()->json([
                'message' => 'Status transaksi berhasil diperbarui',
                'new_status' => $payload->transaction_status
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui status:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Gagal memperbarui status'], 500);
        }
    }
}