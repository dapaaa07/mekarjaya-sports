<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\AgeCategory;
use App\Models\Coach;
use App\Models\MiniSoccerRate;
use App\Models\Registration;
use App\Models\TrainingSchedule;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $ageCategories = AgeCategory::all();
        $coaches = Coach::all();
        $miniSoccerRates = MiniSoccerRate::all();

        // Upcoming training schedules from database
        $upcomingSchedules = TrainingSchedule::where('status', 'scheduled')
            ->orderBy('schedule_date', 'asc')
            ->take(3)
            ->get();

        $totalPlayers = Player::where('status', 'aktif')->count();
        $totalCoaches = Coach::count();
        $yearsCovered = Player::distinct('birth_year')->count('birth_year');

        return view('welcome', compact(
            'ageCategories',
            'coaches',
            'miniSoccerRates',
            'upcomingSchedules',
            'totalPlayers',
            'totalCoaches',
            'yearsCovered'
        ));
    }

    public function storeRegistration(Request $request, ImageCompressionService $compressionService)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position_preference' => 'required|string',
            'jersey_size' => 'nullable|string|in:S,M,L,XL,XXL',
            'height_cm' => 'nullable|integer|min:30|max:250',
            'weight_kg' => 'nullable|integer|min:10|max:200',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'school_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'health_notes' => 'nullable|string',
            'kk_document' => 'required|file|image|mimes:jpeg,jpg,png,webp|max:10240',
            'terms_agreement' => 'accepted',
        ], [
            'height_cm.integer' => 'Tinggi badan harus berupa angka.',
            'height_cm.min' => 'Tinggi badan minimal 30 cm.',
            'height_cm.max' => 'Tinggi badan maksimal 250 cm.',
            'weight_kg.integer' => 'Berat badan harus berupa angka.',
            'weight_kg.min' => 'Berat badan minimal 10 kg.',
            'weight_kg.max' => 'Berat badan maksimal 200 kg.',
            'kk_document.required' => 'Dokumen Kartu Keluarga (KK) wajib diunggah.',
            'kk_document.image' => 'File dokumen KK harus berupa gambar.',
            'kk_document.mimes' => 'Format file dokumen KK harus JPG, JPEG, PNG, atau WEBP.',
            'kk_document.max' => 'Ukuran file dokumen KK maksimal 10 MB.',
            'terms_agreement.accepted' => 'Anda wajib menyetujui Syarat & Ketentuan serta Kebijakan Privasi Dokumen KK.',
        ]);

        $kkPath = null;
        if ($request->hasFile('kk_document')) {
            $kkPath = $compressionService->processAndStore(
                $request->file('kk_document'),
                'documents/kk'
            );
        }

        $birthYear = date('Y', strtotime($validated['birth_date']));
        $regCode = 'REG-MJ-' . date('Ym') . rand(100, 999);

        unset($validated['terms_agreement']);
        unset($validated['kk_document']);

        $registration = Registration::create(array_merge($validated, [
            'registration_code' => $regCode,
            'birth_year' => $birthYear,
            'kk_document' => $kkPath,
            'status' => 'pending',
        ]));

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewRegistrationNotification($registration));
        }

        return redirect()->to(url('/#pendaftaran'))->with('success', "Pendaftaran berhasil dikirim! Kode pendaftaran Anda: {$regCode}. Pengurus SSB akan menghubungi Anda via WhatsApp.");
    }

    public function parentPortal(Request $request)
    {
        $player = null;

        if ($request->filled('nis')) {
            $keyword = trim($request->nis);
            $player = Player::with(['sppPayments', 'latestEvaluation', 'evaluations.match'])
                ->where(function ($q) use ($keyword) {
                    $q->where('nis', $keyword)
                      ->orWhere('parent_phone', 'like', "%{$keyword}%")
                      ->orWhere('full_name', 'like', "%{$keyword}%");
                })
                ->first();
        }

        return view('public.parent_portal', compact('player'));
    }
}
