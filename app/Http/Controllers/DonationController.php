<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller {
    public function index() {
        $donations = Donation::all();
        return view('home', compact('donations'));
    }
}

