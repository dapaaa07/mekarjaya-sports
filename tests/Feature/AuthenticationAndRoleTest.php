<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationAndRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_access_admin_only_routes(): void
    {
        $admin = $this->createAdmin(['email' => 'admin@mekarjaya.com']);

        $response = $this->post('/login', [
            'email' => 'admin@mekarjaya.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);

        $this->actingAs($admin)->get('/admin')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/players')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/registrations')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/inventories')->assertStatus(200);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->createAdmin(['email' => 'admin@mekarjaya.com']);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@mekarjaya.com',
            'password' => 'salah-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_coach_can_login_and_only_access_coaching_routes(): void
    {
        $coach = $this->createCoach(['email' => 'coach@mekarjaya.com']);
        $player = $this->createPlayer();

        $response = $this->post('/login', [
            'email' => 'coach@mekarjaya.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($coach);

        $dashboard = $this->actingAs($coach)->get('/admin');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('PORTAL PELATIH');
        $dashboard->assertSee('Data Pemain Per Tahun');
        $dashboard->assertDontSee('Inventaris Peralatan');
        $dashboard->assertDontSee('Presensi Latihan');

        $schedule = \App\Models\TrainingSchedule::create([
            'title' => 'Latihan Taktikal',
            'schedule_date' => '2026-11-16',
            'start_time' => '15:30:00',
            'end_time' => '17:30:00',
            'location' => 'Lapangan Dangdeur',
            'target_ku' => 'Semua KU',
            'coach_in_charge' => 'Coach Hendra',
            'status' => 'scheduled',
        ]);

        $this->actingAs($coach)->get('/admin/players')->assertStatus(200);
        $this->actingAs($coach)->get("/admin/players/{$player->id}")->assertStatus(200);
        $this->actingAs($coach)->get('/admin/players/print-roster')->assertStatus(200);
        $this->actingAs($coach)->get("/admin/players/{$player->id}/print-rapor")->assertStatus(200);
        $this->actingAs($coach)->get('/admin/schedules')->assertStatus(200);
        $this->actingAs($coach)->get('/admin/attendances')->assertRedirect('/admin/schedules');
        $this->actingAs($coach)->get("/admin/attendances?schedule_id={$schedule->id}")->assertStatus(200);
        $this->actingAs($coach)->get('/admin/evaluations')->assertStatus(200);
        $this->actingAs($coach)->get("/admin/players/{$player->id}/evaluations/edit")->assertStatus(200);
        $this->actingAs($coach)->get('/admin/matches')->assertStatus(200);

        $this->actingAs($coach)->get('/admin/players/create')->assertStatus(403);
        $this->actingAs($coach)->post('/admin/players', [])->assertStatus(403);
        $this->actingAs($coach)->get("/admin/players/{$player->id}/edit")->assertStatus(403);
        $this->actingAs($coach)->put("/admin/players/{$player->id}", [])->assertStatus(403);
        $this->actingAs($coach)->delete("/admin/players/{$player->id}")->assertStatus(403);
        $this->actingAs($coach)->get('/admin/registrations')->assertStatus(403);
        $this->actingAs($coach)->get('/admin/inventories')->assertStatus(403);
        $this->actingAs($coach)->post("/admin/players/{$player->id}/spp-payments", [])->assertStatus(403);
    }
}
