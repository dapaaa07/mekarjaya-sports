<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MatchController extends Controller
{
    public function index()
    {
        $matches = MatchModel::orderBy('match_date', 'desc')->orderBy('id', 'desc')->paginate(15);
        $players = Player::where('status', 'aktif')
            ->orderBy('birth_year', 'desc')
            ->orderBy('full_name', 'asc')
            ->get();

        return view('admin.matches.index', compact('matches', 'players'));
    }

    public function store(Request $request)
    {
        $data = $this->validateMatchAndBuildPayload($request);
        MatchModel::create($data);

        return redirect()->route('admin.matches.index')->with('success', 'Catatan pertandingan dan susunan lineup berhasil ditambahkan.');
    }

    public function edit(MatchModel $match)
    {
        $players = Player::where('status', 'aktif')
            ->orderBy('birth_year', 'desc')
            ->orderBy('full_name', 'asc')
            ->get();

        return view('admin.matches.edit', compact('match', 'players'));
    }

    public function update(Request $request, MatchModel $match)
    {
        $data = $this->validateMatchAndBuildPayload($request);
        $match->update($data);

        return redirect()->route('admin.matches.index')->with('success', "Data pertandingan \"{$match->match_title}\" dan susunan lineup berhasil diperbarui.");
    }

    public function destroy(MatchModel $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Data pertandingan berhasil dihapus.');
    }

    /**
     * Validate match metadata, formation, and exact 11-player unique lineup with 1 Kiper.
     *
     * @return array<string, mixed>
     */
    protected function validateMatchAndBuildPayload(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'match_title' => 'required|string|max:255',
            'match_date' => 'required|date',
            'target_ku' => 'required|string|max:50',
            'match_type' => 'required|string|max:50',
            'opponent_name' => 'nullable|string|max:255',
            'score_result' => 'nullable|string|max:50',
            'man_of_the_match' => 'nullable|string|max:255',
            'match_notes' => 'nullable|string',
            'formation' => ['required', 'string', Rule::in(MatchModel::FORMATIONS)],
            'lineup' => 'required|array|size:11',
            'lineup.*.player_id' => 'required|integer|distinct|exists:players,id',
            'lineup.*.position' => ['required', 'string', Rule::in(MatchModel::LINEUP_POSITIONS)],
        ], [
            'formation.required' => 'Formasi pertandingan wajib dipilih.',
            'formation.in' => 'Pilihan formasi tidak valid.',
            'lineup.required' => 'Susunan 11 pemain inti wajib dilengkapi.',
            'lineup.size' => 'Susunan Starting XI wajib berisi tepat 11 pemain.',
            'lineup.*.player_id.required' => 'Semua 11 slot pemain inti wajib dipilih.',
            'lineup.*.player_id.distinct' => 'Setiap slot lineup harus diisi pemain yang berbeda (tidak boleh duplikat).',
            'lineup.*.player_id.exists' => 'Salah satu pemain yang dipilih tidak ditemukan.',
            'lineup.*.position.required' => 'Posisi setiap pemain dalam lineup wajib ditentukan.',
            'lineup.*.position.in' => 'Posisi pemain harus salah satu dari: Kiper, Bek, Gelandang, Penyerang.',
        ]);

        $validator->after(function ($v) use ($request) {
            $lineup = $request->input('lineup', []);
            if (is_array($lineup) && count($lineup) === 11) {
                $kiperCount = collect($lineup)
                    ->filter(fn ($slot) => ($slot['position'] ?? null) === 'Kiper')
                    ->count();

                if ($kiperCount !== 1) {
                    $v->errors()->add('lineup', 'Susunan Starting XI wajib memiliki tepat 1 pemain di posisi Kiper.');
                }
            }
        });

        $validated = $validator->validate();

        $playerIds = collect($validated['lineup'])->pluck('player_id')->all();
        $playersById = Player::whereIn('id', $playerIds)->get()->keyBy('id');

        $lineupPayload = collect($validated['lineup'])->values()->map(function ($slot, int $index) use ($playersById) {
            $player = $playersById->get((int) $slot['player_id']);

            return [
                'slot' => $index + 1,
                'player_id' => (int) $slot['player_id'],
                'nis' => $player?->nis ?? '',
                'player_name' => $player?->full_name ?? 'Pemain',
                'position' => $slot['position'],
            ];
        })->all();

        unset($validated['lineup']);
        $validated['lineup_json'] = $lineupPayload;

        return $validated;
    }
}
