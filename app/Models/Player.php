<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function latestEvaluation()
    {
        return $this->hasOne(Evaluation::class)->latestOfMany();
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date ? $this->birth_date->age : (now()->year - $this->birth_year);
    }

    public function getAgeCategoryBadgeAttribute(): string
    {
        $age = $this->age;
        if ($age <= 10) return 'U-10 (2016+)';
        if ($age <= 12) return 'U-12 (2014-2015)';
        if ($age <= 14) return 'U-14 (2012-2013)';
        if ($age <= 16) return 'U-16 (2010-2011)';
        return 'U-18 (2008-2009)';
    }
}
