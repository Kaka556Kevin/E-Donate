<?php

namespace App\Http\Controllers;

use App\Models\FormDonasi;
use Illuminate\Http\Request;

class FormDonasiController extends Controller
{
    public function store(Request $request)
    {
        FormDonasi::create($request->all());
        return redirect()->back()->with('success', 'Terima kasih sudah berdonasi!');
    }
}
