<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class HargaEmasController extends Controller
{
    public function cekHarga()
    {
        $apiKey = '86f94bb030e68c9f2755bdf8cdecf8a7'; // ganti dengan API key kamu
        $endpoint = 'https://api.metalpriceapi.com/v1/latest';
        $now = Carbon::now()->format('Y-m-d');

        $response = Http::get($endpoint, [
            'api_key'    => $apiKey,
            'base'       => 'USD',
            'currencies' => 'XAU', // Emas dalam troy ounce
        ]);

        if (!$response->ok() || !isset($response['rates']['XAU'])) {
            return response()->json(['error' => 'Gagal mengambil data harga emas'], 500);
        }

        $data = $response->json();
        $pricePerOunceUSD = 1 / $data['rates']['XAU']; // karena yang dikembalikan adalah nilai USD terhadap XAU
        $hargaPerGramUSD = $pricePerOunceUSD / 31.1035;

        return response()->json([
            'date' => $now,
            'price_usd_per_ounce' => round($pricePerOunceUSD, 2) . ' USD',
            'price_usd_per_gram' => round($hargaPerGramUSD, 2) . ' USD',
        ]);
    }



    public function cekHargaKemarin()
    {
        $apiKey = '86f94bb030e68c9f2755bdf8cdecf8a7'; // Ganti dengan API key Anda
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $response = Http::get("https://api.metalpriceapi.com/v1/{$yesterday}", [
            'api_key'    => $apiKey,
            'base'       => 'USD',
            'currencies' => 'XAU',
        ]);

        if (!$response->ok() || !isset($response['rates']['XAU'])) {
            return response()->json(['error' => 'Gagal mengambil data harga emas kemarin'], 500);
        }

        $data = $response->json();
        $pricePerOunceUSD = 1 / $data['rates']['XAU'];
        $hargaPerGramUSD = $pricePerOunceUSD / 31.1035;

        return response()->json([
            'date' => $yesterday,
            'price_usd_per_ounce' => round($pricePerOunceUSD, 2) . ' USD',
            'price_usd_per_gram' => round($hargaPerGramUSD, 2) . ' USD',
        ]);
    }

    public function cekLabaEmas()
    {
        $apiKey = '86f94bb030e68c9f2755bdf8cdecf8a7';
        $baseUrl = 'https://api.metalpriceapi.com/v1/';

        // Ambil harga hari ini
        $today = Carbon::today()->format('Y-m-d');
        $resToday = Http::get($baseUrl . 'latest', [
            'api_key' => $apiKey,
            'base' => 'USD',
            'currencies' => 'XAU'
        ]);

        // Ambil harga kemarin
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $resYesterday = Http::get($baseUrl . $yesterday, [
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

        return response()->json([
            'tanggal_hari_ini' => $today,
            'harga_hari_ini_per_gram_usd' => round($todayPricePerGram, 2),
            'tanggal_kemarin' => $yesterday,
            'harga_kemarin_per_gram_usd' => round($yesterdayPricePerGram, 2),
            'laba_per_gram_usd' => round($selisih, 2),
            'persentase_laba' => round($persentaseLaba, 2) . '%',
            'keterangan' => $selisih >= 0 ? 'Naik' : 'Turun'
        ]);
    }
}
