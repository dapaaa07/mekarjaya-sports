<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    protected $table = 'matches';
    protected $guarded = [];

    protected $casts = [
        'match_date' => 'date',
        'lineup_json' => 'array',
    ];
}
