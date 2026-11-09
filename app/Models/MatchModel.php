<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    protected $table = 'matches';
    protected $guarded = [];

    public const FORMATIONS = [
        '4-3-3',
        '4-4-2',
        '3-5-2',
        '4-2-3-1',
        '5-3-2',
    ];

    public const LINEUP_POSITIONS = [
        'Kiper',
        'Bek',
        'Gelandang',
        'Penyerang',
    ];

    protected $casts = [
        'match_date' => 'date',
        'lineup_json' => 'array',
    ];
}
