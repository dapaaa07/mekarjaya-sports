<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFormattedTimeAttribute()
    {
        return date('H:i', strtotime($this->start_time)) . ' - ' . date('H:i', strtotime($this->end_time)) . ' WIB';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'completed' => '<span class="inline-block px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-[#DCFCE7] text-[#14532D] border-2 border-[#166534]">Selesai</span>',
            'cancelled' => '<span class="inline-block px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-[#FEE2E2] text-[#991B1B] border-2 border-[#B91C1C]">Dibatalkan</span>',
            default => '<span class="inline-block px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-[#FFFF00] text-[#111111] border-2 border-[#111111]">Terjadwal</span>',
        };
    }
}
