<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('jersey_size', 10)->default('M')->after('position');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->string('jersey_size', 10)->default('M')->after('position_preference');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('jersey_size');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('jersey_size');
        });
    }
};
