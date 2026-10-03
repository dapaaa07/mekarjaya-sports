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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('kk_document')->nullable()->after('jersey_size');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->string('kk_document')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('kk_document');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('kk_document');
        });
    }
};
