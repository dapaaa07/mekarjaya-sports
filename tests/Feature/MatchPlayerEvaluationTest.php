<?php

namespace Tests\Feature;

use App\Models\Evaluation;
use App\Models\MatchModel;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchPlayerEvaluationTest extends TestCase
{
    use RefreshDatabase;

    public function test_coach_can_view_match_evaluation_page(): void
    {
        $coach = $this->createCoach();
        $player = $this->createPlayer(['nis' => 'SSB-MJ-MATCH-01']);

        $match = MatchModel::create([
            'match_title' => 'Friendly Match U-12',
            'match_date' => '2026-10-01',
            'target_ku' => 'U-12',
            'match_type' => 'Uji Tanding',
            'formation' => '4-3-3',
            'lineup_json' => [
                [
                    'slot' => 1,
                    'role' => 'starter',
                    'player_id' => $player->id,
                    'nis' => $player->nis,
                    'player_name' => $player->full_name,
                    'position' => 'Gelandang',
                ],
            ],
        ]);

        $response = $this->actingAs($coach)->get("/admin/matches/{$match->id}/evaluations");

        $response->assertStatus(200);
        $response->assertSee('Friendly Match U-12');
        $response->assertSee($player->full_name);
        $response->assertSee('Gelandang');
    }

    public function test_coach_can_submit_evaluations_for_match_squad(): void
    {
        $coach = $this->createCoach();
        $p1 = $this->createPlayer(['nis' => 'SSB-MJ-MATCH-10', 'full_name' => 'Bintang Pratama']);
        $p2 = $this->createPlayer(['nis' => 'SSB-MJ-MATCH-11', 'full_name' => 'Fajar Santoso']);

        $match = MatchModel::create([
            'match_title' => 'Turnamen Antar SSB',
            'match_date' => '2026-10-05',
            'target_ku' => 'U-14',
            'match_type' => 'Turnamen KU',
            'formation' => '4-3-3',
            'lineup_json' => [
                ['slot' => 1, 'role' => 'starter', 'player_id' => $p1->id, 'nis' => $p1->nis, 'player_name' => $p1->full_name, 'position' => 'Penyerang'],
                ['slot' => 12, 'role' => 'substitute', 'player_id' => $p2->id, 'nis' => $p2->nis, 'player_name' => $p2->full_name, 'position' => 'Bek'],
            ],
        ]);

        $response = $this->actingAs($coach)->post("/admin/matches/{$match->id}/evaluations", [
            'evaluations' => [
                $p1->id => [
                    'include' => '1',
                    'passing_score' => 80,
                    'dribbling_score' => 82,
                    'shooting_score' => 86,
                    'physical_score' => 80,
                    'discipline_score' => 90,
                    'tactical_score' => 78,
                    'coach_notes' => 'Finishing tajam.',
                ],
                $p2->id => [
                    'include' => '1',
                    'passing_score' => 74,
                    'dribbling_score' => 70,
                    'shooting_score' => 65,
                    'physical_score' => 76,
                    'discipline_score' => 85,
                    'tactical_score' => 72,
                    'coach_notes' => 'Disiplin saat rotasi.',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.matches.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('evaluations', [
            'match_id' => $match->id,
            'player_id' => $p1->id,
            'passing_score' => 80,
            'shooting_score' => 86,
        ]);

        $this->assertDatabaseHas('evaluations', [
            'match_id' => $match->id,
            'player_id' => $p2->id,
            'passing_score' => 74,
            'shooting_score' => 65,
        ]);
    }

    public function test_player_statistics_are_accumulated_from_multiple_matches(): void
    {
        $coach = $this->createCoach();
        $player = $this->createPlayer(['nis' => 'SSB-MJ-ACC-01']);

        $match1 = MatchModel::create([
            'match_title' => 'Laga 1 vs Putra Panembong',
            'match_date' => '2026-09-10',
            'target_ku' => 'U-12',
            'match_type' => 'Uji Tanding',
        ]);

        $match2 = MatchModel::create([
            'match_title' => 'Laga 2 vs Persikas Subang',
            'match_date' => '2026-09-24',
            'target_ku' => 'U-12',
            'match_type' => 'Uji Tanding',
        ]);

        // Match 1 scores: Pass 80, Drib 76, Shoot 70, Phys 80, Disc 86, Tact 74
        Evaluation::create([
            'player_id' => $player->id,
            'match_id' => $match1->id,
            'evaluation_date' => $match1->match_date,
            'passing_score' => 80,
            'dribbling_score' => 76,
            'shooting_score' => 70,
            'physical_score' => 80,
            'discipline_score' => 86,
            'tactical_score' => 74,
            'coach_notes' => 'Catatan laga 1.',
        ]);

        // Match 2 scores: Pass 90, Drib 84, Shoot 80, Phys 86, Disc 94, Tact 82
        Evaluation::create([
            'player_id' => $player->id,
            'match_id' => $match2->id,
            'evaluation_date' => $match2->match_date,
            'passing_score' => 90,
            'dribbling_score' => 84,
            'shooting_score' => 80,
            'physical_score' => 86,
            'discipline_score' => 94,
            'tactical_score' => 82,
            'coach_notes' => 'Catatan laga 2.',
        ]);

        $accumulated = $player->fresh()->accumulated_stats;

        // Averages: Pass (80+90)/2 = 85, Drib (76+84)/2 = 80, Shoot (70+80)/2 = 75, Phys (80+86)/2 = 83, Disc (86+94)/2 = 90, Tact (74+82)/2 = 78
        $this->assertTrue($accumulated->is_accumulated);
        $this->assertEquals(2, $accumulated->matches_count);
        $this->assertEquals(85, $accumulated->passing_score);
        $this->assertEquals(80, $accumulated->dribbling_score);
        $this->assertEquals(75, $accumulated->shooting_score);
        $this->assertEquals(83, $accumulated->physical_score);
        $this->assertEquals(90, $accumulated->discipline_score);
        $this->assertEquals(78, $accumulated->tactical_score);

        // Portal Ortu renders accumulated radar data and match history with per-match statistics
        $portal = $this->get('/portal-ortu?nis=' . urlencode($player->nis));
        $portal->assertStatus(200);
        $portal->assertSee('Akumulasi 2 Laga');
        $portal->assertSee('Riwayat Pertandingan &amp; Statistik Per Laga', false);
        $portal->assertSee('2 Laga Dimainkan');
        $portal->assertSee('Laga 1 vs Putra Panembong');
        $portal->assertSee('Laga 2 vs Persikas Subang');
        $portal->assertSee('Catatan laga 1.');
        $portal->assertSee('Catatan laga 2.');
        $portal->assertSee('Rincian 6 Parameter Nilai Pertandingan Ini');

        // Evaluation detail view displays accumulated values and per-match rows
        $evalDetail = $this->actingAs($coach)->get("/admin/players/{$player->id}/evaluations/edit");
        $evalDetail->assertStatus(200);
        $evalDetail->assertSee('2 Laga Dinilai');
        $evalDetail->assertSee('Laga 1 vs Putra Panembong');
        $evalDetail->assertSee('Laga 2 vs Persikas Subang');
    }

    public function test_portal_ortu_displays_empty_state_when_player_has_no_matches(): void
    {
        $player = $this->createPlayer(['nis' => 'SSB-MJ-NOMATCH']);

        $response = $this->get('/portal-ortu?nis=' . urlencode($player->nis));
        $response->assertStatus(200);
        $response->assertSee('Belum Ada Riwayat Pertandingan');
        $response->assertSee('0 Laga Dimainkan');
    }
}
