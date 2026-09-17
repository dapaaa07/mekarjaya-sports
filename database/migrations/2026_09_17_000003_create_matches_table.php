<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('match_title');
            $table->date('match_date');
            $table->string('target_ku')->default('Semua KU');
            $table->string('match_type')->default('Internal Game'); // Internal Game, Uji Tanding, Turnamen
            $table->string('opponent_name')->nullable();
            $table->string('score_result')->nullable(); // e.g., "3 - 1"
            $table->string('man_of_the_match')->nullable();
            $table->text('match_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
