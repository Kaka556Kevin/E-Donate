@extends('layouts.main')

@section('content')
<div class="flex flex-col md:flex-row items-center justify-between min-h-screen">
    <div class="w-full md:w-1/2 p-6">
        <h2 class="text-gray-400 font-semibold">Every Donation, Every Hope</h2>
        <h1 class="text-5xl font-bold mt-2">E-Donate<br>Make Giving Easy for Humanity</h1>
        <p class="mt-4 text-gray-300">
            Every rupiah you donate is not just a number, but a hope for those in need.
            Let's create real change together!
        </p>
    </div>
    <div class="w-full md:w-1/2">
        <div class="donation-carousel">
            @foreach($donations as $donation)
            <div class="p-4 bg-white rounded-2xl shadow-lg text-black">
                <img src="{{ $donation->image }}" alt="{{ $donation->title }}" class="rounded-xl w-full h-52 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg">{{ $donation->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $donation->description }}</p>
                    <div class="mt-2 text-sm text-gray-500">
                        <span>Raised: Rp.{{ number_format($donation->collected) }}</span>
                        <span class="float-right">Target: Rp.{{ number_format($donation->target) }}</span>
                    </div>
                    <a href="#" class="block text-center bg-green-600 text-white font-bold py-2 px-4 rounded-xl mt-4">Donate Now</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
