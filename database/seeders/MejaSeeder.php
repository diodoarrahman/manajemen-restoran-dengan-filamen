<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    public function run()
    {
        // Meja dengan nomor A3-A7
        $mejasA = [
            ['nomor_meja' => 'A3', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'A4', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'A5', 'kapasitas_meja' => 6, 'status' => 'tersedia'],
            ['nomor_meja' => 'A6', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'A7', 'kapasitas_meja' => 3, 'status' => 'tersedia'],
        ];

        // Meja dengan nomor B1-B10
        $mejasB = [
            ['nomor_meja' => 'B1', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'B2', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'B3', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'B4', 'kapasitas_meja' => 6, 'status' => 'tersedia'],
            ['nomor_meja' => 'B5', 'kapasitas_meja' => 3, 'status' => 'tersedia'],
            ['nomor_meja' => 'B6', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'B7', 'kapasitas_meja' => 5, 'status' => 'tersedia'],
            ['nomor_meja' => 'B8', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'B9', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'B10', 'kapasitas_meja' => 6, 'status' => 'tersedia'],
        ];

        // Meja dengan nomor C1-C10
        $mejasC = [
            ['nomor_meja' => 'C1', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'C2', 'kapasitas_meja' => 3, 'status' => 'tersedia'],
            ['nomor_meja' => 'C3', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'C4', 'kapasitas_meja' => 6, 'status' => 'tersedia'],
            ['nomor_meja' => 'C5', 'kapasitas_meja' => 5, 'status' => 'tersedia'],
            ['nomor_meja' => 'C6', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'C7', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'C8', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'C9', 'kapasitas_meja' => 6, 'status' => 'tersedia'],
            ['nomor_meja' => 'C10', 'kapasitas_meja' => 3, 'status' => 'tersedia'],
        ];

        // Menggabungkan semua meja
        $mejas = array_merge($mejasA, $mejasB, $mejasC);

        // Memasukkan data ke database
        foreach ($mejas as $meja) {
            Meja::create($meja);
        }
    }
}
