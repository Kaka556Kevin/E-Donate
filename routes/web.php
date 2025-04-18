<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Http\Controllers\FormDonasiController;

Route::get('/', [DonationController::class, 'index']);

FacadesAuth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/form-donasi', [FormDonasiController::class, 'store'])->name('form-donasi.store');

