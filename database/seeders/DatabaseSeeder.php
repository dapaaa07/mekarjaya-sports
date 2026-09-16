<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Player;
use App\Models\AgeCategory;
use App\Models\Attendance;
use App\Models\Evaluation;
use App\Models\Registration;
use App\Models\Coach;
use App\Models\MiniSoccerRate;
use App\Models\TrainingSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@mekarjaya.com'],
            [
                'name' => 'Admin Mekar Jaya Subang',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Age Categories
        $categories = [
            [
                'category_name' => 'Kelompok Umur U-10 (Kelahiran 2016 - 2017)',
                'code' => 'U-10',
                'min_birth_year' => 2016,
                'max_birth_year' => 2017,
                'monthly_fee' => 150000,
                'schedule_days' => 'Selasa & Kamis',
                'schedule_time' => '15:30 - 17:00 WIB',
                'description' => 'Fokus pada fondasi teknik dasar, ball control, dan fun football.'
            ],
            [
                'category_name' => 'Kelompok Umur U-12 (Kelahiran 2014 - 2015)',
                'code' => 'U-12',
                'min_birth_year' => 2014,
                'max_birth_year' => 2015,
                'monthly_fee' => 150000,
                'schedule_days' => 'Selasa & Kamis',
                'schedule_time' => '15:30 - 17:30 WIB',
                'description' => 'Pengembangan passing, dribbling, serta pemahaman taktik 7v7 dan 9v9.'
            ],
            [
                'category_name' => 'Kelompok Umur U-14 (Kelahiran 2012 - 2013)',
                'code' => 'U-14',
                'min_birth_year' => 2012,
                'max_birth_year' => 2013,
                'monthly_fee' => 175000,
                'schedule_days' => 'Selasa, Kamis & Sabtu',
                'schedule_time' => '15:30 - 17:30 WIB',
                'description' => 'Persiapan turnamen usia muda, taktik 11v11, serta ketahanan fisik.'
            ],
            [
                'category_name' => 'Kelompok Umur U-16 (Kelahiran 2010 - 2011)',
                'code' => 'U-16',
                'min_birth_year' => 2010,
                'max_birth_year' => 2011,
                'monthly_fee' => 175000,
                'schedule_days' => 'Selasa, Kamis & Sabtu',
                'schedule_time' => '16:00 - 18:00 WIB',
                'description' => 'Taktik pertandingan lanjutan, penguatan fisik, dan kejuaraan daerah Subang.'
            ],
            [
                'category_name' => 'Kelompok Umur U-18 / Senior Muda (Kelahiran 2008 - 2009)',
                'code' => 'U-18',
                'min_birth_year' => 2008,
                'max_birth_year' => 2009,
                'monthly_fee' => 200000,
                'schedule_days' => 'Rabu & Sabtu',
                'schedule_time' => '16:00 - 18:00 WIB',
                'description' => 'Tahap transisi ke Liga 3 / Akademi Profesional PSSI.'
            ],
        ];

        foreach ($categories as $cat) {
            AgeCategory::updateOrCreate(['code' => $cat['code']], $cat);
        }

        // 3. Coaches
        $coaches = [
            [
                'name' => 'Coach Hendra Wijaya',
                'role_title' => 'Head Coach & Direktur Teknik SSB',
                'license' => 'Lisensi B AFC / PSSI',
                'experience_years' => 12,
                'phone' => '0812-3456-7890',
            ],
            [
                'name' => 'Coach Asep Sunandar',
                'role_title' => 'Pelatih Kepala U-12 & U-14',
                'license' => 'Lisensi C PSSI',
                'experience_years' => 8,
                'phone' => '0813-9876-5432',
            ],
            [
                'name' => 'Coach Rizky Permana',
                'role_title' => 'Pelatih Kiper (Goalkeeper Coach)',
                'license' => 'Lisensi Kiper Level 1 PSSI',
                'experience_years' => 6,
                'phone' => '0857-1122-3344',
            ],
        ];

        foreach ($coaches as $c) {
            Coach::updateOrCreate(['name' => $c['name']], $c);
        }

        // 4. Sample Training Schedules (Jadwal Latihan Terhubung Dengan Presensi)
        $schedulesData = [
            [
                'title' => 'Sesi Latihan Rutin Teknik Dasar & Ball Control',
                'schedule_date' => '2026-09-01',
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'location' => 'Lapangan Veteran Dangdeur Subang',
                'target_ku' => 'Semua KU',
                'coach_in_charge' => 'Coach Hendra Wijaya',
                'notes' => 'Fokus penguatan passing pendek dan stamina pemain.',
                'status' => 'completed',
            ],
            [
                'title' => 'Sesi Simulasi Pertandingan & Taktik 7v7',
                'schedule_date' => '2026-09-03',
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'location' => 'Lapangan Veteran Dangdeur Subang',
                'target_ku' => 'U-12',
                'coach_in_charge' => 'Coach Asep Sunandar',
                'notes' => 'Simulasi pergerakan tanpa bola dan transisi bertahan ke menyerang.',
                'status' => 'completed',
            ],
            [
                'title' => 'Latihan Rutin Fisik & Endurance KU U-14',
                'schedule_date' => '2026-09-08',
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'location' => 'Lapangan Veteran Dangdeur Subang',
                'target_ku' => 'U-14',
                'coach_in_charge' => 'Coach Hendra Wijaya',
                'notes' => 'Tes fisik periodik dan kecepatan sprin 30 meter.',
                'status' => 'completed',
            ],
            [
                'title' => 'Latihan Khusus Kiper & Finishing Striker',
                'schedule_date' => '2026-09-10',
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'location' => 'Mekar Jaya Mini Soccer Subang',
                'target_ku' => 'Semua KU',
                'coach_in_charge' => 'Coach Rizky Permana',
                'notes' => 'Latihan menangkap bola udara dan tendangan jarak jauh.',
                'status' => 'completed',
            ],
            [
                'title' => 'Latihan Taktik Pertandingan U-16 & U-18',
                'schedule_date' => '2026-09-15',
                'start_time' => '16:00:00',
                'end_time' => '18:00:00',
                'location' => 'Lapangan Veteran Dangdeur Subang',
                'target_ku' => 'U-16',
                'coach_in_charge' => 'Coach Hendra Wijaya',
                'notes' => 'Persiapan turnamen antar SSB Kabupaten Subang.',
                'status' => 'completed',
            ],
            [
                'title' => 'Sesi Latihan Rutin & Skema Set-Piece',
                'schedule_date' => '2026-09-18',
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'location' => 'Lapangan Veteran Dangdeur Subang',
                'target_ku' => 'Semua KU',
                'coach_in_charge' => 'Coach Hendra Wijaya',
                'notes' => 'Latihan bola mati (corner kick & free kick) dan penyelesaian akhir.',
                'status' => 'scheduled',
            ],
            [
                'title' => 'Internal Game Match U-12 vs U-14',
                'schedule_date' => '2026-09-20',
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'location' => 'Lapangan Veteran Dangdeur Subang',
                'target_ku' => 'U-12',
                'coach_in_charge' => 'Coach Asep Sunandar',
                'notes' => 'Uji tanding internal untuk seleksi tim inti kejuaraan Subang.',
                'status' => 'scheduled',
            ],
        ];

        $createdSchedules = [];
        foreach ($schedulesData as $sData) {
            $createdSchedules[$sData['schedule_date']] = TrainingSchedule::updateOrCreate(
                ['schedule_date' => $sData['schedule_date'], 'title' => $sData['title']],
                $sData
            );
        }

        // 5. Players (Data Siswa SSB Mekar Jaya Subang dengan variasi tahun lahir 2008-2018)
        $samplePlayers = [
            // Tahun 2017 (U-10)
            ['name' => 'Muhammad Fatih Subang', 'birth_year' => 2017, 'dob' => '2017-04-12', 'pos' => 'Penyerang Sayap', 'nis' => 'SSB-MJ-1701', 'spp' => 'Lunas'],
            ['name' => 'Aditya Pratama', 'birth_year' => 2017, 'dob' => '2017-08-25', 'pos' => 'Gelandang', 'nis' => 'SSB-MJ-1702', 'spp' => 'Lunas'],
            
            // Tahun 2016 (U-10)
            ['name' => 'Rafi Ahmad Ramadhan', 'birth_year' => 2016, 'dob' => '2016-01-15', 'pos' => 'Striker', 'nis' => 'SSB-MJ-1601', 'spp' => 'Lunas'],
            ['name' => 'Daffi Alghifari', 'birth_year' => 2016, 'dob' => '2016-09-30', 'pos' => 'Bek Sayap', 'nis' => 'SSB-MJ-1602', 'spp' => 'Belum Bayar'],
            ['name' => 'Bintang Febrian', 'birth_year' => 2016, 'dob' => '2016-11-05', 'pos' => 'Kiper', 'nis' => 'SSB-MJ-1603', 'spp' => 'Lunas'],

            // Tahun 2015 (U-12)
            ['name' => 'Reza Pahlevi Dangdeur', 'birth_year' => 2015, 'dob' => '2015-03-18', 'pos' => 'Gelandang Serang', 'nis' => 'SSB-MJ-1501', 'spp' => 'Lunas'],
            ['name' => 'Farhan Saputra', 'birth_year' => 2015, 'dob' => '2015-06-22', 'pos' => 'Bek Tengah', 'nis' => 'SSB-MJ-1502', 'spp' => 'Lunas'],
            ['name' => 'Gilang Ramadhan', 'birth_year' => 2015, 'dob' => '2015-10-14', 'pos' => 'Bek Sayap', 'nis' => 'SSB-MJ-1503', 'spp' => 'Lunas'],

            // Tahun 2014 (U-12)
            ['name' => 'Fathan Mubina Subang', 'birth_year' => 2014, 'dob' => '2014-02-10', 'pos' => 'Striker', 'nis' => 'SSB-MJ-1401', 'spp' => 'Lunas'],
            ['name' => 'Naufal Rizqullah', 'birth_year' => 2014, 'dob' => '2014-07-19', 'pos' => 'Gelandang Bertahan', 'nis' => 'SSB-MJ-1402', 'spp' => 'Lunas'],
            ['name' => 'Kevin Sanjaya', 'birth_year' => 2014, 'dob' => '2014-12-01', 'pos' => 'Kiper', 'nis' => 'SSB-MJ-1403', 'spp' => 'Belum Bayar'],

            // Tahun 2013 (U-14)
            ['name' => 'Arya Wiguna Cigadung', 'birth_year' => 2013, 'dob' => '2013-04-05', 'pos' => 'Bek Tengah', 'nis' => 'SSB-MJ-1301', 'spp' => 'Lunas'],
            ['name' => 'Dimas Anggara', 'birth_year' => 2013, 'dob' => '2013-08-11', 'pos' => 'Penyerang Sayap', 'nis' => 'SSB-MJ-1302', 'spp' => 'Lunas'],
            ['name' => 'Zaky Mubarok', 'birth_year' => 2013, 'dob' => '2013-10-28', 'pos' => 'Gelandang Serang', 'nis' => 'SSB-MJ-1303', 'spp' => 'Lunas'],

            // Tahun 2012 (U-14)
            ['name' => 'Rangga Putra Subang', 'birth_year' => 2012, 'dob' => '2012-01-20', 'pos' => 'Striker', 'nis' => 'SSB-MJ-1201', 'spp' => 'Lunas'],
            ['name' => 'Iqbal Tawakal', 'birth_year' => 2012, 'dob' => '2012-05-14', 'pos' => 'Bek Sayap', 'nis' => 'SSB-MJ-1202', 'spp' => 'Lunas'],
            ['name' => 'Haikal Kamil', 'birth_year' => 2012, 'dob' => '2012-09-09', 'pos' => 'Gelandang Bertahan', 'nis' => 'SSB-MJ-1203', 'spp' => 'Belum Bayar'],

            // Tahun 2011 (U-16)
            ['name' => 'Andra Alfarizi Subang', 'birth_year' => 2011, 'dob' => '2011-03-30', 'pos' => 'Penyerang Sayap', 'nis' => 'SSB-MJ-1101', 'spp' => 'Lunas'],
            ['name' => 'Fikri Haikal', 'birth_year' => 2011, 'dob' => '2011-07-04', 'pos' => 'Bek Tengah', 'nis' => 'SSB-MJ-1102', 'spp' => 'Lunas'],

            // Tahun 2010 (U-16)
            ['name' => 'Satria Utama Subang', 'birth_year' => 2010, 'dob' => '2010-02-14', 'pos' => 'Gelandang Serang', 'nis' => 'SSB-MJ-1001', 'spp' => 'Lunas'],
            ['name' => 'Bagus Kahfi Subang', 'birth_year' => 2010, 'dob' => '2010-06-18', 'pos' => 'Striker', 'nis' => 'SSB-MJ-1002', 'spp' => 'Lunas'],

            // Tahun 2009 & 2008 (U-18)
            ['name' => 'Riyan Ardiansyah', 'birth_year' => 2009, 'dob' => '2009-04-11', 'pos' => 'Kiper', 'nis' => 'SSB-MJ-0901', 'spp' => 'Lunas'],
            ['name' => 'Bayu Pradana Subang', 'birth_year' => 2008, 'dob' => '2008-11-20', 'pos' => 'Gelandang Bertahan', 'nis' => 'SSB-MJ-0801', 'spp' => 'Lunas'],
        ];

        foreach ($samplePlayers as $pData) {
            $player = Player::updateOrCreate(
                ['nis' => $pData['nis']],
                [
                    'full_name' => $pData['name'],
                    'nickname' => explode(' ', $pData['name'])[0],
                    'birth_place' => 'Subang',
                    'birth_date' => $pData['dob'],
                    'birth_year' => $pData['birth_year'],
                    'position' => $pData['pos'],
                    'height_cm' => rand(130, 175),
                    'weight_kg' => rand(30, 68),
                    'school_name' => 'SD/SMP Negeri di Subang',
                    'parent_name' => 'Bapak ' . explode(' ', $pData['name'])[0],
                    'parent_phone' => '0851-3346-' . rand(1000, 9999),
                    'status' => 'aktif',
                    'spp_status' => $pData['spp'],
                    'joined_year' => 2023,
                ]
            );

            // Create sample evaluation for player
            Evaluation::updateOrCreate(
                ['player_id' => $player->id],
                [
                    'evaluation_date' => Carbon::now()->subMonths(1),
                    'passing_score' => rand(70, 92),
                    'dribbling_score' => rand(68, 95),
                    'shooting_score' => rand(65, 90),
                    'physical_score' => rand(72, 94),
                    'discipline_score' => rand(80, 98),
                    'tactical_score' => rand(65, 88),
                    'coach_notes' => 'Pemain memiliki potensi tinggi. Perlu meningkatkan stamina dan koordinasi tim.',
                ]
            );

            // Create sample attendances linked to training schedules
            foreach (['2026-09-01', '2026-09-03', '2026-09-08', '2026-09-10', '2026-09-15'] as $attDate) {
                $sched = $createdSchedules[$attDate] ?? null;
                Attendance::updateOrCreate(
                    ['player_id' => $player->id, 'date' => $attDate],
                    [
                        'status' => rand(1, 10) > 2 ? 'hadir' : (rand(1, 2) == 1 ? 'izin' : 'sakit'),
                        'training_schedule_id' => $sched ? $sched->id : null,
                    ]
                );
            }
        }

        // 6. Mini Soccer Rates (Mekar Jaya Mini Soccer Subang)
        $rates = [
            [
                'day_type' => 'Weekday (Senin - Jumat)',
                'time_slot' => 'Pagi - Siang (06.00 - 15.00 WIB)',
                'price_per_hour' => 120000,
                'facilities' => 'Rumput Sintetis Premium, Wifi, Ruang Ganti, Parkir Luas',
            ],
            [
                'day_type' => 'Weekday (Senin - Jumat)',
                'time_slot' => 'Sore - Malam (15.00 - 00.00 WIB)',
                'price_per_hour' => 180000,
                'facilities' => 'Lampu LED Stadion, Rumput Sintetis Premium, Sound System, Resto & Cafe',
            ],
            [
                'day_type' => 'Weekend (Sabtu - Minggu)',
                'time_slot' => 'Pagi - Siang (06.00 - 15.00 WIB)',
                'price_per_hour' => 180000,
                'facilities' => 'Rumput Sintetis Premium, Papan Skor Digital, Ruang VIP',
            ],
            [
                'day_type' => 'Weekend (Sabtu - Minggu)',
                'time_slot' => 'Sore - Malam (15.00 - 00.00 WIB)',
                'price_per_hour' => 220000,
                'facilities' => 'Lampu LED Full HD, Fotografer Lapangan (opsional), Sound System & Cafe',
            ],
        ];

        foreach ($rates as $r) {
            MiniSoccerRate::updateOrCreate(
                ['day_type' => $r['day_type'], 'time_slot' => $r['time_slot']],
                $r
            );
        }

        // 7. Sample Pending Registrations
        $pendingRegs = [
            [
                'registration_code' => 'REG-MJ-20260901',
                'full_name' => 'Faris Ardiansyah Subang',
                'birth_place' => 'Subang',
                'birth_date' => '2015-05-10',
                'birth_year' => 2015,
                'position_preference' => 'Striker',
                'parent_name' => 'Budi Santoso',
                'parent_phone' => '0812-9988-7766',
                'school_name' => 'SDN Dangdeur Subang',
                'address' => 'Jl. Veteran Dangdeur No. 45, Subang',
                'health_notes' => 'Tidak ada riwayat penyakit berat.',
                'status' => 'pending',
            ],
            [
                'registration_code' => 'REG-MJ-20260902',
                'full_name' => 'Alvaro Maldonado',
                'birth_place' => 'Subang',
                'birth_date' => '2013-09-18',
                'birth_year' => 2013,
                'position_preference' => 'Gelandang',
                'parent_name' => 'Deden Kurnia',
                'parent_phone' => '0852-4455-6677',
                'school_name' => 'SMPN 1 Subang',
                'address' => 'Cigadung, Subang',
                'health_notes' => 'Fit.',
                'status' => 'pending',
            ],
        ];

        foreach ($pendingRegs as $reg) {
            Registration::updateOrCreate(['registration_code' => $reg['registration_code']], $reg);
        }
    }
}
