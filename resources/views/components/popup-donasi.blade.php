<div class="popup-donasi" id="popup-donasi-{{ $donasi->id }}">
    <div class="popup-content">
        <button type="button" class="close-popup" onclick="closePopup({{ $donasi->id }})">&times;</button>

        <div class="popup-header d-flex align-items-center gap-3 mb-3">
            <img src="{{ asset('storage/' . $donasi->gambar) }}" alt="Gambar Donasi" class="popup-image rounded">
            <div>
                <p class="popup-subtitle mb-0">Anda Akan Berdonasi dalam program:</p>
                <h5 class="popup-title fw-bold m-0">{{ $donasi->nama }}</h5>
            </div>
        </div>

        <p class="popup-caption">Donasi Terbaik Anda</p>

        <form action="{{ route('form-donasi-submit') }}" method="POST">
            @csrf
            <input type="hidden" name="kelola_donasi_id" value="{{ $donasi->id }}">

            {{-- Input Nominal dengan step 1000 --}}
            <div class="mb-3">
                <input type="number" 
                       name="nominal" 
                       class="form-control" 
                       placeholder="Rp. Masukkan Nominal (Minimal Rp.1000)" 
                       step="1000" 
                       required>
                <small class="text-danger d-none" id="error-nominal-{{ $donasi->id }}">
                    Minimal donasi Rp.1000
                </small>
            </div>

            {{-- Input Nama --}}
            <div class="mb-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            {{-- Input Kontak (Hanya angka & simbol -) --}}
            <div class="mb-3">
                <input type="text" name="kontak" id="kontak-{{ $donasi->id }}" class="form-control" placeholder="No Whatsapp atau Handphone" required>
            </div>

            {{-- Pesan/Doa --}}
            <div class="mb-3">
                <textarea name="pesan" class="form-control" rows="3" placeholder="Tuliskan Pesan Atau Doa (Opsional)"></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">Donasi</button>
        </form>

        {{-- Script Validasi --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const nominalInput = document.querySelector('#popup-donasi-{{ $donasi->id }} input[name="nominal"]');
                const errorText = document.getElementById('error-nominal-{{ $donasi->id }}');
                const form = nominalInput.closest('form');
                const kontakInput = document.getElementById('kontak-{{ $donasi->id }}');

                // Validasi nominal realtime
                nominalInput.addEventListener('input', function () {
                    const nominal = parseInt(nominalInput.value);

                    if (isNaN(nominal) || nominal < 1000) {
                        errorText.classList.remove('d-none');
                        nominalInput.classList.add('is-invalid');
                    } else {
                        errorText.classList.add('d-none');
                        nominalInput.classList.remove('is-invalid');
                    }
                });

                // Validasi nominal saat submit
                form.addEventListener('submit', function (e) {
                    const nominal = parseInt(nominalInput.value);

                    if (isNaN(nominal) || nominal < 1000) {
                        e.preventDefault();
                        errorText.classList.remove('d-none');
                        nominalInput.classList.add('is-invalid');
                    }
                });

                // Validasi input kontak (hanya angka dan simbol -)
                kontakInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9\-]/g, '');
                });
            });
        </script>
    </div>
</div>
