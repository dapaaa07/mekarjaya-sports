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

        return redirect()->route('admin.matches.index')->with('success', 'Catatan pertandingan dan susunan skuad berhasil ditambahkan.');
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

        return redirect()->route('admin.matches.index')->with('success', "Data pertandingan \"{$match->match_title}\" dan susunan skuad berhasil diperbarui.");
    }

    public function destroy(MatchModel $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Data pertandingan berhasil dihapus.');
    }

    /**
     * Validate match metadata, formation, exact 11-player Starting XI with 1 Kiper,
     * and optional unique substitute players.
     *
     * @return array<string, mixed>
     */
    protected function validateMatchAndBuildPayload(Request $request): array
    {
        $rawSubs = collect($request->input('substitutes', []))
            ->filter(fn ($row) => is_array($row) && !empty($row['player_id']))
            ->values()
            ->all();

        $input = $request->all();
        $input['substitutes'] = $rawSubs;

        $validator = Validator::make($input, [
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
            'substitutes' => 'nullable|array|max:15',
            'substitutes.*.player_id' => 'required|integer|distinct|exists:players,id',
            'substitutes.*.position' => ['required', 'string', Rule::in(MatchModel::LINEUP_POSITIONS)],
        ], [
            'formation.required' => 'Formasi pertandingan wajib dipilih.',
            'formation.in' => 'Pilihan formasi tidak valid.',
            'lineup.required' => 'Susunan 11 pemain inti wajib dilengkapi.',
            'lineup.size' => 'Susunan Starting XI wajib berisi tepat 11 pemain.',
            'lineup.*.player_id.required' => 'Semua 11 slot pemain inti wajib dipilih.',
            'lineup.*.player_id.distinct' => 'Setiap slot Starting XI harus diisi pemain yang berbeda (tidak boleh duplikat).',
            'lineup.*.player_id.exists' => 'Salah satu pemain inti yang dipilih tidak ditemukan.',
            'lineup.*.position.required' => 'Posisi setiap pemain inti wajib ditentukan.',
            'lineup.*.position.in' => 'Posisi pemain harus salah satu dari: Kiper, Bek, Gelandang, Penyerang.',
            'substitutes.max' => 'Jumlah pemain cadangan maksimal 15 pemain.',
            'substitutes.*.player_id.distinct' => 'Pemain cadangan tidak boleh dipilih lebih dari satu kali.',
            'substitutes.*.player_id.exists' => 'Salah satu pemain cadangan tidak ditemukan.',
            'substitutes.*.position.in' => 'Posisi pemain cadangan harus salah satu dari: Kiper, Bek, Gelandang, Penyerang.',
        ]);

        $validator->after(function ($v) use ($input) {
            $lineup = $input['lineup'] ?? [];
            if (is_array($lineup) && count($lineup) === 11) {
                $kiperCount = collect($lineup)
                    ->filter(fn ($slot) => ($slot['position'] ?? null) === 'Kiper')
                    ->count();

                if ($kiperCount !== 1) {
                    $v->errors()->add('lineup', 'Susunan Starting XI wajib memiliki tepat 1 pemain di posisi Kiper.');
                }
            }

            $starterIds = collect($lineup)
                ->pluck('player_id')
                ->filter()
                ->map(fn ($id) => (int) $id)
                ->all();

            foreach (($input['substitutes'] ?? []) as $idx => $sub) {
                $subId = (int) ($sub['player_id'] ?? 0);
                if ($subId > 0 && in_array($subId, $starterIds, true)) {
                    $v->errors()->add("substitutes.{$idx}.player_id", 'Pemain cadangan tidak boleh sama dengan pemain yang sudah masuk di Starting XI.');
                }
            }
        });

        $validated = $validator->validate();

        $starterIds = collect($validated['lineup'])->pluck('player_id');
        $subIds = collect($validated['substitutes'] ?? [])->pluck('player_id');
        $allIds = $starterIds->merge($subIds)->unique()->all();
        $playersById = Player::whereIn('id', $allIds)->get()->keyBy('id');

        $starterPayload = collect($validated['lineup'])->values()->map(function ($slot, int $index) use ($playersById) {
            $player = $playersById->get((int) $slot['player_id']);

            return [
                'slot' => $index + 1,
                'role' => 'starter',
                'player_id' => (int) $slot['player_id'],
                'nis' => $player?->nis ?? '',
                'player_name' => $player?->full_name ?? 'Pemain',
                'position' => $slot['position'],
            ];
        });

        $subPayload = collect($validated['substitutes'] ?? [])->values()->map(function ($slot, int $index) use ($playersById) {
            $player = $playersById->get((int) $slot['player_id']);

            return [
                'slot' => 12 + $index,
                'role' => 'substitute',
                'player_id' => (int) $slot['player_id'],
                'nis' => $player?->nis ?? '',
                'player_name' => $player?->full_name ?? 'Pemain',
                'position' => $slot['position'],
            ];
        });

        unset($validated['lineup'], $validated['substitutes']);
        $validated['lineup_json'] = $starterPayload->merge($subPayload)->values()->all();

        return $validated;
    }
}
