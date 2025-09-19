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
                            @php
                                $terkumpul = $donation->donasi_terkumpul ?? 0;
                                $target = $donation->target_terkumpul ?? 0;
                                $persen = $target > 0 ? min(100, round(($terkumpul / $target) * 100)) : 0;

                                // ----- perhitungan sisa waktu yang ROBUST (tidak menghasilkan desimal) -----
                                $sisaWaktuText = null;
                                if ($donation->tenggat_waktu_donasi) {
                                    $now = \Carbon\Carbon::now();
                                    $tenggat = \Carbon\Carbon::parse($donation->tenggat_waktu_donasi);

                                    // Selisih detik (bisa positif/negatif)
                                    $sisaSeconds = $tenggat->getTimestamp() - $now->getTimestamp();

                                    // Hari (float) = detik / 86400, lalu dibulatkan ke bawah agar tanpa angka desimal
                                    $sisaHariFloat = $sisaSeconds / 86400;
                                    $sisaHari = (int) floor($sisaHariFloat);

                                    if ($sisaHari > 30) {
                                        $bulan = (int) floor($sisaHari / 30);
                                        $sisaWaktuText = $bulan . ' bulan lagi';
                                    } elseif ($sisaHari > 0) {
                                        $sisaWaktuText = $sisaHari . ' hari lagi';
                                    } elseif ($sisaHari === 0 && $sisaSeconds >= 0) {
                                        // masih hari ini (kurang dari 24 jam tersisa)
                                        $sisaWaktuText = 'Hari terakhir donasi!';
                                    } else {
                                        $sisaWaktuText = 'Donasi sudah ditutup';
                                    }
                                }
                            @endphp

                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="donation-card mx-auto">
                                    <div class="donation-image">
                                        <img src="{{ asset('storage/' . $donation->gambar) }}" alt="{{ $donation->nama }}">
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">Sisihkan Sedikit Rejeki Anda</small>
                                        <h5 class="fw-bold mt-2">{{ $donation->nama }}</h5>
                                        <p class="text-muted">{{ $donation->deskripsi }}</p>


                                        <!-- Progress Bar + Persentase -->
                                        <div class="progress position-relative mt-2" style="height: 15px; border-radius: 10px; overflow: hidden;">
                                            <!-- Bar isi -->
                                            <div class="progress-bar bg-success" 
                                                role="progressbar" 
                                                style="width: {{ $persen }}%;" 
                                                aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <!-- Teks persentase di tengah -->
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

                                        <!-- Sisa Waktu (tanpa menampilkan tanggal) -->
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

    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            const msg = document.getElementById('copyMessage');
            msg.classList.remove('d-none');
            setTimeout(() => {
                msg.classList.add('d-none');
            }, 2000);
        });
    }
</script>
@endsection
