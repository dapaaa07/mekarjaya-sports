<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\TrainingSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_attendance_stores_records_and_completes_linked_schedule(): void
    {
        $coach = $this->createCoach();
        $p1 = $this->createPlayer(['full_name' => 'Pemain Hadir']);
        $p2 = $this->createPlayer(['full_name' => 'Pemain Izin']);

        $schedule = TrainingSchedule::create([
            'title' => 'Latihan Passing & Kontrol',
            'schedule_date' => '2026-11-12',
            'start_time' => '15:30:00',
            'end_time' => '17:30:00',
            'location' => 'Lapangan Veteran Dangdeur Subang',
            'target_ku' => 'Semua KU',
            'coach_in_charge' => 'Coach Hendra Wijaya',
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($coach)->post('/admin/attendances', [
            'date' => '2026-11-12',
            'schedule_id' => $schedule->id,
            'attendance' => [
                $p1->id => 'hadir',
                $p2->id => 'izin',
            ],
        ]);

        $response->assertRedirect(route('admin.attendances.index', [
            'date' => '2026-11-12',
            'schedule_id' => $schedule->id,
        ]));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'player_id' => $p1->id,
            'training_schedule_id' => $schedule->id,
            'status' => 'hadir',
        ]);
        $this->assertDatabaseHas('attendances', [
            'player_id' => $p2->id,
            'training_schedule_id' => $schedule->id,
            'status' => 'izin',
        ]);
        $this->assertEquals(2, Attendance::count());
        $this->assertEquals('completed', $schedule->fresh()->status);
    }

    public function test_accessing_attendances_without_schedule_redirects_to_schedules_index_with_info(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get('/admin/attendances');
        $response->assertRedirect(route('admin.schedules.index'));
        $response->assertSessionHas('info');

        $invalidResponse = $this->actingAs($admin)->get('/admin/attendances?schedule_id=999999');
        $invalidResponse->assertRedirect(route('admin.schedules.index'));
        $invalidResponse->assertSessionHas('error');
    }

    public function test_accessing_attendances_with_schedule_renders_session_checklist(): void
    {
        $admin = $this->createAdmin();
        $player = $this->createPlayer(['full_name' => 'Bintang Pratama']);

        $schedule = TrainingSchedule::create([
            'title' => 'Latihan Taktikal & Simulasi',
            'schedule_date' => '2026-11-20',
            'start_time' => '15:30:00',
            'end_time' => '17:30:00',
            'location' => 'Stadion Mini Subang',
            'target_ku' => 'Semua KU',
            'coach_in_charge' => 'Coach Hendra',
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.attendances.index', [
            'schedule_id' => $schedule->id,
            'date' => '2026-11-20',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Latihan Taktikal &amp; Simulasi', false);
        $response->assertSee('Stadion Mini Subang');
        $response->assertSee('Bintang Pratama');
        $response->assertSee('Kembali ke Kelola Jadwal Latihan');
        $response->assertDontSee('-- Presensi Bebas Tanpa Sesi --');
    }
}

