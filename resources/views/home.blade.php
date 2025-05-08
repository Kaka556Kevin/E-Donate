@extends('layouts.app')

@section('title', 'E-Donate')

@section('content')
<div class="main-section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <!-- Bagian Kiri: Teks -->
            <div class="col-md-6 text-white text-md-start text-center mb-5 mb-md-0">
                <h6>Setiap Donasi, Setiap Harapan</h6>
                <h1 class="fw-bold display-5">
                    E-Donate <br> Make easy for <br> Humanity
                </h1>
                <p class="mt-3">
                    Setiap rupiah yang kamu donasikan bukan hanya sekadar angka, 
                    tetapi harapan bagi mereka yang membutuhkan. 
                    Mari bersama-sama menciptakan perubahan nyata!
                </p>

                <!-- Tombol Bagikan -->
                <button onclick="copyLink()" class="btn btn-warning mt-2">
                    Bagikan Donasi Ini
                </button>

                <!-- Notifikasi -->
                <small id="copyMessage" class="text-white d-none mt-1">Link berhasil disalin!</small>
            </div>

            <!-- Bagian Kanan: Carousel Donasi -->
            <div class="col-md-6 d-flex justify-content-center">
                <div id="donationCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($donations as $key => $donation)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="donation-card mx-auto">
                                    <div class="donation-image">
                                        <img src="{{ asset('storage/' . $donation->gambar) }}" alt="{{ $donation->nama }}">
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">Sisihkan Sedikit Rejeki Anda</small>
                                        <h5 class="fw-bold mt-2">{{ $donation->nama }}</h5>
                                        <p class="text-muted">{{ $donation->deskripsi }}</p>

                                        @php
                                            $terkumpul = $donation->donasi_terkumpul ?? 0;
                                            $target = $donation->target_terkumpul;
                                            $persen = $target > 0 ? min(100, round(($terkumpul / $target) * 100)) : 0;
                                        @endphp

                                        <div class="donation-progress">
                                            <div class="donation-progress-bar" style="width: {{ $persen }}%;"></div>
                                        </div>

                                        <p class="mt-3 text-dark fw-semibold">
                                            <span class="small">
                                                Terkumpul: Rp {{ number_format($terkumpul, 0, ',', '.') }}
                                            </span>
                                            <span class="float-end text-dark fw-semibold small">
                                                Target: {{ $donation->target_terkumpul_formatted }}
                                            </span>
                                        </p>

                                        <!-- Tombol Donasi -->
                                        <button type="button" class="btn-donate" onclick="openPopup({{ $donation->id }})">
                                            Donasi Sekarang
                                        </button>                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigasi Carousel -->
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
</div>

<!-- Include Semua Pop-up Donasi -->
@foreach ($donations as $donation)
    @include('components.popup-donasi', ['donasi' => $donation])
@endforeach
@endsection

@section('scripts')
<script>
    function openPopup(id) {
        const popup = document.getElementById('popup-donasi-' + id);
        if (popup) {
            popup.style.display = 'flex';
        }
    }

    function closePopup(id) {
        const popup = document.getElementById('popup-donasi-' + id);
        if (popup) {
            popup.style.display = 'none';
        }
    }

    // Tutup popup jika klik di luar
    window.onclick = function(event) {
        document.querySelectorAll('.popup-donasi').forEach(popup => {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });
    }
</script>

<script>
    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            const msg = document.getElementById('copyMessage');
            msg.classList.remove('d-none');
            setTimeout(() => {
                msg.classList.add('d-none');
            }, 2000); // Sembunyikan notifikasi setelah 2 detik
        });
    }
</script>

@endsection
