<?php

namespace Tests\Feature;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluationHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_multiple_evaluations_preserves_history_and_updates_latest(): void
    {
        $coach = $this->createCoach();
        $admin = $this->createAdmin();
        $player = $this->createPlayer(['nis' => 'SSB-MJ-EVAL-01']);

        $this->actingAs($coach)->post("/admin/players/{$player->id}/evaluations", [
            'evaluation_date' => '2026-08-10',
            'passing_score' => 70,
            'dribbling_score' => 72,
            'shooting_score' => 68,
            'physical_score' => 75,
            'discipline_score' => 80,
            'tactical_score' => 70,
            'coach_notes' => 'Evaluasi periode pertama.',
        ])->assertRedirect(route('admin.evaluations.edit', $player->id));

        $this->actingAs($coach)->post("/admin/players/{$player->id}/evaluations", [
            'evaluation_date' => '2026-10-15',
            'passing_score' => 85,
            'dribbling_score' => 84,
            'shooting_score' => 80,
            'physical_score' => 86,
            'discipline_score' => 90,
            'tactical_score' => 82,
            'coach_notes' => 'Peningkatan akurasi umpan periode kedua.',
        ])->assertRedirect(route('admin.evaluations.edit', $player->id));

        $this->assertEquals(2, Evaluation::where('player_id', $player->id)->count());
        $this->assertDatabaseHas('evaluations', [
            'player_id' => $player->id,
            'passing_score' => 70,
            'coach_notes' => 'Evaluasi periode pertama.',
        ]);
        $this->assertDatabaseHas('evaluations', [
            'player_id' => $player->id,
            'passing_score' => 85,
            'coach_notes' => 'Peningkatan akurasi umpan periode kedua.',
        ]);

        $latest = $player->fresh()->latestEvaluation;
        $this->assertNotNull($latest);
        $this->assertEquals(85, $latest->passing_score);

        // Player detail renders QR SVG and evaluation progression panel
        $show = $this->actingAs($admin)->get("/admin/players/{$player->id}");
        $show->assertStatus(200);
        $show->assertSee('2 Periode Evaluasi');
        $show->assertSee('<svg', false);

        // Printable report renders QR SVG cleanly
        $rapor = $this->actingAs($admin)->get("/admin/players/{$player->id}/print-rapor");
        $rapor->assertStatus(200);
        $rapor->assertSee('<svg', false);
        $rapor->assertSee($player->nis);
    }
}
