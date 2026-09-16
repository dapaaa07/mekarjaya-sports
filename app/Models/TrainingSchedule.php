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
            'completed' => '<span class="px-2.5 py-1 rounded text-[11px] font-semibold bg-[#16A34A]/10 text-[#16A34A] border border-[#16A34A]/30">Selesai</span>',
            'cancelled' => '<span class="px-2.5 py-1 rounded text-[11px] font-semibold bg-[#c41c1c]/10 text-[#c41c1c] border border-[#c41c1c]/30">Dibatalkan</span>',
            default => '<span class="px-2.5 py-1 rounded text-[11px] font-semibold bg-[#ebe7e1] text-[#ff5600] border border-[#ff5600]">Terjadwal</span>',
        };
    }
}
