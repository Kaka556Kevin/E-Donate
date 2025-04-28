@extends('layouts.app')

@section('content')
<div class="text-center mt-5">
    <h3 style="display:flex justify-content:center; align-items:center; padding-top:50px;">Mohon tunggu, Anda akan diarahkan ke pembayaran...</h3>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    window.onload = function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ url('/') }}";
            },
            onPending: function(result) {
                window.location.href = "{{ url('/donasi/pending') }}";
            },
            onError: function(result) {
                alert("Pembayaran gagal. Silakan coba lagi.");
                window.location.href = "{{ url('/donasi/gagal') }}";
            }
        });
    };
</script>
@endsection
