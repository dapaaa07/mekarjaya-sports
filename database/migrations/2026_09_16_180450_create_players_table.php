<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // e.g. SSB-MJ-2024001
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->string('birth_place')->default('Subang');
            $table->date('birth_date');
            $table->integer('birth_year')->index(); // Indexed for fast filtering by year
            $table->string('position')->default('Gelandang'); // Kiper, Bek Tengah, Bek Sayap, Gelandang, Striker, Penyerang Sayap
            $table->integer('height_cm')->nullable();
            $table->integer('weight_kg')->nullable();
            $table->string('school_name')->nullable();
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('photo')->nullable();
            $table->enum('status', ['aktif', 'alumni', 'non-aktif'])->default('aktif');
            $table->enum('spp_status', ['Lunas', 'Belum Bayar'])->default('Lunas');
            $table->integer('joined_year')->default(2024);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
