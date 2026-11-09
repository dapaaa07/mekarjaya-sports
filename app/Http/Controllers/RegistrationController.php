<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Player;
use App\Models\Evaluation;
use App\Models\User;
use App\Notifications\RegistrationStatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function approve(Registration $registration)
    {
        if ($registration->status === 'approved') {
            return back()->with('info', 'Pendaftaran ini sudah disetujui sebelumnya.');
        }

        // Convert registration to active Player!
        $nis = 'SSB-MJ-' . date('y') . rand(1000, 9999);
        $player = Player::create([
            'nis' => $nis,
            'full_name' => $registration->full_name,
            'nickname' => explode(' ', trim($registration->full_name))[0],
            'birth_place' => $registration->birth_place,
            'birth_date' => $registration->birth_date,
            'birth_year' => $registration->birth_year,
            'position' => $registration->position_preference,
            'jersey_size' => $registration->jersey_size ?? 'M',
            'school_name' => $registration->school_name,
            'parent_name' => $registration->parent_name,
            'parent_phone' => $registration->parent_phone,
            'kk_document' => $registration->kk_document,
            'status' => 'aktif',
            'spp_status' => 'Belum Bayar',
            'joined_year' => (int) date('Y'),
        ]);

        Evaluation::create([
            'player_id' => $player->id,
            'evaluation_date' => now(),
            'passing_score' => 75,
            'dribbling_score' => 75,
            'shooting_score' => 75,
            'physical_score' => 75,
            'discipline_score' => 80,
            'tactical_score' => 70,
            'coach_notes' => 'Pendaftaran online disetujui. Pemain resmi bergabung.',
        ]);

        $registration->update(['status' => 'approved']);

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new RegistrationStatusUpdatedNotification($registration, 'approved', $player));
        }

        $waPayload = RegistrationStatusUpdatedNotification::buildWaPayload($registration, 'approved', $player);

        return back()
            ->with('success', "Pendaftaran {$registration->full_name} berhasil disetujui dan telah resmi ditambahkan sebagai pemain (NIS: {$nis})!")
            ->with('wa_notify', array_merge($waPayload, [
                'title' => "Pesan Konfirmasi WhatsApp ({$registration->parent_name})",
                'status' => 'approved',
            ]));
    }

    public function reject(Registration $registration)
    {
        $registration->update(['status' => 'rejected']);

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new RegistrationStatusUpdatedNotification($registration, 'rejected'));
        }

        $waPayload = RegistrationStatusUpdatedNotification::buildWaPayload($registration, 'rejected');

        return back()
            ->with('success', "Pendaftaran {$registration->full_name} telah ditolak.")
            ->with('wa_notify', array_merge($waPayload, [
                'title' => "Pesan Pemberitahuan WhatsApp ({$registration->parent_name})",
                'status' => 'rejected',
            ]));
    }
}
