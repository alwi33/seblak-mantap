<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama_paket' => 'Seblak Original Kuah',
                'deskripsi' => 'Kerupuk seblak kuah gurih pedas dengan bumbu rempah khas, kencur, dan bawang goreng.',
                'harga' => 12000,
                'kategori' => 'kuah',
            ],
            [
                'nama_paket' => 'Seblak Ceker',
                'deskripsi' => 'Seblak kuah dengan ceker ayam empuk yang meresap bumbu pedas gurih.',
                'harga' => 16000,
                'kategori' => 'kuah',
            ],
            [
                'nama_paket' => 'Seblak Mie',
                'deskripsi' => 'Seblak kuah dipadukan mie kuning kenyal, cocok buat yang suka porsi mengenyangkan.',
                'harga' => 15000,
                'kategori' => 'mie',
            ],
            [
                'nama_paket' => 'Seblak Seafood',
                'deskripsi' => 'Seblak kuah dengan campuran seafood pilihan: udang, cumi, dan bakso ikan.',
                'harga' => 21000,
                'kategori' => 'seafood',
            ],
            [
                'nama_paket' => 'Seblak Makaroni',
                'deskripsi' => 'Seblak kuah dengan makaroni lembut yang menyerap kuah pedas gurih.',
                'harga' => 13000,
                'kategori' => 'kuah',
            ],
            [
                'nama_paket' => 'Seblak Goreng',
                'deskripsi' => 'Seblak digoreng kering berbumbu pedas manis, tanpa kuah, renyah dan nagih.',
                'harga' => 14000,
                'kategori' => 'goreng',
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::updateOrCreate(
                ['nama_paket' => $paket['nama_paket']],
                $paket + ['status' => 'aktif']
            );
        }
    }
}
