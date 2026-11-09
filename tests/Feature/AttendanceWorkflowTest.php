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
}
