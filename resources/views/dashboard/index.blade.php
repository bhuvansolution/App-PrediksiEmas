@extends('dashboard.layouts.app')
@section('container')
    <div class="container dashboard-container">
        <div class="row mb-4">
            <div class="col-12 col-lg-4">
                <div class="card custom-card">
                    <h5>Harga emas per Gram saat ini</h5>
                    <p class="gold-price">
                        <span class="icon">🪙</span> Gold (XAU): $ {{ $usd }}
                    </p>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card custom-card">
                    <h6>Harga Kemarin</h6>
                    <p class="gold-price">$ {{ $yesterday }}
                    </p>
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h5>5 Hari Terakhir</h5>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Harga Terendah</h6>
                    <p>${{ $harga_terendah }}</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Harga Tertinggi</h6>
                    <p>${{ $harga_tertinggi }}</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Laba 5 Hari (USD)</h6>
                    <p>${{ $laba_7_hari }}</p>
                </div>
            </div>

        </div>

        <p>Prediksi Besok: <strong>{{ ucfirst($prediksi) }}</strong></p>
        <ul>
            @foreach ($probabilitas as $kelas => $prob)
                <li>{{ $kelas }}: {{ number_format($prob, 8) }}</li>
            @endforeach
        </ul>
    </div>
@endsection
