<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->unsignedTinyInteger('periode_bulan');
            $table->unsignedSmallInteger('periode_tahun');
            $table->unsignedInteger('jumlah');
            $table->date('tanggal_bayar');
            $table->string('metode', 20)->default('tunai');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->unique(['player_id', 'periode_tahun', 'periode_bulan'], 'spp_player_period_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spp_payments');
    }
};
