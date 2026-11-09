<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Registration $registration
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
        return [
            'type' => 'registration_new',
            'badge' => 'PENDAFTAR BARU',
            'title' => "Pendaftaran Baru: {$this->registration->full_name}",
            'message' => "Kode {$this->registration->registration_code} ({$this->registration->position_preference}, kelahiran {$this->registration->birth_year}). Wali: {$this->registration->parent_name} ({$this->registration->parent_phone}).",
            'registration_id' => $this->registration->id,
            'registration_code' => $this->registration->registration_code,
            'url' => route('admin.registrations.index', [], false),
        ];
    }
}
