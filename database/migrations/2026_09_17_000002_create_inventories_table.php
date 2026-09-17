<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category'); // Bola, Rompi, Cone, P3K, Ring, Gawang, Lainnya
            $table->integer('quantity')->default(0);
            $table->string('condition')->default('Baik'); // Baik, Rusak Ringan, Rusak Berat
            $table->string('location')->default('Gudang Sekretariat');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
