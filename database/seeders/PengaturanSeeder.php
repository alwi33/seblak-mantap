<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        Pengaturan::updateOrCreate(
            ['id' => 1],
            [
                'nama_toko' => 'Seblak Mantap',
                'alamat_toko' => 'Jl. Contoh Raya No. 123, Kota Anda',
                'no_wa' => '628123456789',
                'nama_rekening' => 'Diisi setelah upload QRIS di menu Pengaturan Toko',
                'qris_image' => null,
            ]
        );
    }
}
