<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pemesanan;

class KategoriPenjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Penjualan Makanan dan Minuman';

    protected function getData(): array
    {
        // Mengambil jumlah pemesanan untuk kategori "Makanan" dan "Minuman"
        $totalMakanan = Pemesanan::join('pemesanan_menus', 'pemesanans.id', '=', 'pemesanan_menus.pemesanan_id')
            ->join('menus', 'pemesanan_menus.menu_id', '=', 'menus.id')
            ->where('menus.kategori', 'Makanan')
            ->count();

        $totalMinuman = Pemesanan::join('pemesanan_menus', 'pemesanans.id', '=', 'pemesanan_menus.pemesanan_id')
            ->join('menus', 'pemesanan_menus.menu_id', '=', 'menus.id')
            ->where('menus.kategori', 'Minuman')
            ->count();

        return [
            'labels' => ['Makanan', 'Minuman'],
            'datasets' => [
                [
                    'label' => 'Jumlah Penjualan per Kategori',
                    'data' => [$totalMakanan, $totalMinuman],
                    'backgroundColor' => ['#FF6384', '#36A2EB'], // Warna untuk tiap kategori
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
