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
            <div class="col-6 col-lg-2">
                <div class="card custom-card">
                    <h6>Laba Kemarin</h6>
                    <p>${{ $laba_per_gram_usd }}</p>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card custom-card">
                    <h6>Laba Kemarin (%)</h6>
                    <p>{{ $persentase_laba }}%</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h5>Prediksi laba satu tahun ke depan</h5>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>CAGR (USD)</h6>
                    <p>$0</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>CAGR (%)</h6>
                    <p>0%</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Moving Average (USD)</h6>
                    <p>$0</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Moving Average (%)</h6>
                    <p>0%</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h5>7 Hari Terakhir</h5>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Harga Terendah</h6>
                    <p>$0</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Harga Tertinggi</h6>
                    <p>$0</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Laba 7 Hari (USD)</h6>
                    <p>$0</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card custom-card">
                    <h6>Laba 7 Hari (%)</h6>
                    <p>0%</p>
                </div>
            </div>
        </div>
    </div>
@endsection
