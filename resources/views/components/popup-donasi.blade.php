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

            <div class="mb-3">
                <input type="number" name="nominal" class="form-control" placeholder="Rp. Masukkan Nominal" required>
            </div>

            <div class="mb-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            <div class="mb-3">
                <input type="text" name="kontak" class="form-control" placeholder="No Whatsapp atau Handphone" required>
            </div>

            <div class="mb-3">
                <textarea name="pesan" class="form-control" rows="3" placeholder="Tuliskan Pesan Atau Doa (Opsional)"></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">Donasi</button>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('form[action="{{ route('form-donasi-submit') }}"]');
                
                forms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        const nominal = form.querySelector('input[name="nominal"]').value;
                        if (parseInt(nominal) < 1000) {
                            e.preventDefault();
                            alert('Minimal nominal donasi adalah Rp1.000');
                        }
                    });
                });
            });
        </script>
    </div>
</div>
