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
            'height_cm' => 145,
            'weight_kg' => 38,
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
        $this->assertEquals(145, $registration->height_cm);
        $this->assertEquals(38, $registration->weight_kg);
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
            'height_cm' => 142,
            'weight_kg' => 36,
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
        $this->assertEquals(142, $player->height_cm);
        $this->assertEquals(36, $player->weight_kg);
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

        $response = $this->actingAs($admin)->post("/admin/registrations/{$registration->id}/reject", [
            'rejection_notes' => 'Foto dokumen KK buram dan tidak terbaca jelas.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('wa_notify');

        $fresh = $registration->fresh();
        $this->assertEquals('rejected', $fresh->status);
        $this->assertEquals('Foto dokumen KK buram dan tidak terbaca jelas.', $fresh->rejection_notes);

        $notif = $admin->notifications()->where('type', RegistrationStatusUpdatedNotification::class)->first();
        $this->assertNotNull($notif);
        $this->assertEquals('rejected', $notif->data['status']);
        $this->assertStringContainsString('Foto dokumen KK buram dan tidak terbaca jelas.', $notif->data['wa_message']);
        $this->assertStringContainsString(rawurlencode('Foto dokumen KK buram dan tidak terbaca jelas.'), $notif->data['wa_url']);

        $indexResponse = $this->actingAs($admin)->get('/admin/registrations');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Foto dokumen KK buram dan tidak terbaca jelas.');
        $indexResponse->assertSee('WA Alasan');
    }

    public function test_landing_and_admin_players_render_jersey_size_guide_modal_and_trigger(): void
    {
        $admin = $this->createAdmin();
        $player = $this->createPlayer();

        $landingRes = $this->get('/');
        $landingRes->assertStatus(200);
        $landingRes->assertSee('openJerseyModal()');
        $landingRes->assertSee('id="jersey-size-modal"', false);
        $landingRes->assertSee('Panduan Pemilihan Ukuran Jersey Siswa');
        $landingRes->assertDontSee('</div>' . "\n\n" . '    function closeJerseyModal()', false);

        $createRes = $this->actingAs($admin)->get('/admin/players/create');
        $createRes->assertStatus(200);
        $createRes->assertSee('openJerseyModal()');
        $createRes->assertSee('id="jersey-size-modal"', false);

        $editRes = $this->actingAs($admin)->get("/admin/players/{$player->id}/edit");
        $editRes->assertStatus(200);
        $editRes->assertSee('openJerseyModal()');
        $editRes->assertSee('id="jersey-size-modal"', false);
    }

    public function test_admin_can_view_registration_detail_with_comprehensive_medical_notes(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();

        $registration = Registration::create([
            'registration_code' => 'REG-MJ-2026777',
            'full_name' => 'Aditya Pratama Subang',
            'birth_place' => 'Subang',
            'birth_date' => '2014-04-18',
            'birth_year' => 2014,
            'position_preference' => 'Gelandang',
            'jersey_size' => 'S',
            'height_cm' => 142,
            'weight_kg' => 36,
            'parent_name' => 'Hendra Pratama',
            'parent_phone' => '081299887766',
            'school_name' => 'SD Negeri Subang Jaya',
            'address' => 'Jl. Dangdeur No. 12, Subang',
            'health_notes' => 'Memiliki riwayat asma ringan saat cuaca dingin dan alergi seafood.',
            'status' => 'pending',
        ]);

        $indexRes = $this->actingAs($admin)->get('/admin/registrations');
        $indexRes->assertStatus(200);
        $indexRes->assertSee('Aditya Pratama Subang');
        $indexRes->assertSee(route('admin.registrations.show', $registration->id));
        $indexRes->assertSee('Medis');
        $indexRes->assertSee('Detail');

        $showRes = $this->actingAs($admin)->get("/admin/registrations/{$registration->id}");
        $showRes->assertStatus(200);
        $showRes->assertSee('Aditya Pratama Subang');
        $showRes->assertSee('REG-MJ-2026777');
        $showRes->assertSee('Catatan Riwayat Kesehatan &amp; Penyakit', false);
        $showRes->assertSee('Memiliki riwayat asma ringan saat cuaca dingin dan alergi seafood.');
        $showRes->assertSee('Perlu Perhatian');
        $showRes->assertSee('142 cm');
        $showRes->assertSee('36 kg');
        $showRes->assertSee('Size S');
        $showRes->assertSee('Hendra Pratama');
        $showRes->assertSee('081299887766');
        $showRes->assertSee('Chat WhatsApp Orang Tua');
        $showRes->assertSee('Setujui Pendaftaran');
        $showRes->assertSee('Tolak Pendaftaran');

        auth()->logout();
        $guestRes = $this->get("/admin/registrations/{$registration->id}");
        $guestRes->assertRedirect('/login');
    }
}


