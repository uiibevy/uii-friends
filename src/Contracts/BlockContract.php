<?php

namespace Uiibevy\Friends\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Uiibevy\Friends\Core\Contract;
use Uiibevy\Friends\Models\Block;

/**
 * Interface BlockContract
 *
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
interface BlockContract extends Contract
{
    /**
     * @param $blocker
     * @param $blocked
     *
     * @return static
     */
    public static function of($blocker, $blocked): self;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blocker(): BelongsTo;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blocked(): BelongsTo;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlockedIs(Builder $query, $user): Builder;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlockerIs(Builder $query, $user): Builder;

    public function scopeFindBlock(Builder $query, $blocker, $blocked): Builder;

    public function scopeBlockedAt(Builder $query, $blockedAt): Builder;

    public function scopeUnblockedAt(Builder $query, $unblockedAt): Builder;

    public function scopeBlockedBetween(Builder $query, $from, $to): Builder;

    public function scopeUnblockedBetween(Builder $query, $from, $to): Builder;

    public function scopeBlockedBefore(Builder $query, $before): Builder;

    public function scopeUnblockedBefore(Builder $query, $before): Builder;

    public function scopeBlockedAfter(Builder $query, $after): Builder;

    public function scopeUnblockedAfter(Builder $query, $after): Builder;

    public function scopeBlockedToday(Builder $query): Builder;

    public function scopeUnblockedToday(Builder $query): Builder;

    public function scopeBlockedYesterday(Builder $query): Builder;

    public function scopeUnblockedYesterday(Builder $query): Builder;

    public function scopeBlockedThisWeek(Builder $query): Builder;

    public function scopeUnblockedThisWeek(Builder $query): Builder;

    public function scopeBlockedLastWeek(Builder $query): Builder;

    public function scopeUnblockedLastWeek(Builder $query): Builder;

    public function scopeBlockedThisMonth(Builder $query): Builder;

    public function scopeUnblockedThisMonth(Builder $query): Builder;

    public function scopeBlockedLastMonth(Builder $query): Builder;

    public function scopeUnblockedLastMonth(Builder $query): Builder;

    public function scopeBlockedThisYear(Builder $query): Builder;

    public function scopeUnblockedThisYear(Builder $query): Builder;

    public function scopeBlockedLastYear(Builder $query): Builder;

    public function scopeUnblockedLastYear(Builder $query): Builder;

    public function scopeBlockedIn(Builder $query, $year, $month = null, $day = null): Builder;

    public function scopeUnblockedIn(Builder $query, $year, $month = null, $day = null): Builder;

    public function scopeBlockedInMonth(Builder $query, $month, $year = null): Builder;

    public function scopeUnblockedInMonth(Builder $query, $month, $year = null): Builder;

    public function scopeBlockedInYear(Builder $query, $year): Builder;

    public function scopeUnblockedInYear(Builder $query, $year): Builder;

    public function scopeBlockedInQuarter(Builder $query, $year = null): Builder;

    public function scopeUnblockedInQuarter(Builder $query, $year = null): Builder;

    public function scopeBlockedInWeek(Builder $query, $week, $year = null): Builder;

    public function scopeUnblockedInWeek(Builder $query, $week, $year = null): Builder;

    public function scopeBlockedInDay(Builder $query, $day, $month = null, $year = null): Builder;

    public function scopeUnblockedInDay(Builder $query, $day, $month = null, $year = null): Builder;

    public function scopeBlockedInDays(Builder $query, $days): Builder;

    public function scopeUnblockedInDays(Builder $query, $days): Builder;

    public function scopeBlockedInWeeks(Builder $query, $weeks): Builder;

    public function scopeUnblockedInWeeks(Builder $query, $weeks): Builder;

    public function scopeBlockedInMonths(Builder $query, $months): Builder;

    public function scopeUnblockedInMonths(Builder $query, $months): Builder;

    public function scopeBlockedInYears(Builder $query, $years): Builder;

    public function scopeUnblockedInYears(Builder $query, $years): Builder;
}
