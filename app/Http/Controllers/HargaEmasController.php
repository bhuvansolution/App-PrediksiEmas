<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;

class HargaEmasController extends Controller
{
    public function cekHarga()
    {
        $apiKey = 'goldapi-1oi6csm9ar8czv-io'; // ganti dengan milikmu

        $response = Http::withHeaders([
            'x-access-token' => $apiKey,
            'Content-Type' => 'application/json',
        ])->get('https://www.goldapi.io/api/XAU/USD');

        if (!$response->ok()) {
            return response()->json(['error' => 'Gagal mengambil data harga emas'], 500);
        }

        $data = $response->json();
        $usdToIdr = 15500; // nilai tukar bisa kamu ganti dengan dinamis juga
        $hargaPerGramUSD = $data['price'] / 31.1035;
        $hargaPerGramIDR = $hargaPerGramUSD * $usdToIdr;

        return response()->json([
            'price_usd_per_ounce' => $data['price'],
            'price_usd_per_gram' => $hargaPerGramUSD,
            'price_idr_per_gram' => $hargaPerGramIDR,
            'harga_rupiah_per_gram' => 'Rp' . number_format($hargaPerGramIDR, 0, ',', '.'),
        ]);
    }


    public function ambilHargaAntam()
    {
        $apiKey = 'goldapi-1oi6csm9ar8czv-io'; // ganti dengan milikmu
        $usdToIdr = 16000; // bisa ambil juga dari API kurs

        // Ambil data dari GoldAPI
        $response = Http::withHeaders([
            'x-access-token' => $apiKey
        ])->get('https://www.goldapi.io/api/XAU/USD');

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data harga emas'], 500);
        }

        $data = $response->json();
        $pricePerOunce = $data['price']; // misalnya 2300 USD

        // Konversi ke Rupiah per gram
        $pricePerGram = ($pricePerOunce * $usdToIdr) / 31.1034768;

        // Markup estimasi (Antam sering markup sekitar 35%)
        $estimasiAntam = $pricePerGram * 1.35;

        return response()->json([
            'harga_per_gram_global_idr' => round($pricePerGram),
            'estimasi_harga_antam' => round($estimasiAntam),
            'format_rupiah' => 'Rp' . number_format(round($estimasiAntam), 0, ',', '.')
        ]);
    }
}
