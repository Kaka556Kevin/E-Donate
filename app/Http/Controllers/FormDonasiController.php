<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class FormDonasiController extends Controller
{
        public function store(Request $request)
    {
        // Validasi terlebih dahulu
        $request->validate([
            'nominal' => 'required|integer|min:1000',
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:20',
            'kelola_donasi_id' => 'required|exists:kelola_donasi,id'
        ], [
            'nominal.min' => 'Minimal nominal donasi adalah Rp1.000'
        ]);

        // Jika validasi lolos, lanjut ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'DONASI-' . time(),
                'gross_amount' => (int) $request->nominal,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'phone' => $request->kontak,
            ],
            'custom_field1' => $request->kelola_donasi_id,
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
