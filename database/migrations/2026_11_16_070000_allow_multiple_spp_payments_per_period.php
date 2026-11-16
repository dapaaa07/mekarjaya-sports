<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spp_payments', function (Blueprint $table) {
            $table->index(['player_id', 'periode_tahun', 'periode_bulan'], 'spp_player_period_index');
        });

        Schema::table('spp_payments', function (Blueprint $table) {
            $table->dropUnique('spp_player_period_unique');
        });
    }

    public function down(): void
    {
        Schema::table('spp_payments', function (Blueprint $table) {
            $table->unique(['player_id', 'periode_tahun', 'periode_bulan'], 'spp_player_period_unique');
        });

        Schema::table('spp_payments', function (Blueprint $table) {
            $table->dropIndex('spp_player_period_index');
        });
    }
};
