<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $apiKey = '86f94bb030e68c9f2755bdf8cdecf8a7';
        $baseUrl = 'https://api.metalpriceapi.com/v1/';
        $usdToXauKey = 'rates.XAU';

        // Ambil harga hari ini
        $today = Carbon::today()->format('Y-m-d');
        $resToday = Http::get($baseUrl . 'latest', [
            'api_key' => $apiKey,
            'base' => 'USD',
            'currencies' => 'XAU'
        ]);

        // Ambil harga kemarin
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $resYesterday = Http::get($baseUrl . '2025-04-01', [
            'api_key' => $apiKey,
            'base' => 'USD',
            'currencies' => 'XAU'
        ]);

        // Validasi response
        if (
            !$resToday->ok() || !$resYesterday->ok() ||
            !isset($resToday['rates']['XAU']) || !isset($resYesterday['rates']['XAU'])
        ) {
            return response()->json(['error' => 'Gagal mengambil data harga emas'], 500);
        }

        // Hitung harga per gram USD (1 ounce = 31.1035 gram)
        $todayPricePerGram = (1 / $resToday['rates']['XAU']) / 31.1035;
        $yesterdayPricePerGram = (1 / $resYesterday['rates']['XAU']) / 31.1035;

        $selisih = $todayPricePerGram - $yesterdayPricePerGram;
        // Persentase Laba
        $persentaseLaba = $yesterdayPricePerGram > 0
            ? ($selisih / $yesterdayPricePerGram) * 100
            : 0;

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'usd' => round($todayPricePerGram, 2),
            'yesterday' => round($yesterdayPricePerGram, 2),
            'laba_per_gram_usd' => round($selisih, 2),
            'persentase_laba' => round($persentaseLaba, 2),
        ]);
    }
}
