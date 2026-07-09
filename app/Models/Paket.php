<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',
        'gambar',
        'kategori',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    /**
     * URL gambar paket. Jika belum ada gambar, tampilkan gambar default.
     * Gambar diunggah lewat panel admin akan tersimpan di storage/app/public/pakets
     * dan bisa diakses lewat symlink public/storage (php artisan storage:link).
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return asset('images/no-image.svg');
    }
}
