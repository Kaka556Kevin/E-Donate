<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class FormDonasiController extends Controller
{
    public function store(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'DONASI-' . time(),
                'gross_amount' => (int) $request->nominal,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'phone' => $request->kontak,
            ],
            // Tambahkan custom_field1 - custom_field3 seperti ini:
            'custom_field1' => $request->kelola_donasi_id, // <-- PENTING! HARUS ADA
            'custom_field2' => $request->nama,
            'custom_field3' => json_encode([
                'kontak' => $request->kontak,
                'pesan' => $request->pesan,
                'nominal' => $request->nominal
            ]),
        ];          
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('midtrans', compact('snapToken'));
    }
}
