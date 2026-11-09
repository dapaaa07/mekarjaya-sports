<?php

namespace Tests\Feature;

use App\Models\MatchModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchLineupTest extends TestCase
{
    use RefreshDatabase;

    private function buildLineupPayload(array $players, array $positions): array
    {
        $lineup = [];
        foreach ($players as $index => $player) {
            $lineup[] = [
                'player_id' => $player->id,
                'position' => $positions[$index] ?? 'Gelandang',
            ];
        }

        return $lineup;
    }

    public function test_match_requires_eleven_unique_players_and_exact_one_kiper(): void
    {
        $coach = $this->createCoach();
        $players = [];
        for ($i = 1; $i <= 11; $i++) {
            $players[] = $this->createPlayer([
                'full_name' => "Pemain Skuad {$i}",
                'position' => $i === 1 ? 'Kiper' : 'Gelandang',
            ]);
        }

        // Case 1: Fewer than 11 players fails
        $tooFew = $this->actingAs($coach)->from('/admin/matches')->post('/admin/matches', [
            'match_title' => 'Uji Tanding Kurang Pemain',
            'match_date' => '2026-11-15',
            'target_ku' => 'U-14',
            'match_type' => 'Uji Tanding',
            'formation' => '4-3-3',
            'lineup' => $this->buildLineupPayload(array_slice($players, 0, 5), ['Kiper', 'Bek', 'Bek', 'Gelandang', 'Penyerang']),
        ]);
        $tooFew->assertRedirect('/admin/matches');
        $tooFew->assertSessionHasErrors('lineup');

        // Case 2: 11 players without any Kiper fails
        $noKiperPositions = array_fill(0, 11, 'Gelandang');
        $noKiper = $this->actingAs($coach)->from('/admin/matches')->post('/admin/matches', [
            'match_title' => 'Uji Tanding Tanpa Kiper',
            'match_date' => '2026-11-15',
            'target_ku' => 'U-14',
            'match_type' => 'Uji Tanding',
            'formation' => '4-3-3',
            'lineup' => $this->buildLineupPayload($players, $noKiperPositions),
        ]);
        $noKiper->assertRedirect('/admin/matches');
        $noKiper->assertSessionHasErrors('lineup');

        // Case 3: Duplicate player in 11 slots fails
        $duplicatePlayers = $players;
        $duplicatePlayers[1] = $players[0];
        $dupResponse = $this->actingAs($coach)->from('/admin/matches')->post('/admin/matches', [
            'match_title' => 'Uji Tanding Duplikat',
            'match_date' => '2026-11-15',
            'target_ku' => 'U-14',
            'match_type' => 'Uji Tanding',
            'formation' => '4-3-3',
            'lineup' => $this->buildLineupPayload($duplicatePlayers, ['Kiper', 'Bek', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang', 'Penyerang', 'Penyerang']),
        ]);
        $dupResponse->assertRedirect('/admin/matches');
        $dupResponse->assertSessionHasErrors('lineup.1.player_id');

        $this->assertEquals(0, MatchModel::count());
    }

    public function test_coach_can_store_and_update_match_with_formation_and_eleven_players(): void
    {
        $coach = $this->createCoach();
        $players = [];
        for ($i = 1; $i <= 11; $i++) {
            $players[] = $this->createPlayer([
                'full_name' => "Pemain Inti {$i}",
                'position' => $i === 1 ? 'Kiper' : 'Gelandang',
            ]);
        }

        $positions352 = ['Kiper', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang', 'Penyerang'];

        $store = $this->actingAs($coach)->post('/admin/matches', [
            'match_title' => 'Laga Persahabatan Mekar Jaya',
            'match_date' => '2026-11-15',
            'target_ku' => 'U-14',
            'match_type' => 'Uji Tanding',
            'opponent_name' => 'SSB Pagaden',
            'score_result' => '3 - 1',
            'man_of_the_match' => 'Pemain Inti 10',
            'formation' => '3-5-2',
            'lineup' => $this->buildLineupPayload($players, $positions352),
        ]);

        $store->assertRedirect('/admin/matches');
        $store->assertSessionHas('success');

        $match = MatchModel::first();
        $this->assertNotNull($match);
        $this->assertEquals('3-5-2', $match->formation);
        $this->assertIsArray($match->lineup_json);
        $this->assertCount(11, $match->lineup_json);
        $this->assertEquals('Kiper', $match->lineup_json[0]['position']);

        // Update formation via edit/update
        $positions4231 = ['Kiper', 'Bek', 'Bek', 'Bek', 'Bek', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Gelandang', 'Penyerang'];
        $update = $this->actingAs($coach)->put("/admin/matches/{$match->id}", [
            'match_title' => 'Laga Persahabatan Mekar Jaya Revisi',
            'match_date' => '2026-11-15',
            'target_ku' => 'U-14',
            'match_type' => 'Uji Tanding',
            'opponent_name' => 'SSB Pagaden',
            'score_result' => '4 - 1',
            'formation' => '4-2-3-1',
            'lineup' => $this->buildLineupPayload($players, $positions4231),
        ]);

        $update->assertRedirect('/admin/matches');
        $this->assertEquals('4-2-3-1', $match->fresh()->formation);
        $this->assertEquals('Laga Persahabatan Mekar Jaya Revisi', $match->fresh()->match_title);
    }
}
