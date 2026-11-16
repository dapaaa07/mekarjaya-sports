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

        // Duplicate same period when already fully paid should fail validation
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

    public function test_partial_payment_does_not_change_status_to_lunas_until_fee_is_fully_met(): void
    {
        $admin = $this->createAdmin();

        \App\Models\AgeCategory::create([
            'category_name' => 'Kelompok Umur U-14',
            'code' => 'U-14',
            'min_birth_year' => 2012,
            'max_birth_year' => 2013,
            'monthly_fee' => 175000,
            'schedule_days' => 'Selasa, Kamis',
            'schedule_time' => '16:00 - 17:30 WIB',
        ]);

        $player = $this->createPlayer([
            'birth_year' => 2012,
            'spp_status' => 'Belum Bayar',
        ]);

        $this->assertEquals(175000, $player->default_monthly_fee);

        $now = Carbon::now();
        $month = (int) $now->month;
        $year = (int) $now->year;

        // 1. Partial payment: Rp 100.000 (< Rp 175.000)
        $resp1 = $this->actingAs($admin)->post("/admin/players/{$player->id}/spp-payments", [
            'periode_bulan' => $month,
            'periode_tahun' => $year,
            'jumlah' => 100000,
            'tanggal_bayar' => $now->toDateString(),
            'metode' => 'tunai',
            'keterangan' => 'Cicilan 1 SPP',
        ]);

        $resp1->assertRedirect(route('admin.players.show', $player->id) . '#spp-section');
        $resp1->assertSessionHas('success');

        $fresh = $player->fresh();
        $this->assertEquals(100000, $fresh->getTotalSppPaidForMonth($month, $year));
        $this->assertEquals(75000, $fresh->getSppShortageForMonth($month, $year));
        $this->assertFalse($fresh->hasPaidSppForMonth($month, $year));
        $this->assertEquals('Belum Bayar', $fresh->current_spp_status);
        $this->assertEquals('Belum Bayar', $fresh->spp_status);

        // 2. Second installment: Rp 75.000 (total reaches Rp 175.000)
        $resp2 = $this->actingAs($admin)->post("/admin/players/{$player->id}/spp-payments", [
            'periode_bulan' => $month,
            'periode_tahun' => $year,
            'jumlah' => 75000,
            'tanggal_bayar' => $now->toDateString(),
            'metode' => 'transfer',
            'keterangan' => 'Pelunasan SPP',
        ]);

        $resp2->assertRedirect(route('admin.players.show', $player->id) . '#spp-section');
        $resp2->assertSessionHas('success');

        $fresh2 = $player->fresh();
        $this->assertEquals(175000, $fresh2->getTotalSppPaidForMonth($month, $year));
        $this->assertEquals(0, $fresh2->getSppShortageForMonth($month, $year));
        $this->assertTrue($fresh2->hasPaidSppForMonth($month, $year));
        $this->assertEquals('Lunas', $fresh2->current_spp_status);
        $this->assertEquals('Lunas', $fresh2->spp_status);
        $this->assertEquals(2, SppPayment::where('player_id', $player->id)->count());

        // 3. Attempting another payment for already lunas period should fail
        $resp3 = $this->actingAs($admin)
            ->from("/admin/players/{$player->id}")
            ->post("/admin/players/{$player->id}/spp-payments", [
                'periode_bulan' => $month,
                'periode_tahun' => $year,
                'jumlah' => 50000,
                'tanggal_bayar' => $now->toDateString(),
                'metode' => 'tunai',
            ]);

        $resp3->assertRedirect("/admin/players/{$player->id}");
        $resp3->assertSessionHasErrors('periode_bulan');
    }

    public function test_dashboard_and_index_filters_correctly_identify_lunas_and_belum_bayar(): void
    {
        $admin = $this->createAdmin();

        \App\Models\AgeCategory::create([
            'category_name' => 'Kelompok Umur U-12',
            'code' => 'U-12',
            'min_birth_year' => 2014,
            'max_birth_year' => 2015,
            'monthly_fee' => 150000,
            'schedule_days' => 'Selasa',
            'schedule_time' => '15:30 WIB',
        ]);

        $pLunas = $this->createPlayer(['birth_year' => 2014, 'spp_status' => 'Belum Bayar']);
        $pPartial = $this->createPlayer(['birth_year' => 2014, 'spp_status' => 'Belum Bayar']);
        $pUnpaid = $this->createPlayer(['birth_year' => 2014, 'spp_status' => 'Belum Bayar']);

        $now = Carbon::now();
        $month = (int) $now->month;
        $year = (int) $now->year;

        // pLunas pays full 150.000
        SppPayment::create([
            'player_id' => $pLunas->id,
            'periode_bulan' => $month,
            'periode_tahun' => $year,
            'jumlah' => 150000,
            'tanggal_bayar' => $now->toDateString(),
            'metode' => 'tunai',
        ]);
        $pLunas->syncCurrentSppStatus();

        // pPartial pays only 50.000 (< 150.000)
        SppPayment::create([
            'player_id' => $pPartial->id,
            'periode_bulan' => $month,
            'periode_tahun' => $year,
            'jumlah' => 50000,
            'tanggal_bayar' => $now->toDateString(),
            'metode' => 'tunai',
        ]);
        $pPartial->syncCurrentSppStatus();

        // Check dashboard counts
        $dash = $this->actingAs($admin)->get(route('admin.dashboard'));
        $dash->assertOk();
        $dash->assertViewHas('sppLunas', 1);
        $dash->assertViewHas('sppMenunggak', 2);

        // Check filter index spp_status=Lunas
        $indexLunas = $this->actingAs($admin)->get('/admin/players?spp_status=Lunas');
        $indexLunas->assertOk();
        $indexLunas->assertSee($pLunas->full_name);
        $indexLunas->assertDontSee($pPartial->full_name);
        $indexLunas->assertDontSee($pUnpaid->full_name);

        // Check filter index spp_status=Belum Bayar
        $indexUnpaid = $this->actingAs($admin)->get('/admin/players?spp_status=Belum+Bayar');
        $indexUnpaid->assertOk();
        $indexUnpaid->assertDontSee($pLunas->full_name);
        $indexUnpaid->assertSee($pPartial->full_name);
        $indexUnpaid->assertSee($pUnpaid->full_name);
    }

    public function test_player_with_multi_month_spp_arrears_displays_accurate_information_on_portal_and_admin(): void
    {
        $admin = $this->createAdmin();

        $registeredDate = Carbon::now()->subMonths(3)->startOfMonth();
        $player = $this->createPlayer([
            'birth_year' => 2014,
            'created_at' => $registeredDate,
            'spp_status' => 'Belum Bayar',
        ]);

        $m3Ago = Carbon::now()->subMonths(3);
        $m2Ago = Carbon::now()->subMonths(2);
        $m1Ago = Carbon::now()->subMonths(1);
        $mNow = Carbon::now();

        // Month -3: Paid in full (150.000)
        SppPayment::create([
            'player_id' => $player->id,
            'periode_bulan' => (int) $m3Ago->month,
            'periode_tahun' => (int) $m3Ago->year,
            'jumlah' => 150000,
            'tanggal_bayar' => $m3Ago->toDateString(),
            'metode' => 'transfer',
        ]);

        // Month -2: Paid partial 50.000 (shortage 100.000)
        SppPayment::create([
            'player_id' => $player->id,
            'periode_bulan' => (int) $m2Ago->month,
            'periode_tahun' => (int) $m2Ago->year,
            'jumlah' => 50000,
            'tanggal_bayar' => $m2Ago->toDateString(),
            'metode' => 'tunai',
        ]);

        // Month -1: Unpaid (shortage 150.000)
        // Current Month: Unpaid (shortage 150.000)

        $unpaid = $player->fresh()->unpaid_spp_periods;
        $this->assertCount(3, $unpaid);
        $this->assertEquals(3, $player->fresh()->spp_arrears_count);
        $this->assertEquals(400000, $player->fresh()->total_spp_arrears);

        // Check Parent Portal response
        $portal = $this->get(route('parent.portal', ['nis' => $player->nis]));
        $portal->assertOk();
        $portal->assertSee('Menunggak 3 Bulan');
        $portal->assertSee('Rp 400.000');
        $portal->assertSee('parent-spp-section');
        $portal->assertSee('Rekening Pembayaran Resmi SSB');

        // Check Admin Players Index displays multi-month badge
        $adminIndex = $this->actingAs($admin)->get(route('admin.players.index'));
        $adminIndex->assertOk();
        $adminIndex->assertSee('Menunggak 3 Bln');

        // Check Admin Player Show displays multi-month alert
        $adminShow = $this->actingAs($admin)->get(route('admin.players.show', $player->id));
        $adminShow->assertOk();
        $adminShow->assertSee('Pemain Menunggak 3 Bulan');
        $adminShow->assertSee('Rp 400.000');
    }
}
