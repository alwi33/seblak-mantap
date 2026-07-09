<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'nama_toko',
        'logo',
        'alamat_toko',
        'deskripsi_toko',
        'no_wa',
        'nama_rekening',
        'qris_image',
    ];

    /**
     * Ambil baris pengaturan pertama, atau buat baris default kalau belum ada
     * supaya view tidak error saat aplikasi baru pertama kali dijalankan.
     */
    public static function aktif(): self
    {
        return static::first() ?? static::create([
            'nama_toko' => 'Seblak Mantap',
        ]);
    }

    /**
     * URL gambar QRIS. Prioritas:
     * 1) File yang diunggah admin lewat panel Pengaturan (tersimpan di storage).
     * 2) File statis public/assets/qris.png - kalau kamu taruh manual di situ,
     *    otomatis langsung tampil tanpa perlu upload lewat admin.
     */
    public function getQrisUrlAttribute(): ?string
    {
        if ($this->qris_image) {
            return asset('storage/' . $this->qris_image);
        }

        if (file_exists(public_path('assets/qris.png'))) {
            return asset('assets/qris.png');
        }

        return null;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
