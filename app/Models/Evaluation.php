<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'evaluation_date' => 'date',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function match()
    {
        return $this->belongsTo(MatchModel::class, 'match_id');
    }

    public function getAverageScoreAttribute(): float
    {
        return round(($this->passing_score + $this->dribbling_score + $this->shooting_score + $this->physical_score + $this->discipline_score + $this->tactical_score) / 6, 1);
    }
}
