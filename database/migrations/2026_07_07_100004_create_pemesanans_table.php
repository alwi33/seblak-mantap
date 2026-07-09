<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemesanan')->unique();
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->enum('tipe_pesanan', ['makan_di_tempat', 'bawa_pulang', 'delivery'])->default('bawa_pulang');
            $table->string('meja')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->text('catatan')->nullable();
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->enum('status_pesanan', ['menunggu_pembayaran', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_konfirmasi', 'lunas'])->default('belum_bayar');
            $table->enum('metode_pembayaran', ['qris', 'cash'])->default('qris');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
