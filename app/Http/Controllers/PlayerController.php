<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\AgeCategory;
use App\Models\Evaluation;
use App\Models\Attendance;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Player::query();

        // Primary Pain Point Solution: Filter by Birth Year
        if ($request->filled('year')) {
            $query->where('birth_year', $request->year);
        }

        // Filter by Kelompok Umur
        if ($request->filled('ku')) {
            $cat = AgeCategory::where('code', $request->ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by SPP Status
        if ($request->filled('spp_status')) {
            $query->where('spp_status', $request->spp_status);
        }

        // Search Name, NIS, Nickname
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $players = $query->orderBy('birth_year', 'desc')->orderBy('full_name', 'asc')->paginate(15)->withQueryString();

        // Available Birth Years list
        $availableYears = Player::select('birth_year')
            ->distinct()
            ->orderBy('birth_year', 'desc')
            ->pluck('birth_year');

        $ageCategories = AgeCategory::all();

        return view('admin.players.index', compact('players', 'availableYears', 'ageCategories'));
    }

    public function create()
    {
        return view('admin.players.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position' => 'required|string',
            'jersey_size' => 'required|string|in:S,M,L,XL,XXL',
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|integer',
            'school_name' => 'nullable|string|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'status' => 'required|in:aktif,alumni,non-aktif',
            'spp_status' => 'required|in:Lunas,Belum Bayar',
        ]);

        $birthYear = date('Y', strtotime($validated['birth_date']));
        $nis = 'SSB-MJ-' . date('y') . rand(1000, 9999);

        $player = Player::create(array_merge($validated, [
            'nis' => $nis,
            'birth_year' => $birthYear,
            'joined_year' => date('Y'),
        ]));

        // Create initial evaluation record
        Evaluation::create([
            'player_id' => $player->id,
            'evaluation_date' => now(),
            'passing_score' => 75,
            'dribbling_score' => 75,
            'shooting_score' => 75,
            'physical_score' => 75,
            'discipline_score' => 80,
            'tactical_score' => 70,
            'coach_notes' => 'Pemain baru terdaftar.',
        ]);

        return redirect()->route('admin.players.index')->with('success', "Data pemain {$player->full_name} (NIS: {$player->nis}) berhasil ditambahkan!");
    }

    public function show(Player $player)
    {
        $evaluation = $player->latestEvaluation;
        $attendances = $player->attendances()->orderBy('date', 'desc')->take(10)->get();

        return view('admin.players.show', compact('player', 'evaluation', 'attendances'));
    }

    public function edit(Player $player)
    {
        return view('admin.players.edit', compact('player'));
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position' => 'required|string',
            'jersey_size' => 'required|string|in:S,M,L,XL,XXL',
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|integer',
            'school_name' => 'nullable|string|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'status' => 'required|in:aktif,alumni,non-aktif',
            'spp_status' => 'required|in:Lunas,Belum Bayar',
        ]);

        $birthYear = date('Y', strtotime($validated['birth_date']));

        $player->update(array_merge($validated, [
            'birth_year' => $birthYear,
        ]));

        return redirect()->route('admin.players.show', $player->id)->with('success', "Data pemain {$player->full_name} berhasil diperbarui!");
    }

    public function destroy(Player $player)
    {
        $name = $player->full_name;
        $player->delete();
        return redirect()->route('admin.players.index')->with('success', "Data pemain {$name} telah dihapus.");
    }

    public function exportPrintable(Request $request)
    {
        $query = Player::where('status', 'aktif');

        if ($request->filled('year')) {
            $query->where('birth_year', $request->year);
        }

        if ($request->filled('ku')) {
            $cat = AgeCategory::where('code', $request->ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        }

        $players = $query->orderBy('birth_year', 'desc')->orderBy('full_name', 'asc')->get();
        $selectedYear = $request->year;
        $selectedKu = $request->ku;

        return view('admin.players.print', compact('players', 'selectedYear', 'selectedKu'));
    }

    public function printRapor(Player $player)
    {
        $evaluation = $player->latestEvaluation;
        $attendanceCount = $player->attendances()->where('status', 'hadir')->count();
        $totalSessions = $player->attendances()->count();
        $attendanceRate = $totalSessions > 0 ? round(($attendanceCount / $totalSessions) * 100) : 100;

        return view('admin.players.print-rapor', compact('player', 'evaluation', 'attendanceRate'));
    }

    public function toggleSpp(Player $player)
    {
        $newStatus = $player->spp_status === 'Lunas' ? 'Belum Bayar' : 'Lunas';
        $player->update(['spp_status' => $newStatus]);
        return back()->with('success', "Status SPP {$player->full_name} diubah menjadi {$newStatus}.");
    }
}
