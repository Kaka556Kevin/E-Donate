<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

Route::get('/', [DonationController::class, 'index']);

FacadesAuth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

