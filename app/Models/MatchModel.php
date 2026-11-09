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

    /**
     * Get the 11 starting players (backward-compatible with legacy records without 'role').
     *
     * @return array<int, array<string, mixed>>
     */
    public function getStartersAttribute(): array
    {
        $all = is_array($this->lineup_json) ? array_values($this->lineup_json) : [];
        if ($all === []) {
            return [];
        }

        $hasExplicitRoles = collect($all)->contains(fn ($item) => is_array($item) && isset($item['role']));
        if (!$hasExplicitRoles) {
            return array_slice($all, 0, 11);
        }

        return array_values(array_filter(
            $all,
            fn ($item) => is_array($item) && ($item['role'] ?? 'starter') === 'starter'
        ));
    }

    /**
     * Get substitute players listed for the match.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSubstitutesAttribute(): array
    {
        $all = is_array($this->lineup_json) ? array_values($this->lineup_json) : [];
        if ($all === []) {
            return [];
        }

        $hasExplicitRoles = collect($all)->contains(fn ($item) => is_array($item) && isset($item['role']));
        if (!$hasExplicitRoles) {
            return array_slice($all, 11);
        }

        return array_values(array_filter(
            $all,
            fn ($item) => is_array($item) && ($item['role'] ?? '') === 'substitute'
        ));
    }
}
