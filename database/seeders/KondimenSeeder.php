<?php

namespace Database\Seeders;

use App\Models\Kondimen;
use Illuminate\Database\Seeder;

class KondimenSeeder extends Seeder
{
    public function run(): void
    {
        $kondimens = [
            ['nama_kondimen' => 'Ceker Ayam', 'harga' => 5000],
            ['nama_kondimen' => 'Bakso', 'harga' => 3000],
            ['nama_kondimen' => 'Sosis', 'harga' => 3000],
            ['nama_kondimen' => 'Makaroni', 'harga' => 2000],
            ['nama_kondimen' => 'Kwetiau', 'harga' => 3000],
            ['nama_kondimen' => 'Telur', 'harga' => 3000],
            ['nama_kondimen' => 'Kerupuk', 'harga' => 1000],
            ['nama_kondimen' => 'Cimol', 'harga' => 3000],
            ['nama_kondimen' => 'Mie', 'harga' => 3000],
            ['nama_kondimen' => 'Sayap Ayam', 'harga' => 6000],
        ];

        foreach ($kondimens as $kondimen) {
            Kondimen::updateOrCreate(
                ['nama_kondimen' => $kondimen['nama_kondimen']],
                $kondimen + ['status' => 'aktif']
            );
        }
    }
}
