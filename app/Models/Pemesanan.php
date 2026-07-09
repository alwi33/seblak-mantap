<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';

    protected $fillable = [
        'kode_pemesanan',
        'nama_pelanggan',
        'no_hp',
        'tipe_pesanan',
        'meja',
        'alamat_pengiriman',
        'catatan',
        'total_harga',
        'status_pesanan',
        'status_pembayaran',
        'metode_pembayaran',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Pemesanan $pemesanan) {
            if (empty($pemesanan->kode_pemesanan)) {
                $pemesanan->kode_pemesanan = static::buatKodeUnik();
            }
        });
    }

    public static function buatKodeUnik(): string
    {
        do {
            $kode = 'SBK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (static::where('kode_pemesanan', $kode)->exists());

        return $kode;
    }

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function labelTipePesanan(): string
    {
        return match ($this->tipe_pesanan) {
            'makan_di_tempat' => 'Makan di Tempat',
            'bawa_pulang' => 'Bawa Pulang',
            'delivery' => 'Delivery',
            default => $this->tipe_pesanan,
        };
    }

    public function labelStatusPesanan(): string
    {
        return match ($this->status_pesanan) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status_pesanan,
        };
    }

    public function labelStatusPembayaran(): string
    {
        return match ($this->status_pembayaran) {
            'belum_bayar' => 'Belum Bayar',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'lunas' => 'Lunas',
            default => $this->status_pembayaran,
        };
    }
}
