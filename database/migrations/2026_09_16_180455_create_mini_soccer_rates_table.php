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
        Schema::create('mini_soccer_rates', function (Blueprint $table) {
            $table->id();
            $table->string('day_type');
            $table->string('time_slot');
            $table->decimal('price_per_hour', 10, 2);
            $table->text('facilities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mini_soccer_rates');
    }
};
