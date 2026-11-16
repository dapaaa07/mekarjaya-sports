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

    public function matchEvaluations()
    {
        return $this->hasMany(Evaluation::class)->whereNotNull('match_id')->with('match');
    }

    public function latestEvaluation()
    {
        return $this->hasOne(Evaluation::class)->latestOfMany(['evaluation_date', 'id']);
    }

    public function getAccumulatedStatsAttribute(): Evaluation
    {
        $matchEvals = $this->evaluations()->whereNotNull('match_id')->get();
        if ($matchEvals->isNotEmpty()) {
            $count = $matchEvals->count();
            $eval = new Evaluation([
                'player_id' => $this->id,
                'evaluation_date' => $matchEvals->max('evaluation_date'),
                'passing_score' => (int) round($matchEvals->avg('passing_score')),
                'dribbling_score' => (int) round($matchEvals->avg('dribbling_score')),
                'shooting_score' => (int) round($matchEvals->avg('shooting_score')),
                'physical_score' => (int) round($matchEvals->avg('physical_score')),
                'discipline_score' => (int) round($matchEvals->avg('discipline_score')),
                'tactical_score' => (int) round($matchEvals->avg('tactical_score')),
                'coach_notes' => $matchEvals->sortByDesc('evaluation_date')->first()?->coach_notes,
            ]);
            $eval->matches_count = $count;
            $eval->is_accumulated = true;

            return $eval;
        }

        $latest = $this->latestEvaluation;
        if ($latest) {
            $latest->matches_count = 0;
            $latest->is_accumulated = false;

            return $latest;
        }

        $default = new Evaluation([
            'player_id' => $this->id,
            'evaluation_date' => now()->toDateString(),
            'passing_score' => 75,
            'dribbling_score' => 75,
            'shooting_score' => 75,
            'physical_score' => 75,
            'discipline_score' => 80,
            'tactical_score' => 70,
            'coach_notes' => 'Belum ada penilaian pertandingan.',
        ]);
        $default->matches_count = 0;
        $default->is_accumulated = false;

        return $default;
    }

    public function getAccumulatedEvaluationAttribute(): Evaluation
    {
        return $this->accumulated_stats;
    }

    public function getMatchHistoryAttribute(): \Illuminate\Support\Collection
    {
        $matchEvaluations = $this->evaluations()
            ->whereNotNull('match_id')
            ->with('match')
            ->orderBy('evaluation_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $evaluatedMatchIds = $matchEvaluations->pluck('match_id')->filter()->all();

        $allMatchesWithLineup = MatchModel::orderBy('match_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->filter(function (MatchModel $match) {
                $lineup = is_array($match->lineup_json) ? $match->lineup_json : [];
                return collect($lineup)->contains(fn ($slot) => is_array($slot) && (int) ($slot['player_id'] ?? 0) === (int) $this->id);
            });

        $matchesById = $allMatchesWithLineup->keyBy('id');
        $result = collect();

        foreach ($matchEvaluations as $ev) {
            $match = $ev->match ?? $matchesById->get($ev->match_id);
            $lineupSlot = null;
            if ($match && is_array($match->lineup_json)) {
                $lineupSlot = collect($match->lineup_json)->first(
                    fn ($s) => is_array($s) && (int) ($s['player_id'] ?? 0) === (int) $this->id
                );
            }

            $isMotm = false;
            if ($match && !empty($match->man_of_the_match)) {
                $isMotm = (trim(strtolower($match->man_of_the_match)) === trim(strtolower($this->full_name)))
                    || (str_contains(strtolower($match->man_of_the_match), strtolower($this->full_name)));
            }

            $result->push((object) [
                'match' => $match,
                'evaluation' => $ev,
                'match_date' => $ev->evaluation_date ?? $match?->match_date,
                'has_evaluation' => true,
                'lineup' => $lineupSlot,
                'role' => $lineupSlot['role'] ?? 'starter',
                'position' => $lineupSlot['position'] ?? $this->position,
                'is_motm' => $isMotm,
                'passing_score' => $ev->passing_score,
                'dribbling_score' => $ev->dribbling_score,
                'shooting_score' => $ev->shooting_score,
                'physical_score' => $ev->physical_score,
                'discipline_score' => $ev->discipline_score,
                'tactical_score' => $ev->tactical_score,
                'average_score' => $ev->average_score,
                'coach_notes' => $ev->coach_notes,
            ]);
        }

        foreach ($allMatchesWithLineup as $match) {
            if (in_array($match->id, $evaluatedMatchIds, true)) {
                continue;
            }

            $lineupSlot = collect($match->lineup_json)->first(
                fn ($s) => is_array($s) && (int) ($s['player_id'] ?? 0) === (int) $this->id
            );

            $isMotm = false;
            if (!empty($match->man_of_the_match)) {
                $isMotm = (trim(strtolower($match->man_of_the_match)) === trim(strtolower($this->full_name)))
                    || (str_contains(strtolower($match->man_of_the_match), strtolower($this->full_name)));
            }

            $result->push((object) [
                'match' => $match,
                'evaluation' => null,
                'match_date' => $match->match_date,
                'has_evaluation' => false,
                'lineup' => $lineupSlot,
                'role' => $lineupSlot['role'] ?? 'starter',
                'position' => $lineupSlot['position'] ?? $this->position,
                'is_motm' => $isMotm,
                'passing_score' => null,
                'dribbling_score' => null,
                'shooting_score' => null,
                'physical_score' => null,
                'discipline_score' => null,
                'tactical_score' => null,
                'average_score' => null,
                'coach_notes' => null,
            ]);
        }

        return $result->sortByDesc(fn ($item) => $item->match_date ? $item->match_date->timestamp : 0)->values();
    }

    public function sppPayments()
    {
        return $this->hasMany(SppPayment::class)
            ->orderBy('periode_tahun', 'desc')
            ->orderBy('periode_bulan', 'desc')
            ->orderBy('id', 'desc');
    }

    public function getAgeCategoryAttribute(): ?AgeCategory
    {
        return AgeCategory::where('min_birth_year', '<=', $this->birth_year)
            ->where('max_birth_year', '>=', $this->birth_year)
            ->first();
    }

    public function getDefaultMonthlyFeeAttribute(): int
    {
        return $this->age_category ? (int) $this->age_category->monthly_fee : 150000;
    }

    public function getTotalSppPaidForMonth(?int $month = null, ?int $year = null): int
    {
        $month = $month ?? (int) now()->month;
        $year = $year ?? (int) now()->year;

        if ($this->relationLoaded('sppPayments')) {
            return (int) $this->sppPayments
                ->filter(fn (SppPayment $payment) => (int) $payment->periode_bulan === $month && (int) $payment->periode_tahun === $year)
                ->sum('jumlah');
        }

        return (int) $this->sppPayments()
            ->where('periode_bulan', $month)
            ->where('periode_tahun', $year)
            ->sum('jumlah');
    }

    public function getSppShortageForMonth(?int $month = null, ?int $year = null): int
    {
        $required = $this->default_monthly_fee;
        $paid = $this->getTotalSppPaidForMonth($month, $year);

        return max(0, $required - $paid);
    }

    public function hasPaidSppForMonth(?int $month = null, ?int $year = null): bool
    {
        $month = $month ?? (int) now()->month;
        $year = $year ?? (int) now()->year;

        return $this->getTotalSppPaidForMonth($month, $year) >= $this->default_monthly_fee;
    }

    public function getCurrentSppStatusAttribute(): string
    {
        return $this->hasPaidSppForMonth() ? 'Lunas' : 'Belum Bayar';
    }

    public function syncCurrentSppStatus(): void
    {
        $this->unsetRelation('sppPayments');
        $computed = $this->hasPaidSppForMonth() ? 'Lunas' : 'Belum Bayar';
        if ($this->spp_status !== $computed) {
            $this->update(['spp_status' => $computed]);
        }
    }

    public function getBillingStartDate(): \Carbon\Carbon
    {
        $now = now()->startOfMonth();
        $date = $this->created_at ? $this->created_at->copy()->startOfMonth() : $now->copy();

        $earliestPayment = $this->relationLoaded('sppPayments')
            ? $this->sppPayments->sortBy(fn ($p) => ($p->periode_tahun * 100) + $p->periode_bulan)->first()
            : $this->sppPayments()->orderBy('periode_tahun', 'asc')->orderBy('periode_bulan', 'asc')->first();

        if ($earliestPayment) {
            $paymentDate = \Carbon\Carbon::createFromDate($earliestPayment->periode_tahun, $earliestPayment->periode_bulan, 1)->startOfMonth();
            if ($paymentDate->lt($date)) {
                $date = $paymentDate;
            }
        }

        $maxLookback = $now->copy()->subMonths(11);
        if ($date->lt($maxLookback)) {
            $date = $maxLookback;
        }

        if ($date->gt($now)) {
            $date = $now->copy();
        }

        return $date;
    }

    public function getUnpaidSppPeriodsAttribute(): \Illuminate\Support\Collection
    {
        $unpaid = collect();
        $start = $this->getBillingStartDate();
        $current = now()->startOfMonth();

        $cursor = $start->copy();
        while ($cursor->lte($current)) {
            $m = (int) $cursor->month;
            $y = (int) $cursor->year;
            $required = $this->default_monthly_fee;
            $paid = $this->getTotalSppPaidForMonth($m, $y);

            if ($paid < $required) {
                $unpaid->push((object) [
                    'periode_bulan' => $m,
                    'periode_tahun' => $y,
                    'month_name' => SppPayment::MONTHS_ID[$m] ?? (string) $m,
                    'period_label' => (SppPayment::MONTHS_ID[$m] ?? $m) . ' ' . $y,
                    'required' => $required,
                    'paid' => $paid,
                    'shortage' => $required - $paid,
                    'is_current_month' => ($m === (int) now()->month && $y === (int) now()->year),
                    'status' => $paid > 0 ? 'Belum Lunas' : 'Belum Bayar',
                ]);
            }

            $cursor->addMonth();
        }

        return $unpaid;
    }

    public function getSppArrearsCountAttribute(): int
    {
        return $this->unpaid_spp_periods->count();
    }

    public function getTotalSppArrearsAttribute(): int
    {
        return (int) $this->unpaid_spp_periods->sum('shortage');
    }

    public function getRecentSppBillingSummary(int $limit = 6): \Illuminate\Support\Collection
    {
        $list = collect();
        $start = $this->getBillingStartDate();
        $current = now()->startOfMonth();
        $from = $start->copy();

        $cursor = $current->copy();
        $count = 0;
        while ($cursor->gte($from) && $count < $limit) {
            $m = (int) $cursor->month;
            $y = (int) $cursor->year;
            $required = $this->default_monthly_fee;
            $paid = $this->getTotalSppPaidForMonth($m, $y);
            $shortage = max(0, $required - $paid);

            $payments = $this->relationLoaded('sppPayments')
                ? $this->sppPayments->filter(fn ($p) => (int) $p->periode_bulan === $m && (int) $p->periode_tahun === $y)->values()
                : $this->sppPayments()->where('periode_bulan', $m)->where('periode_tahun', $y)->get();

            $list->push((object) [
                'periode_bulan' => $m,
                'periode_tahun' => $y,
                'month_name' => SppPayment::MONTHS_ID[$m] ?? (string) $m,
                'period_label' => (SppPayment::MONTHS_ID[$m] ?? $m) . ' ' . $y,
                'required' => $required,
                'paid' => $paid,
                'shortage' => $shortage,
                'is_lunas' => $paid >= $required,
                'is_current_month' => ($m === (int) now()->month && $y === (int) now()->year),
                'payments' => $payments,
            ]);

            $cursor->subMonth();
            $count++;
        }

        return $list;
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
