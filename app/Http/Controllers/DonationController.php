<?php

namespace App\Http\Controllers;

use App\Models\FormDonasi;
use Illuminate\Http\Request;
use App\Models\KelolaDonasi;

class DonationController extends Controller
{
    public function index()
    {
        $donations = KelolaDonasi::with('uangDonasis')->get();
        
        // Ambil donasi terbaru
        $latestDonation = FormDonasi::with('donasi')->latest()->first();

        return view('home', compact('donations', 'latestDonation'));
    }
}


