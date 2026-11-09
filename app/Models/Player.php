<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        return $this->hasOne(Evaluation::class)->latestOfMany(['evaluation_date', 'id']);
    }

    public function sppPayments()
    {
        return $this->hasMany(SppPayment::class)
            ->orderBy('periode_tahun', 'desc')
            ->orderBy('periode_bulan', 'desc')
            ->orderBy('id', 'desc');
    }

    public function getDefaultMonthlyFeeAttribute(): int
    {
        $category = AgeCategory::where('min_birth_year', '<=', $this->birth_year)
            ->where('max_birth_year', '>=', $this->birth_year)
            ->first();

        return $category ? (int) $category->monthly_fee : 150000;
    }

    public function hasPaidSppForMonth(?int $month = null, ?int $year = null): bool
    {
        $month = $month ?? (int) now()->month;
        $year = $year ?? (int) now()->year;

        if ($this->relationLoaded('sppPayments')) {
            return $this->sppPayments->contains(
                fn (SppPayment $payment) => (int) $payment->periode_bulan === $month && (int) $payment->periode_tahun === $year
            );
        }

        return $this->sppPayments()
            ->where('periode_bulan', $month)
            ->where('periode_tahun', $year)
            ->exists();
    }

    public function getCurrentSppStatusAttribute(): string
    {
        return $this->hasPaidSppForMonth() ? 'Lunas' : 'Belum Bayar';
    }

    public function syncCurrentSppStatus(): void
    {
        $computed = $this->hasPaidSppForMonth() ? 'Lunas' : 'Belum Bayar';
        if ($this->spp_status !== $computed) {
            $this->update(['spp_status' => $computed]);
        }
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

    public function getPortalQrUrlAttribute(): string
    {
        return route('parent.portal', ['nis' => $this->nis]);
    }

    public function generatePortalQrSvg(int $size = 112): string
    {
        $svg = (string) QrCode::format('svg')
            ->size($size)
            ->margin(1)
            ->color(17, 17, 17)
            ->backgroundColor(255, 255, 255)
            ->generate($this->portal_qr_url);

        return trim((string) preg_replace('/<\?xml.*?\?>\s*/', '', $svg));
    }
}
