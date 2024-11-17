<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'menu_id',
        'jumlah',
        'harga',
    ];

    protected static function booted()
{
    // Set harga sebelum menyimpan ke database
    static::saving(function ($pemesananMenu) {
        $menu = $pemesananMenu->menu;
        $pemesananMenu->harga = $menu ? $menu->harga * $pemesananMenu->jumlah : 0;
    });

    static::saved(function ($pemesananMenu) {
        // Akses pemesanan terkait dan update total_harga
        $pemesanan = $pemesananMenu->pemesanan;
        if ($pemesanan) {
            $pemesanan->update([
                'total_harga' => $pemesanan->pemesananMenu->sum(function ($menu) {
                    return $menu->harga * $menu->jumlah;
                }),
            ]);
        }
    });

    static::deleted(function ($pemesananMenu) {
        $pemesanan = $pemesananMenu->pemesanan;
        if ($pemesanan) {
            $pemesanan->update([
                'total_harga' => $pemesanan->pemesananMenu->sum(function ($menu) {
                    return $menu->harga * $menu->jumlah;
                }),
            ]);
        }
    });
}



    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
