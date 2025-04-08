@extends('layouts.app')

@section('title', 'E-Donate')

@section('content')
<div class="main-section container">
    <div class="row justify-content-between align-items-center w-100">
        <!-- Teks Kiri -->
        <div class="col-md-6 text-white text-md-start text-center mb-5 mb-md-0">
            <h6>Setiap Donasi, Setiap Harapan</h6>
            <h1 class="fw-bold display-5">E-Donate <br> Make easy for <br> Humanity</h1>
            <p class="mt-3">Setiap rupiah yang kamu donasikan bukan hanya sekadar angka, tetapi harapan bagi mereka yang membutuhkan. Mari bersama-sama menciptakan perubahan nyata!</p>
        </div>

        <!-- Carousel Kanan -->
        <div class="col-md-6 d-flex justify-content-center">
            <div id="donationCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($donations as $key => $donasi)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="donation-card mx-auto">
                                <div class="donation-image">
                                    <img src="{{ asset('storage/' . $donasi->gambar) }}" alt="Donasi">
                                </div>
                                <div class="mt-3">
                                    <p class="text-success fw-bold">{{ $donasi->getTargetTerkumpulFormattedAttribute() }}</p>
                                    <small class="text-muted">Sisihkan Sedikit Rejeki Anda</small>
                                    <h5 class="fw-bold mt-2">{{ $donasi->nama }}</h5>
                                    <p class="text-muted">{{ $donasi->deskripsi }}</p>
                                    
                                    {{-- Progress bar dummy (bisa disesuaikan dengan data riil jika ada kolom `terkumpul`) --}}
                                    <div class="donation-progress">
                                        <div class="donation-progress-bar" style="width: 40%;"></div>
                                    </div>
                                    <p class="mt-2">
                                        Terkumpul: <span class="text-muted">Rp 0</span>
                                        <span class="float-end">Target: {{ $donasi->getTargetTerkumpulFormattedAttribute() }}</span>
                                    </p>
                                    <a href="#" class="btn-donate">Donasi Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigasi carousel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#donationCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#donationCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
