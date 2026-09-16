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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique();
            $table->string('full_name');
            $table->string('birth_place')->default('Subang');
            $table->date('birth_date');
            $table->integer('birth_year');
            $table->string('position_preference')->default('Gelandang');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('school_name')->nullable();
            $table->text('address')->nullable();
            $table->text('health_notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
