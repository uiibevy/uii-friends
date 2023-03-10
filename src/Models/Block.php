<?php

namespace Uiibevy\Friends\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Uiibevy\Friends\Contracts\BlockContract;

/**
 * Block model class.
 *
 * @property int          $id
 * @property int          $blocker_id
 * @property int          $blocked_id
 * @property Carbon       $blocked_at
 * @property Carbon       $unblocked_at
 * @property Carbon       $created_at
 * @property Carbon       $updated_at
 * @property Model|object $blocker
 * @property Model|object $blocked
 * @method static Builder|Block blockedIs($user)
 * @method static Builder|Block blockerIs($user)
 * @method static Builder|Block findBlock($blocker, $blocked)
 * @method static Builder|Block blockedAt($blockedAt)
 * @method static Builder|Block unblockedAt($unblockedAt)
 * @method static Builder|Block blockedBetween($from, $to)
 * @method static Builder|Block unblockedBetween($from, $to)
 * @method static Builder|Block blockedBefore($before)
 * @method static Builder|Block unblockedBefore($before)
 * @method static Builder|Block blockedAfter($after)
 * @method static Builder|Block unblockedAfter($after)
 * @method static Builder|Block blockedToday()
 * @method static Builder|Block unblockedToday()
 * @method static Builder|Block blockedYesterday()
 * @method static Builder|Block unblockedYesterday()
 * @method static Builder|Block blockedThisWeek()
 * @method static Builder|Block unblockedThisWeek()
 * @method static Builder|Block blockedThisMonth()
 * @method static Builder|Block unblockedThisMonth()
 * @method static Builder|Block blockedThisYear()
 * @method static Builder|Block unblockedThisYear()
 * @method static Builder|Block blockedLastWeek()
 * @method static Builder|Block unblockedLastWeek()
 * @method static Builder|Block blockedLastMonth()
 * @method static Builder|Block unblockedLastMonth()
 * @method static Builder|Block blockedLastYear()
 * @method static Builder|Block unblockedLastYear()
 * @method static Builder|Block blockedIn($from, $to)
 * @method static Builder|Block unblockedIn($from, $to)
 * @method static Builder|Block blockedInMonth($month, $year = null)
 * @method static Builder|Block unblockedInMonth($month, $year = null)
 * @method static Builder|Block blockedInYear($year)
 * @method static Builder|Block unblockedInYear($year)
 * @method static Builder|Block blockedInQuarter($year = null)
 * @method static Builder|Block unblockedInQuarter($year = null)
 * @method static Builder|Block blockedInWeek($week, $year = null)
 * @method static Builder|Block unblockedInWeek($week, $year = null)
 * @method static Builder|Block blockedInDay($day, $month, $year = null)
 * @method static Builder|Block unblockedInDay($day, $month, $year = null)
 * @method static Builder|Block blockedInDays($days)
 * @method static Builder|Block unblockedInDays($days)
 * @method static Builder|Block blockedInWeeks($weeks)
 * @method static Builder|Block unblockedInWeeks($weeks)
 * @method static Builder|Block blockedInMonths($months)
 * @method static Builder|Block unblockedInMonths($months)
 * @method static Builder|Block blockedInYears($years)
 * @method static Builder|Block unblockedInYears($years)
 */
class Block extends Model implements BlockContract
{
    protected $fillable = [
        'blocker_id',
        'blocked_id',
        'blocked_at',
        'unblocked_at',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
        'unblocked_at' => 'datetime',
    ];

    public static function of($blocker, $blocked): self
    {
        return new static([
            'blocker_id' => $blocker instanceof Model ? $blocker->getKey() : $blocker,
            'blocked_id' => $blocked instanceof Model ? $blocked->getKey() : $blocked,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blocker(): BelongsTo
    {
        return $this->belongsTo(config('friends.user_model'), 'blocker_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blocked(): BelongsTo
    {
        return $this->belongsTo(config('friends.user_model'), 'blocked_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlockedIs(Builder $query, $user): Builder
    {
        return $query->where('blocked_id', $user->getKey());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlockerIs(Builder $query, $user): Builder
    {
        return $query->where('blocker_id', $user->getKey());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $blocker
     * @param                                       $blocked
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindBlock(Builder $query, $blocker, $blocked): Builder
    {
        return $query->where('blocker_id', $blocker->getKey())
            ->where('blocked_id', $blocked->getKey());
    }

    public function scopeBlockedAt(Builder $query, $blockedAt): Builder
    {
        return $query->where('blocked_at', $blockedAt);
    }

    public function scopeUnblockedAt(Builder $query, $unblockedAt): Builder
    {
        return $query->where('unblocked_at', $unblockedAt);
    }

    public function scopeBlockedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('blocked_at', [ $from, $to ]);
    }

    public function scopeUnblockedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('unblocked_at', [ $from, $to ]);
    }

    public function scopeBlockedBefore(Builder $query, $before): Builder
    {
        return $query->where('blocked_at', '<', $before);
    }

    public function scopeUnblockedBefore(Builder $query, $before): Builder
    {
        return $query->where('unblocked_at', '<', $before);
    }

    public function scopeBlockedAfter(Builder $query, $after): Builder
    {
        return $query->where('blocked_at', '>', $after);
    }

    public function scopeUnblockedAfter(Builder $query, $after): Builder
    {
        return $query->where('unblocked_at', '>', $after);
    }

    public function scopeBlockedToday(Builder $query): Builder
    {
        return $query->whereDate('blocked_at', now());
    }

    public function scopeUnblockedToday(Builder $query): Builder
    {
        return $query->whereDate('unblocked_at', now());
    }

    public function scopeBlockedYesterday(Builder $query): Builder
    {
        return $query->whereDate('blocked_at', now()->subDay());
    }

    public function scopeUnblockedYesterday(Builder $query): Builder
    {
        return $query->whereDate('unblocked_at', now()->subDay());
    }

    public function scopeBlockedThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->startOfWeek(), now()->endOfWeek() ]);
    }

    public function scopeUnblockedThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->startOfWeek(), now()->endOfWeek() ]);
    }

    public function scopeBlockedThisMonth(Builder $query): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->startOfMonth(), now()->endOfMonth() ]);
    }

    public function scopeUnblockedThisMonth(Builder $query): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->startOfMonth(), now()->endOfMonth() ]);
    }

    public function scopeBlockedThisYear(Builder $query): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->startOfYear(), now()->endOfYear() ]);
    }

    public function scopeUnblockedThisYear(Builder $query): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->startOfYear(), now()->endOfYear() ]);
    }

    public function scopeBlockedLastWeek(Builder $query): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek() ]);
    }

    public function scopeUnblockedLastWeek(Builder $query): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek() ]);
    }

    public function scopeBlockedLastMonth(Builder $query): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth() ]);
    }

    public function scopeUnblockedLastMonth(Builder $query): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth() ]);
    }

    public function scopeBlockedLastYear(Builder $query): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subYear()->startOfYear(), now()->subYear()->endOfYear() ]);
    }

    public function scopeUnblockedLastYear(Builder $query): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subYear()->startOfYear(), now()->subYear()->endOfYear() ]);
    }

    public function scopeBlockedIn(Builder $query, $year, $month = null, $day = null): Builder
    {
        if ($day) {
            return $query->whereDate('blocked_at', Carbon::create($year, $month, $day));
        }

        if ($month) {
            return $query->whereMonth('blocked_at', $month)->whereYear('blocked_at', $year);
        }

        return $query->whereYear('blocked_at', $year);
    }

    public function scopeUnblockedIn(Builder $query, $year, $month = null, $day = null): Builder
    {
        if ($day) {
            return $query->whereDate('unblocked_at', Carbon::create($year, $month, $day));
        }

        if ($month) {
            return $query->whereMonth('unblocked_at', $month)->whereYear('unblocked_at', $year);
        }

        return $query->whereYear('unblocked_at', $year);
    }

    public function scopeBlockedInMonth(Builder $query, $month, $year = null): Builder
    {
        return $query->whereMonth('blocked_at', $month)->whereYear('blocked_at', $year ?? now()->year);
    }

    public function scopeUnblockedInMonth(Builder $query, $month, $year = null): Builder
    {
        return $query->whereMonth('unblocked_at', $month)->whereYear('unblocked_at', $year ?? now()->year);
    }

    public function scopeBlockedInYear(Builder $query, $year): Builder
    {
        return $query->whereYear('blocked_at', $year);
    }

    public function scopeUnblockedInYear(Builder $query, $year): Builder
    {
        return $query->whereYear('unblocked_at', $year);
    }

    public function scopeBlockedInDay(Builder $query, $day, $month = null, $year = null): Builder
    {
        return $query->whereDate('blocked_at', Carbon::create($year ?? now()->year, $month ?? now()->month, $day));
    }

    public function scopeUnblockedInDay(Builder $query, $day, $month = null, $year = null): Builder
    {
        return $query->whereDate('unblocked_at', Carbon::create($year ?? now()->year, $month ?? now()->month, $day));
    }

    public function scopeBlockedInWeek(Builder $query, $week, $year = null): Builder
    {
        return $query->whereBetween('blocked_at', [ Carbon::create($year ?? now()->year)->startOfWeek()->addWeeks($week - 1), Carbon::create($year ?? now()->year)->endOfWeek()->addWeeks($week - 1) ]);
    }

    public function scopeUnblockedInWeek(Builder $query, $week, $year = null): Builder
    {
        return $query->whereBetween('unblocked_at', [ Carbon::create($year ?? now()->year)->startOfWeek()->addWeeks($week - 1), Carbon::create($year ?? now()->year)->endOfWeek()->addWeeks($week - 1) ]);
    }

    public function scopeBlockedInQuarter(Builder $query, $year = null): Builder
    {
        return $query->whereBetween('blocked_at', [ Carbon::create($year ?? now()->year)->startOfQuarter(), Carbon::create($year ?? now()->year)->endOfQuarter() ]);
    }

    public function scopeUnblockedInQuarter(Builder $query, $year = null): Builder
    {
        return $query->whereBetween('unblocked_at', [ Carbon::create($year ?? now()->year)->startOfQuarter(), Carbon::create($year ?? now()->year)->endOfQuarter() ]);
    }

    public function scopeBlockedInDays(Builder $query, $days): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subDays($days), now() ]);
    }

    public function scopeUnblockedInDays(Builder $query, $days): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subDays($days), now() ]);
    }

    public function scopeBlockedInWeeks(Builder $query, $weeks): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subWeeks($weeks), now() ]);
    }

    public function scopeUnblockedInWeeks(Builder $query, $weeks): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subWeeks($weeks), now() ]);
    }

    public function scopeBlockedInMonths(Builder $query, $months): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subMonths($months), now() ]);
    }

    public function scopeUnblockedInMonths(Builder $query, $months): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subMonths($months), now() ]);
    }

    public function scopeBlockedInYears(Builder $query, $years): Builder
    {
        return $query->whereBetween('blocked_at', [ now()->subYears($years), now() ]);
    }

    public function scopeUnblockedInYears(Builder $query, $years): Builder
    {
        return $query->whereBetween('unblocked_at', [ now()->subYears($years), now() ]);
    }
}
