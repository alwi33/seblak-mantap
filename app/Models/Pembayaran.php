<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'pemesanan_id',
        'bukti_transfer',
        'tanggal_bayar',
        'dikonfirmasi_oleh',
        'tanggal_konfirmasi',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'tanggal_konfirmasi' => 'datetime',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'dikonfirmasi_oleh');
    }

    public function getBuktiUrlAttribute(): ?string
    {
        return $this->bukti_transfer ? asset('storage/' . $this->bukti_transfer) : null;
    }
}
