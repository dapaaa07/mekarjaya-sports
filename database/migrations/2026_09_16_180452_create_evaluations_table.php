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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->date('evaluation_date');
            $table->integer('passing_score')->default(75);
            $table->integer('dribbling_score')->default(75);
            $table->integer('shooting_score')->default(75);
            $table->integer('physical_score')->default(75);
            $table->integer('discipline_score')->default(80);
            $table->integer('tactical_score')->default(70);
            $table->text('coach_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
