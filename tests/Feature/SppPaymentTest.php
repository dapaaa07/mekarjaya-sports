<?php

namespace Tests\Feature;

use App\Models\SppPayment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SppPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_recording_spp_payment_updates_current_status_and_prevents_duplicates(): void
    {
        $admin = $this->createAdmin();
        $player = $this->createPlayer(['spp_status' => 'Belum Bayar']);

        $now = Carbon::now();
        $month = (int) $now->month;
        $year = (int) $now->year;

        $this->assertEquals('Belum Bayar', $player->current_spp_status);

        $response = $this->actingAs($admin)->post("/admin/players/{$player->id}/spp-payments", [
            'periode_bulan' => $month,
            'periode_tahun' => $year,
            'jumlah' => 150000,
            'tanggal_bayar' => $now->toDateString(),
            'metode' => 'transfer',
            'keterangan' => 'Transfer BCA Wali Murid',
        ]);

        $response->assertRedirect(route('admin.players.show', $player->id) . '#spp-section');
        $response->assertSessionHas('success');

        $payment = SppPayment::where('player_id', $player->id)
            ->where('periode_bulan', $month)
            ->where('periode_tahun', $year)
            ->first();

        $this->assertNotNull($payment);
        $this->assertEquals(150000, $payment->jumlah);
        $this->assertEquals('Lunas', $player->fresh()->current_spp_status);
        $this->assertEquals('Lunas', $player->fresh()->spp_status);

        // Duplicate same period should fail validation
        $duplicate = $this->actingAs($admin)
            ->from("/admin/players/{$player->id}")
            ->post("/admin/players/{$player->id}/spp-payments", [
                'periode_bulan' => $month,
                'periode_tahun' => $year,
                'jumlah' => 150000,
                'tanggal_bayar' => $now->toDateString(),
                'metode' => 'tunai',
            ]);

        $duplicate->assertRedirect("/admin/players/{$player->id}");
        $duplicate->assertSessionHasErrors('periode_bulan');
        $this->assertEquals(1, SppPayment::where('player_id', $player->id)->count());

        // Deleting payment reverts status to Belum Bayar
        $this->actingAs($admin)->delete("/admin/players/{$player->id}/spp-payments/{$payment->id}")
            ->assertRedirect(route('admin.players.show', $player->id) . '#spp-section');

        $this->assertEquals('Belum Bayar', $player->fresh()->current_spp_status);
    }
}
