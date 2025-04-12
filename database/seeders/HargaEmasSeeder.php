<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HargaEmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataHargaEmas = [
            // Data harga emas per hari, kamu bisa mengganti nilai harga dengan data yang sesuai
            ['tanggal' => '2024-04-01', 'harga_emas' => '1050000', 'harga_usd' => '68.50', 'kategori' => 'naik'],
            ['tanggal' => '2024-04-02', 'harga_emas' => '1065000', 'harga_usd' => '69.10', 'kategori' => 'naik'],
            ['tanggal' => '2024-04-03', 'harga_emas' => '1045000', 'harga_usd' => '68.20', 'kategori' => 'turun'],
            ['tanggal' => '2024-04-04', 'harga_emas' => '1045000', 'harga_usd' => '68.20', 'kategori' => 'stabil'],
            ['tanggal' => '2024-04-05', 'harga_emas' => '1052000', 'harga_usd' => '68.50', 'kategori' => 'naik'],
            ['tanggal' => '2024-04-06', 'harga_emas' => '1055000', 'harga_usd' => '68.70', 'kategori' => 'naik'],
            // Tambahkan data sesuai kebutuhan atau berdasarkan data API
        ];

        // Masukkan data ke dalam tabel harga_emas
        foreach ($dataHargaEmas as $data) {
            DB::table('harga_emas')->insert([
                'tanggal' => Carbon::parse($data['tanggal'])->format('Y-m-d'),
                'harga_emas' => $data['harga_emas'],
                'harga_usd' => $data['harga_usd'],
                'kategori' => $data['kategori'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
