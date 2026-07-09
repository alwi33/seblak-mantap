<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanan_kondimen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_pemesanan_id')->constrained('detail_pemesanans')->cascadeOnDelete();
            $table->foreignId('kondimen_id')->constrained('kondimens')->cascadeOnDelete();
            $table->decimal('harga_satuan', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan_kondimen');
    }
};
