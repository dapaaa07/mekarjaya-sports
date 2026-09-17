<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Player;
use App\Models\Evaluation;
use Illuminate\Http\Request;

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
            'birth_place' => $registration->birth_place,
            'birth_date' => $registration->birth_date,
            'birth_year' => $registration->birth_year,
            'position' => $registration->position_preference,
            'jersey_size' => $registration->jersey_size ?? 'M',
            'school_name' => $registration->school_name,
            'parent_name' => $registration->parent_name,
            'parent_phone' => $registration->parent_phone,
            'status' => 'aktif',
            'spp_status' => 'Lunas',
            'joined_year' => date('Y'),
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

        return back()->with('success', "Pendaftaran {$registration->full_name} berhasil disetujui dan telah resmi ditambahkan sebagai pemain (NIS: {$nis})!");
    }

    public function reject(Registration $registration)
    {
        $registration->update(['status' => 'rejected']);
        return back()->with('success', "Pendaftaran {$registration->full_name} telah ditolak.");
    }
}
