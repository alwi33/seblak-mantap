<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kondimen extends Model
{
    use HasFactory;

    protected $table = 'kondimens';

    protected $fillable = [
        'nama_kondimen',
        'harga',
        'gambar',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function detailPemesananKondimens()
    {
        return $this->hasMany(DetailPemesananKondimen::class);
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return asset('images/no-image.svg');
    }
}
