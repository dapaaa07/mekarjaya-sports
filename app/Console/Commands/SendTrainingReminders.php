<?php

namespace App\Console\Commands;

use App\Models\TrainingSchedule;
use App\Models\User;
use App\Notifications\TrainingReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTrainingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-training-reminders {--date= : Tanggal target jadwal latihan (YYYY-MM-DD, default besok)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pengingat H-1 jadwal latihan kepada admin dan pelatih.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $targetDate = $this->option('date')
            ? Carbon::parse((string) $this->option('date'))->toDateString()
            : Carbon::tomorrow()->toDateString();

        $schedules = TrainingSchedule::where('status', 'scheduled')
            ->whereDate('schedule_date', $targetDate)
            ->orderBy('start_time')
            ->get();

        if ($schedules->isEmpty()) {
            $this->info("Tidak ada jadwal latihan berstatus terjadwal untuk tanggal {$targetDate}.");
            return self::SUCCESS;
        }

        $recipients = User::whereIn('role', ['admin', 'coach'])->get();
        $sentCount = 0;

        foreach ($recipients as $user) {
            $existingReminders = $user->notifications()
                ->where('type', TrainingReminderNotification::class)
                ->get(['data']);

            foreach ($schedules as $schedule) {
                $alreadyNotified = $existingReminders->contains(function ($notification) use ($schedule, $targetDate) {
                    $data = is_array($notification->data) ? $notification->data : [];

                    return (int) ($data['schedule_id'] ?? 0) === (int) $schedule->id
                        && ($data['schedule_date'] ?? null) === $targetDate;
                });

                if ($alreadyNotified) {
                    continue;
                }

                $user->notify(new TrainingReminderNotification($schedule));
                $sentCount++;
            }
        }

        $this->info("{$sentCount} notifikasi pengingat latihan untuk tanggal {$targetDate} berhasil dikirim.");

        return self::SUCCESS;
    }
}
