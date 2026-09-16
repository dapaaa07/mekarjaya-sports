<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function edit(Player $player)
    {
        $evaluation = $player->latestEvaluation ?? new Evaluation([
            'passing_score' => 75,
            'dribbling_score' => 75,
            'shooting_score' => 75,
            'physical_score' => 75,
            'discipline_score' => 80,
            'tactical_score' => 70,
        ]);

        return view('admin.evaluations.edit', compact('player', 'evaluation'));
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'passing_score' => 'required|integer|min:0|max:100',
            'dribbling_score' => 'required|integer|min:0|max:100',
            'shooting_score' => 'required|integer|min:0|max:100',
            'physical_score' => 'required|integer|min:0|max:100',
            'discipline_score' => 'required|integer|min:0|max:100',
            'tactical_score' => 'required|integer|min:0|max:100',
            'coach_notes' => 'nullable|string',
        ]);

        Evaluation::updateOrCreate(
            ['player_id' => $player->id],
            array_merge($validated, [
                'evaluation_date' => now(),
            ])
        );

        return redirect()->route('admin.players.show', $player->id)->with('success', "Rapor evaluasi performa {$player->full_name} berhasil diperbarui!");
    }
}
