<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KelolaDonasiController;

Route::get('/donations', [KelolaDonasiController::class, 'index']);
Route::post('/donations', [KelolaDonasiController::class, 'store']);
Route::get('/donations/{id}', [KelolaDonasiController::class, 'show']);
Route::put('/donations/{id}', [KelolaDonasiController::class, 'update']);
Route::patch('/donations/{id}', [KelolaDonasiController::class, 'update']);
Route::delete('/donations/{id}', [KelolaDonasiController::class, 'destroy']);

use App\Http\Controllers\MidtransCallbackController;

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive']);

