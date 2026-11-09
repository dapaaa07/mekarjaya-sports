<?php

namespace Tests\Feature;

use App\Models\TrainingSchedule;
use App\Notifications\TrainingReminderNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingReminderNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_h_minus_one_command_notifies_admin_and_coach_without_duplicating(): void
    {
        $admin = $this->createAdmin();
        $coach = $this->createCoach();

        $tomorrowSchedule = TrainingSchedule::create([
            'title' => 'Latihan Taktik Zona',
            'schedule_date' => Carbon::tomorrow()->toDateString(),
            'start_time' => '15:30:00',
            'end_time' => '17:30:00',
            'location' => 'Lapangan Veteran Dangdeur Subang',
            'target_ku' => 'U-14',
            'coach_in_charge' => 'Coach Hendra Wijaya',
            'status' => 'scheduled',
        ]);

        // Unrelated future schedule (should not trigger H-1 today)
        TrainingSchedule::create([
            'title' => 'Latihan Pekan Depan',
            'schedule_date' => Carbon::now()->addDays(7)->toDateString(),
            'start_time' => '15:30:00',
            'end_time' => '17:30:00',
            'location' => 'Lapangan Veteran Dangdeur Subang',
            'target_ku' => 'U-12',
            'status' => 'scheduled',
        ]);

        $this->artisan('app:send-training-reminders')->assertExitCode(0);

        $this->assertEquals(1, $admin->unreadNotifications()->where('type', TrainingReminderNotification::class)->count());
        $this->assertEquals(1, $coach->unreadNotifications()->where('type', TrainingReminderNotification::class)->count());

        $coachNotif = $coach->notifications()->first();
        $this->assertEquals($tomorrowSchedule->id, $coachNotif->data['schedule_id']);

        // Second execution must remain idempotent
        $this->artisan('app:send-training-reminders')->assertExitCode(0);
        $this->assertEquals(1, $admin->notifications()->count());
        $this->assertEquals(1, $coach->notifications()->count());

        // Mark single notification as read via endpoint
        $this->actingAs($coach)
            ->post("/admin/notifications/{$coachNotif->id}/read")
            ->assertRedirect();
        $this->assertEquals(0, $coach->fresh()->unreadNotifications()->count());

        // Mark all as read via endpoint for admin
        $this->actingAs($admin)
            ->post('/admin/notifications/read-all')
            ->assertRedirect();
        $this->assertEquals(0, $admin->fresh()->unreadNotifications()->count());
    }
}
