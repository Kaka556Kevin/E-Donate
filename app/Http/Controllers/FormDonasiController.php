<?php

namespace App\Http\Controllers;

use App\Models\FormDonasi;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class FormDonasiController extends Controller
{
    public function store(Request $request)
{
    // Simpan data dulu
    $form = FormDonasi::create([
        'nama' => $request->nama,
        'nominal' => $request->nominal,
        'kontak' => $request->kontak,
        'pesan' => $request->pesan,
        'kelola_donasi_id' => $request->kelola_donasi_id
    ]);

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    // Buat transaksi Snap
    $params = [
        'transaction_details' => [
            'order_id' => 'DONASI-' . $form->id,
            'gross_amount' => (int)$request->nominal,
        ],
        'customer_details' => [
            'first_name' => $request->nama,
            'phone' => $request->whatsapp,
        ]
    ];

    $snapToken = Snap::getSnapToken($params);

    return view('midtrans', compact('snapToken'));
}
}
