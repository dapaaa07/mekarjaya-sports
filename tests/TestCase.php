<?php

namespace Tests;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    protected function createAdmin(array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => 'Admin Mekar Jaya',
            'email' => 'admin+' . uniqid() . '@mekarjaya.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ], $overrides));
    }

    protected function createCoach(array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => 'Coach Hendra Wijaya',
            'email' => 'coach+' . uniqid() . '@mekarjaya.com',
            'password' => Hash::make('password'),
            'role' => 'coach',
        ], $overrides));
    }

    protected function createPlayer(array $overrides = []): Player
    {
        $seq = random_int(1000, 9999);

        return Player::create(array_merge([
            'nis' => 'SSB-MJ-TEST-' . $seq . '-' . uniqid(),
            'full_name' => 'Pemain Uji ' . $seq,
            'nickname' => 'Uji',
            'birth_place' => 'Subang',
            'birth_date' => '2014-05-12',
            'birth_year' => 2014,
            'position' => 'Gelandang',
            'jersey_size' => 'M',
            'parent_name' => 'Wali Uji',
            'parent_phone' => '081234567890',
            'status' => 'aktif',
            'spp_status' => 'Belum Bayar',
            'joined_year' => 2024,
        ], $overrides));
    }
}
