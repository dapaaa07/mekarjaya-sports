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
}
