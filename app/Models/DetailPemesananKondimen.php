<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesananKondimen extends Model
{
    protected $table = 'detail_pemesanan_kondimen';

    protected $fillable = [
        'detail_pemesanan_id',
        'kondimen_id',
        'harga_satuan',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
    ];

    public function detailPemesanan()
    {
        return $this->belongsTo(DetailPemesanan::class);
    }

    public function kondimen()
    {
        return $this->belongsTo(Kondimen::class);
    }
}
