@extends('layouts.app')

@section('title', 'E-Donate')

@section('content')

<div class="row align-items-center">
    <div class="col-md-6">
        <h5 class="text-light">Setiap Donasi, Setiap Harapan</h5>
        <h1 class="text-light fw-bold">E-Donate <br> Make easy for <br> Humanity</h1>
        <p class="text-light">Setiap rupiah yang kamu donasikan bukan hanya sekadar angka, 
        tetapi harapan bagi mereka yang membutuhkan. Mari bersama-sama menciptakan perubahan nyata!</p>
    </div>

    <div class="col-md-6">
        <div id="donationCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($donations as $key => $donation)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="card">
                            <img src="{{ $donation->image }}" class="card-img-top" alt="Gambar Donasi">
                            <div class="card-body">
                                <p class="text-success fw-bold">Rp.{{ number_format($donation->min_amount) }}-{{ number_format($donation->max_amount) }}</p>
                                <h5 class="fw-bold">{{ $donation->title }}</h5>
                                <p>{{ $donation->description }}</p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ ($donation->collected / $donation->target) * 100 }}%;" 
                                         aria-valuenow="{{ $donation->collected }}" 
                                         aria-valuemin="0" aria-valuemax="{{ $donation->target }}">
                                    </div>
                                </div>
                                <p class="mt-2">Terkumpul: Rp.{{ number_format($donation->collected) }} <span class="float-end">Target: Rp.{{ number_format($donation->target) }}</span></p>
                                <a href="#" class="btn btn-success w-100">Donasi Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#donationCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#donationCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</div>

@endsection
