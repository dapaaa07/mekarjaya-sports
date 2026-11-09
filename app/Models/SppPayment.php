<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppPayment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'periode_bulan' => 'integer',
        'periode_tahun' => 'integer',
        'jumlah' => 'integer',
    ];

    public const MONTHS_ID = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function getPeriodLabelAttribute(): string
    {
        $monthName = self::MONTHS_ID[$this->periode_bulan] ?? (string) $this->periode_bulan;
        return "{$monthName} {$this->periode_tahun}";
    }

    public function getFormattedJumlahAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }
}
