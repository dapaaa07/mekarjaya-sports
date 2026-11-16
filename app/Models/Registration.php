<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getAgeAttribute(): int
    {
        return $this->birth_date ? $this->birth_date->age : (now()->year - $this->birth_year);
    }

    public function getAgeCategoryBadgeAttribute(): string
    {
        $category = AgeCategory::where('min_birth_year', '<=', $this->birth_year)
            ->where('max_birth_year', '>=', $this->birth_year)
            ->first();

        if ($category) {
            return "{$category->category_name} ({$category->code})";
        }

        $age = $this->age;
        if ($age <= 10) return 'U-10';
        if ($age <= 12) return 'U-12';
        if ($age <= 14) return 'U-14';
        if ($age <= 16) return 'U-16';
        return 'U-18';
    }

    public function getCleanParentPhoneAttribute(): string
    {
        $clean = preg_replace('/[^0-9]/', '', (string) $this->parent_phone);
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }
        return $clean;
    }

    public function getMatchedPlayerAttribute(): ?Player
    {
        return Player::where('full_name', $this->full_name)->latest()->first();
    }
}
