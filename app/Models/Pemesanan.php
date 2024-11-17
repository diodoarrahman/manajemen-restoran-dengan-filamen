<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'meja_id',
        'total_harga',
        'status',
    ];

    // Konstanta untuk status
    const STATUS_BELUM_SELESAI = 'belum selesai';
    const STATUS_SELESAI = 'selesai';

    protected static function booted()
    {
        static::created(function ($pemesanan) {
            // Mengubah status meja menjadi "tidak tersedia"
            $pemesanan->meja()->update(['status' => 'tidak_tersedia']);
        });
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function pemesananMenu()
    {
        return $this->hasMany(PemesananMenu::class);
    }

    public function getTotalHargaAttribute()
    {
        return $this->pemesananMenu->sum(function ($pemesananMenu) {
            return $pemesananMenu->harga * $pemesananMenu->jumlah;
        });
    }

}