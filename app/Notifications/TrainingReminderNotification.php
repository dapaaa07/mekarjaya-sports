<?php

namespace App\Notifications;

use App\Models\TrainingSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TrainingReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public TrainingSchedule $schedule
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $dateLabel = $this->schedule->schedule_date->format('d M Y');

        return [
            'type' => 'training_reminder',
            'badge' => 'H-1 LATIHAN',
            'schedule_id' => $this->schedule->id,
            'schedule_date' => $this->schedule->schedule_date->toDateString(),
            'title' => "Pengingat Latihan Besok: {$this->schedule->title}",
            'message' => "Jadwal {$dateLabel}, {$this->schedule->formatted_time} di {$this->schedule->location} (Target {$this->schedule->target_ku}).",
            'url' => route('admin.schedules.index', [], false),
        ];
    }
}
