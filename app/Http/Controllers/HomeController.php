<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\AgeCategory;
use App\Models\Coach;
use App\Models\MiniSoccerRate;
use App\Models\Registration;
use App\Models\TrainingSchedule;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Query player roster
        $query = Player::where('status', 'aktif');

        // Filter by Birth Year (Primary Pain Point Solution!)
        if ($request->filled('year')) {
            $query->where('birth_year', $request->year);
        }

        // Filter by Kelompok Umur Code (e.g. U-10, U-12, U-14, U-16, U-18)
        if ($request->filled('ku')) {
            $cat = AgeCategory::where('code', $request->ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        }

        // Search by Name or NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $players = $query->orderBy('birth_year', 'desc')->orderBy('full_name', 'asc')->paginate(12)->withQueryString();

        // Get list of unique birth years in database for dropdown
        $availableYears = Player::select('birth_year')
            ->distinct()
            ->orderBy('birth_year', 'desc')
            ->pluck('birth_year');

        $ageCategories = AgeCategory::all();
        $coaches = Coach::all();
        $miniSoccerRates = MiniSoccerRate::all();

        // Upcoming training schedules from database
        $upcomingSchedules = TrainingSchedule::where('status', 'scheduled')
            ->orderBy('schedule_date', 'asc')
            ->take(3)
            ->get();

        // Upcoming matches & tactics
        $upcomingMatches = \App\Models\MatchModel::orderBy('match_date', 'desc')->take(2)->get();

        // Stats summary for hero section
        $totalPlayers = Player::where('status', 'aktif')->count();
        $totalCoaches = Coach::count();
        $yearsCovered = $availableYears->count();

        return view('welcome', compact(
            'players',
            'availableYears',
            'ageCategories',
            'coaches',
            'miniSoccerRates',
            'upcomingSchedules',
            'upcomingMatches',
            'totalPlayers',
            'totalCoaches',
            'yearsCovered'
        ));
    }

    public function storeRegistration(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position_preference' => 'required|string',
            'jersey_size' => 'nullable|string|in:S,M,L,XL,XXL',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'school_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'health_notes' => 'nullable|string',
        ]);

        $birthYear = date('Y', strtotime($validated['birth_date']));
        $regCode = 'REG-MJ-' . date('Ym') . rand(100, 999);

        Registration::create(array_merge($validated, [
            'registration_code' => $regCode,
            'birth_year' => $birthYear,
            'status' => 'pending',
        ]));

        return redirect()->to(url('/#pendaftaran'))->with('success', "Pendaftaran berhasil dikirim! Kode pendaftaran Anda: {$regCode}. Pengurus SSB akan menghubungi Anda via WhatsApp.");
    }

    public function parentPortal(Request $request)
    {
        $player = null;

        if ($request->filled('nis')) {
            $keyword = trim($request->nis);
            $player = Player::where('nis', $keyword)
                ->orWhere('parent_phone', 'like', "%{$keyword}%")
                ->orWhere('full_name', 'like', "%{$keyword}%")
                ->first();
        }

        return view('public.parent_portal', compact('player'));
    }
}
