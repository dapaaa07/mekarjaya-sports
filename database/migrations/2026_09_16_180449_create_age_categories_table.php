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
        Schema::create('age_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name'); // e.g. "Kelompok Umur U-10 (2016-2017)"
            $table->string('code')->unique(); // e.g. "U-10", "U-12", "U-14", "U-16"
            $table->integer('min_birth_year');
            $table->integer('max_birth_year');
            $table->decimal('monthly_fee', 10, 2)->default(150000.00);
            $table->string('schedule_days')->default('Selasa & Kamis');
            $table->string('schedule_time')->default('15:30 - 17:30 WIB');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('age_categories');
    }
};
