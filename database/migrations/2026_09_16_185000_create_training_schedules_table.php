<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('schedule_date');
            $table->time('start_time')->default('15:30:00');
            $table->time('end_time')->default('17:30:00');
            $table->string('location')->default('Lapangan Veteran Dangdeur Subang');
            $table->string('target_ku')->default('Semua KU'); // e.g. U-10, U-12, U-14, U-16, U-18, Semua KU
            $table->string('coach_in_charge')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_schedules');
    }
};
