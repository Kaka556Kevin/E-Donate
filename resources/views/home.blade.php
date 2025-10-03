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
                <button onclick="shareToWhatsApp()" class="btn btn-warning mt-2">
                    Bagikan Donasi Ini
                </button>
            </div>

            <!-- Bagian Kanan: Carousel Donasi -->
            <div class="col-md-6 d-flex justify-content-center">
                <div id="donationCarousel" 
                    class="carousel slide" 
                    data-bs-ride="carousel" 
                    data-bs-touch="false" 
                    data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach ($donations as $key => $donation)
                            @php
                                $terkumpul = $donation->donasi_terkumpul ?? 0;
                                $target = $donation->target_terkumpul ?? 0;
                                $persen = $target > 0 ? min(100, round(($terkumpul / $target) * 100)) : 0;

                                // Hitung sisa waktu
                                $sisaWaktuText = null;
                                if ($donation->tenggat_waktu_donasi) {
                                    $now = \Carbon\Carbon::now();
                                    $tenggat = \Carbon\Carbon::parse($donation->tenggat_waktu_donasi);
                                    $sisaSeconds = $tenggat->getTimestamp() - $now->getTimestamp();
                                    $sisaHari = (int) floor($sisaSeconds / 86400);

                                    if ($sisaHari > 30) {
                                        $bulan = (int) floor($sisaHari / 30);
                                        $sisaWaktuText = $bulan . ' bulan lagi';
                                    } elseif ($sisaHari > 0) {
                                        $sisaWaktuText = $sisaHari . ' hari lagi';
                                    } elseif ($sisaHari === 0 && $sisaSeconds >= 0) {
                                        $sisaWaktuText = 'Hari terakhir donasi!';
                                    } else {
                                        $sisaWaktuText = 'Donasi sudah ditutup';
                                    }
                                }
                            @endphp

                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="donation-card mx-auto position-relative">

                                    <!-- Ikon Info -->
                                    <button type="button" 
                                            class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#infoModal{{ $donation->id }}">
                                        <i class="bi bi-info-circle"></i>
                                    </button>

                                    <div class="donation-image">
                                        <img src="{{ asset('storage/' . $donation->gambar) }}" alt="{{ $donation->nama }}">
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">Sisihkan Sedikit Rejeki Anda</small>
                                        <h5 class="fw-bold mt-2">{{ $donation->nama }}</h5>
                                        <p class="text-muted">{{ $donation->deskripsi }}</p>

                                        <!-- Progress Bar + Persentase -->
                                        <div class="progress position-relative mt-2" style="height: 15px; border-radius: 10px; overflow: hidden;">
                                            <div class="progress-bar bg-success" 
                                                role="progressbar" 
                                                style="width: {{ $persen }}%;" 
                                                aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <span class="position-absolute w-100 text-center" 
                                                style="font-size: 12px; font-weight: bold; color: #000;">
                                                {{ $persen }}%
                                            </span>
                                        </div>

                                        <!-- Info Terkumpul & Target -->
                                        <p class="mt-3 text-dark fw-semibold small">
                                            Terkumpul: Rp {{ number_format($terkumpul, 0, ',', '.') }}
                                            <span class="float-end">
                                                Target: {{ $donation->target_terkumpul_formatted }}
                                            </span>
                                        </p>

                                        <!-- Sisa Waktu -->
                                        @if ($sisaWaktuText)
                                            <p class="text-danger small fw-bold mt-2">
                                                Sisa waktu: {{ $sisaWaktuText }}
                                            </p>
                                        @endif

                                        <!-- Tombol Donasi -->
                                        <button type="button" class="btn-donate" onclick="openPopup({{ $donation->id }})">
                                            Donasi Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Info Donasi -->
                            <div class="modal fade" id="infoModal{{ $donation->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
                                        
                                        <!-- Header Modal -->
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-info-circle me-2"></i> Detail Donasi: {{ $donation->nama }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Body Modal -->
                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                
                                                <!-- Gambar Donasi -->
                                                <div class="col-md-5">
                                                    <img src="{{ asset('storage/' . $donation->gambar) }}" 
                                                        alt="{{ $donation->nama }}" 
                                                        class="img-fluid rounded-3 shadow-sm">
                                                </div>

                                                <!-- Deskripsi Donasi -->
                                                <div class="col-md-7">
                                                    <h4 class="fw-bold text-success">{{ $donation->nama }}</h4>
                                                    <p class="text-muted" style="font-size: 15px;">
                                                        {{ $donation->deskripsi }}
                                                    </p>

                                                    <!-- Progress Bar -->
                                                    <div class="mb-3">
                                                        <label class="fw-semibold small mb-1">Progress Donasi</label>
                                                        <div class="progress position-relative" style="height: 18px; border-radius: 12px;">
                                                            <div class="progress-bar bg-success fw-bold" 
                                                                role="progressbar" 
                                                                style="width: {{ $persen }}%;">
                                                            </div>
                                                            <span class="position-absolute w-100 text-center small fw-bold text-dark">
                                                                {{ $persen }}%
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Informasi Terkumpul & Target -->
                                                    <ul class="list-group list-group-flush small">
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-semibold">Target Donasi:</span> 
                                                            <span>{{ $donation->target_terkumpul_formatted }}</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-semibold">Terkumpul:</span> 
                                                            <span>Rp {{ number_format($terkumpul, 0, ',', '.') }}</span>
                                                        </li>
                                                        @if ($sisaWaktuText)
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-semibold">Sisa Waktu:</span> 
                                                            <span class="text-danger fw-bold">{{ $sisaWaktuText }}</span>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer Modal -->
                                        <div class="modal-footer bg-light d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle me-1"></i> Tutup
                                            </button>
                                            <button type="button" class="btn btn-success" onclick="openPopup({{ $donation->id }})">
                                                <i class="bi bi-heart-fill me-1"></i> Donasi Sekarang
                                            </button>
                                        </div>
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

<!-- Notifikasi Donasi Baru -->
@if(isset($latestDonation) && $latestDonation)
    <div id="donation-toast" 
        class="position-fixed bottom-0 start-0 mb-3 ms-3 bg-primary text-white px-3 py-2 rounded shadow-sm"
        style="font-size: 14px; display:none; z-index:9999;">
        {{ $latestDonation->nama }} baru saja berdonasi 
        Rp{{ number_format($latestDonation->nominal, 0, ',', '.') }} 
        untuk <strong>{{ $latestDonation->donasi->nama }}</strong>
    </div>
@endif
@endsection

@section('scripts')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

    // Fungsi Bagikan ke WhatsApp
    function shareToWhatsApp() {
        const url = window.location.href; 
        const pesan = "Halo, yuk ikut berdonasi di E-Donate! Klik link berikut:  https://dalitmayaan.com/";
        const waUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(pesan);
        window.open(waUrl, "_blank"); 
    }

    document.addEventListener("DOMContentLoaded", function() {
        let toast = document.getElementById("donation-toast");
        if (toast) {
            toast.style.display = "block"; 
            setTimeout(() => {
                toast.style.display = "none"; 
            }, 5000);
        }
    });
</script>
@endsection
