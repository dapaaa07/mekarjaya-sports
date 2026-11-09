<?php

namespace App\Notifications;

use App\Models\Player;
use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RegistrationStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Registration $registration,
        public string $status,
        public ?Player $player = null
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

    public static function buildWaPayload(Registration $registration, string $status, ?Player $player = null): array
    {
        $digits = preg_replace('/[^0-9]/', '', (string) $registration->parent_phone) ?? '';
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        if ($status === 'approved') {
            $nis = $player?->nis ?? '-';
            $portalUrl = route('parent.portal', ['nis' => $nis]);
            $waMessage = "Halo Bapak/Ibu {$registration->parent_name}, selamat! Pendaftaran {$registration->full_name} (Kode {$registration->registration_code}) di SSB Mekar Jaya Subang telah DISETUJUI. NIS Pemain: {$nis}. Cek Kartu Siswa Digital dan jadwal latihan di Portal Orang Tua: {$portalUrl}";
        } else {
            $waMessage = "Halo Bapak/Ibu {$registration->parent_name}, mohon maaf permohonan pendaftaran {$registration->full_name} (Kode {$registration->registration_code}) di SSB Mekar Jaya Subang belum dapat disetujui saat ini. Silakan hubungi pengurus SSB untuk informasi lebih lanjut.";
        }

        return [
            'phone' => $registration->parent_phone,
            'message' => $waMessage,
            'url' => $digits !== '' ? 'https://wa.me/' . $digits . '?text=' . rawurlencode($waMessage) : null,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $wa = self::buildWaPayload($this->registration, $this->status, $this->player);
        $nis = $this->player?->nis;

        if ($this->status === 'approved') {
            $title = "Pendaftaran Disetujui: {$this->registration->full_name}";
            $message = "NIS {$nis} telah aktif. Kirim atau salin pesan konfirmasi WA ke {$this->registration->parent_name}.";
            $badge = 'DISETUJUI';
        } else {
            $title = "Pendaftaran Ditolak: {$this->registration->full_name}";
            $message = "Pendaftaran kode {$this->registration->registration_code} ditolak. Kirim info lanjutan ke {$this->registration->parent_name}.";
            $badge = 'DITOLAK';
        }

        return [
            'type' => 'registration_status',
            'badge' => $badge,
            'status' => $this->status,
            'title' => $title,
            'message' => $message,
            'registration_id' => $this->registration->id,
            'registration_code' => $this->registration->registration_code,
            'player_id' => $this->player?->id,
            'nis' => $nis,
            'wa_phone' => $wa['phone'],
            'wa_message' => $wa['message'],
            'wa_url' => $wa['url'],
            'url' => $this->player
                ? route('admin.players.show', $this->player->id, false)
                : route('admin.registrations.index', [], false),
        ];
    }
}
