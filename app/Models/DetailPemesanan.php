<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanans';

    protected $fillable = [
        'pemesanan_id',
        'paket_id',
        'jumlah',
        'tingkat_pedas',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function kondimenTerpilih()
    {
        return $this->hasMany(DetailPemesananKondimen::class);
    }
}
