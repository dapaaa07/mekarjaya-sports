<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Evaluation;
use Illuminate\Http\Request;

use App\Models\AgeCategory;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = Player::with('latestEvaluation')->where('status', 'aktif');

        if ($request->filled('year')) {
            $query->where('birth_year', $request->year);
        }

        if ($request->filled('ku')) {
            $cat = AgeCategory::where('code', $request->ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $players = $query->orderBy('birth_year', 'desc')->orderBy('full_name', 'asc')->paginate(15)->withQueryString();
        $availableYears = Player::select('birth_year')->distinct()->orderBy('birth_year', 'desc')->pluck('birth_year');
        $ageCategories = AgeCategory::all();

        return view('admin.evaluations.index', compact('players', 'availableYears', 'ageCategories'));
    }

    public function edit(Player $player)
    {
        $evaluation = $player->latestEvaluation ?? new Evaluation([
            'evaluation_date' => now()->toDateString(),
            'passing_score' => 75,
            'dribbling_score' => 75,
            'shooting_score' => 75,
            'physical_score' => 75,
            'discipline_score' => 80,
            'tactical_score' => 70,
        ]);

        $evaluations = $player->evaluations()
            ->orderBy('evaluation_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $evaluationTrend = $evaluations->reverse()->values();

        return view('admin.evaluations.edit', compact('player', 'evaluation', 'evaluations', 'evaluationTrend'));
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'evaluation_date' => 'nullable|date',
            'passing_score' => 'required|integer|min:0|max:100',
            'dribbling_score' => 'required|integer|min:0|max:100',
            'shooting_score' => 'required|integer|min:0|max:100',
            'physical_score' => 'required|integer|min:0|max:100',
            'discipline_score' => 'required|integer|min:0|max:100',
            'tactical_score' => 'required|integer|min:0|max:100',
            'coach_notes' => 'nullable|string',
        ]);

        Evaluation::create([
            'player_id' => $player->id,
            'evaluation_date' => $validated['evaluation_date'] ?? now()->toDateString(),
            'passing_score' => $validated['passing_score'],
            'dribbling_score' => $validated['dribbling_score'],
            'shooting_score' => $validated['shooting_score'],
            'physical_score' => $validated['physical_score'],
            'discipline_score' => $validated['discipline_score'],
            'tactical_score' => $validated['tactical_score'],
            'coach_notes' => $validated['coach_notes'] ?? null,
        ]);

        $redirectRoute = $request->user()->isAdmin()
            ? route('admin.players.show', $player->id) . '#evaluation-history'
            : route('admin.evaluations.edit', $player->id);

        return redirect($redirectRoute)->with('success', "Riwayat evaluasi performa baru untuk {$player->full_name} berhasil disimpan!");
    }
}
