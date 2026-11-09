<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Registration;
use App\Notifications\NewRegistrationNotification;
use App\Notifications\RegistrationStatusUpdatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_stores_pending_record_and_notifies_admin(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();

        $minimalPng = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='
        );
        $kkFile = UploadedFile::fake()->createWithContent('kk-siswa.png', $minimalPng);

        $response = $this->post('/register-siswa', [
            'full_name' => 'Rizky Pratama Subang',
            'birth_place' => 'Subang',
            'birth_date' => '2014-06-15',
            'position_preference' => 'Striker',
            'jersey_size' => 'M',
            'parent_name' => 'Budi Pratama',
            'parent_phone' => '081234567800',
            'school_name' => 'SDN 1 Subang',
            'address' => 'Jl. Veteran Subang',
            'health_notes' => 'Sehat',
            'kk_document' => $kkFile,
            'terms_agreement' => '1',
        ]);

        $response->assertRedirect('/#pendaftaran');
        $response->assertSessionHas('success');

        $registration = Registration::where('full_name', 'Rizky Pratama Subang')->first();
        $this->assertNotNull($registration);
        $this->assertEquals('pending', $registration->status);
        $this->assertNotNull($registration->kk_document);
        Storage::disk('public')->assertExists($registration->kk_document);

        $notif = $admin->notifications()->where('type', NewRegistrationNotification::class)->first();
        $this->assertNotNull($notif);
        $this->assertEquals($registration->id, $notif->data['registration_id']);
    }

    public function test_admin_approving_registration_creates_player_evaluation_and_notification(): void
    {
        $admin = $this->createAdmin();
        $registration = Registration::create([
            'registration_code' => 'REG-MJ-2026999',
            'full_name' => 'Faris Ardiansyah',
            'birth_place' => 'Subang',
            'birth_date' => '2015-05-10',
            'birth_year' => 2015,
            'position_preference' => 'Gelandang',
            'jersey_size' => 'M',
            'parent_name' => 'Hendra Santoso',
            'parent_phone' => '081299887766',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/admin/registrations/{$registration->id}/approve");

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('wa_notify');

        $registration->refresh();
        $this->assertEquals('approved', $registration->status);

        $player = Player::where('full_name', 'Faris Ardiansyah')->first();
        $this->assertNotNull($player);
        $this->assertEquals('aktif', $player->status);
        $this->assertNotNull($player->latestEvaluation);

        $notif = $admin->notifications()->where('type', RegistrationStatusUpdatedNotification::class)->first();
        $this->assertNotNull($notif);
        $this->assertEquals('approved', $notif->data['status']);
        $this->assertEquals($player->nis, $notif->data['nis']);
        $this->assertStringContainsString($player->nis, $notif->data['wa_message']);

        // Portal Ortu shows QR SVG for new player
        $portal = $this->get('/portal-ortu?nis=' . urlencode($player->nis));
        $portal->assertStatus(200);
        $portal->assertSee('Faris Ardiansyah');
        $portal->assertSee('<svg', false);
    }

    public function test_admin_rejecting_registration_updates_status_and_sends_notification(): void
    {
        $admin = $this->createAdmin();
        $registration = Registration::create([
            'registration_code' => 'REG-MJ-2026998',
            'full_name' => 'Calon Ditolak',
            'birth_place' => 'Subang',
            'birth_date' => '2015-05-10',
            'birth_year' => 2015,
            'position_preference' => 'Bek Tengah',
            'jersey_size' => 'L',
            'parent_name' => 'Wali Ditolak',
            'parent_phone' => '085200001111',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/admin/registrations/{$registration->id}/reject");

        $response->assertRedirect();
        $response->assertSessionHas('wa_notify');
        $this->assertEquals('rejected', $registration->fresh()->status);

        $notif = $admin->notifications()->where('type', RegistrationStatusUpdatedNotification::class)->first();
        $this->assertNotNull($notif);
        $this->assertEquals('rejected', $notif->data['status']);
    }
}
