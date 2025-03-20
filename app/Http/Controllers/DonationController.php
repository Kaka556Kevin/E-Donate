<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller {
    public function index() {
        $donations = Donation::all();
        return view('home', compact('donations'));
    }
}

