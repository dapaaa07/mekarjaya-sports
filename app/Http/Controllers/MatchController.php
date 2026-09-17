<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = MatchModel::orderBy('match_date', 'desc')->paginate(15);
        return view('admin.matches.index', compact('matches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'match_title' => 'required|string|max:255',
            'match_date' => 'required|date',
            'target_ku' => 'required|string',
            'match_type' => 'required|string',
            'opponent_name' => 'nullable|string|max:255',
            'score_result' => 'nullable|string|max:50',
            'man_of_the_match' => 'nullable|string|max:255',
            'match_notes' => 'nullable|string',
        ]);

        MatchModel::create($validated);
        return redirect()->route('admin.matches.index')->with('success', 'Catatan pertandingan berhasil ditambahkan.');
    }

    public function destroy(MatchModel $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Data pertandingan berhasil dihapus.');
    }

    public function tactics(MatchModel $match)
    {
        $query = \App\Models\Player::where('status', 'aktif');
        if ($match->target_ku !== 'Semua KU') {
            $cat = \App\Models\AgeCategory::where('code', $match->target_ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        }
        $availablePlayers = $query->orderBy('birth_year', 'desc')->orderBy('full_name', 'asc')->get();

        return view('admin.matches.tactics', compact('match', 'availablePlayers'));
    }

    public function updateTactics(Request $request, MatchModel $match)
    {
        $validated = $request->validate([
            'formation' => 'required|string',
            'lineup' => 'nullable|array',
        ]);

        $match->update([
            'formation' => $validated['formation'],
            'lineup_json' => $validated['lineup'] ?? [],
        ]);

        return redirect()->route('admin.matches.index')->with('success', "Formasi taktik FM {$validated['formation']} untuk pertandingan {$match->match_title} berhasil disimpan!");
    }
}
