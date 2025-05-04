<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $apiKey = '375f964b949f527a37671a2e6f754967';
        $baseUrl = 'https://api.metalpriceapi.com/v1/';
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(5)->format('Y-m-d');
        $endDate = $today->format('Y-m-d');

        $resToday = Http::get($baseUrl . 'latest', [
            'api_key' => $apiKey,
            'base' => 'USD',
            'currencies' => 'XAU'
        ]);
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $resYesterday = Http::get($baseUrl . $yesterday, [
            'api_key' => $apiKey,
            'base' => 'USD',
            'currencies' => 'XAU'
        ]);
        $res7Days = Http::get($baseUrl . 'timeframe', [
            'api_key' => $apiKey,
            'base' => 'USD',
            'currencies' => 'XAU',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        if (
            !$resToday->ok() || !$resYesterday->ok() || !$res7Days->ok() ||
            !isset($resToday['rates']['XAU']) ||
            !isset($resYesterday['rates']['XAU']) ||
            !isset($res7Days['rates'])
        ) {
            return response()->json(['error' => 'Gagal mengambil data harga emas'], 500);
        }

        $todayPrice = (1 / $resToday['rates']['XAU']) / 31.1035;
        $yesterdayPrice = (1 / $resYesterday['rates']['XAU']) / 31.1035;

        $hargaPerGram7Hari = [];
        foreach ($res7Days['rates'] as $tanggal => $rate) {
            if (isset($rate['XAU']) && $rate['XAU'] > 0) {
                $hargaPerGram7Hari[$tanggal] = (1 / $rate['XAU']) / 31.1035;
            }
        }

        $hargaTertinggi = max($hargaPerGram7Hari);
        $hargaTerendah = min($hargaPerGram7Hari);
        $hargaAwal = reset($hargaPerGram7Hari);
        $hargaAkhir = end($hargaPerGram7Hari);
        $laba7Hari = $hargaAkhir - $hargaAwal;

        // --- Dataset Kategori
        $dataSet = [];
        $prev = null;
        foreach ($hargaPerGram7Hari as $tanggal => $harga) {
            if ($prev !== null) {
                $selisih = $harga - $prev;
                $kategori = 'Tetap';
                if ($selisih > 0.05) $kategori = 'Naik';
                elseif ($selisih < -0.05) $kategori = 'Turun';

                $dataSet[] = [
                    'selisih' => round($selisih, 4),
                    'harga' => round($harga, 2),
                    'kelas' => $kategori
                ];
            }
            $prev = $harga;
        }

        // --- Statistik Kelas
        $statistik = [];
        $kelas = ['Naik', 'Turun', 'Tetap'];
        foreach ($kelas as $k) {
            $dataKelas = array_filter($dataSet, fn($d) => $d['kelas'] === $k);
            $total = count($dataSet);
            $prior = count($dataKelas) / ($total ?: 1);

            $fitur = ['selisih', 'harga'];
            foreach ($fitur as $f) {
                $values = array_column($dataKelas, $f);
                $mean = array_sum($values) / (count($values) ?: 1);
                $std = count($values) > 1
                    ? sqrt(array_sum(array_map(fn($v) => pow($v - $mean, 2), $values)) / (count($values) - 1))
                    : 1e-6;

                $statistik[$k]['prior'] = $prior;
                $statistik[$k][$f] = ['mean' => $mean, 'std' => $std];
            }
        }

        // --- Fungsi distribusi normal (PDF)
        function normalPDF($x, $mean, $std)
        {
            if ($std == 0) $std = 1e-6;
            $exp = exp(-0.5 * pow(($x - $mean) / $std, 2));
            return (1 / ($std * sqrt(2 * pi()))) * $exp;
        }

        // --- Prediksi besok
        $fiturPrediksi = [
            'selisih' => round($todayPrice - $yesterdayPrice, 4),
            'harga' => round($todayPrice, 2)
        ];

        $hasilProb = [];
        foreach ($kelas as $k) {
            $logProb = log($statistik[$k]['prior'] ?: 1e-10);
            foreach ($fiturPrediksi as $f => $v) {
                $mean = $statistik[$k][$f]['mean'];
                $std = $statistik[$k][$f]['std'];
                $pdf = normalPDF($v, $mean, $std);
                $logProb += log($pdf ?: 1e-10);
            }
            $hasilProb[$k] = $logProb;
        }

        // Kembali ke probabilitas
        $hasilProb = array_map('exp', $hasilProb);
        $totalProb = array_sum($hasilProb);
        $hasilProb = array_map(fn($v) => $totalProb > 0 ? $v / $totalProb : 0, $hasilProb);

        arsort($hasilProb);
        $prediksi = array_key_first($hasilProb);

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'usd' => round($todayPrice, 2),
            'yesterday' => round($yesterdayPrice, 2),
            'harga_tertinggi' => round($hargaTertinggi, 2),
            'harga_terendah' => round($hargaTerendah, 2),
            'laba_7_hari' => round($laba7Hari, 2),
            'prediksi' => $prediksi,
            'probabilitas' => $hasilProb,
        ]);
    }
}
