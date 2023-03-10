<?php

namespace Uiibevy\Friends\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Uiibevy\Friends\Contracts\BlockContract;
use Uiibevy\Friends\Contracts\Concerns\UiiBlockContract;
use Uiibevy\Friends\Core\Service;
use Uiibevy\Friends\Models\Block;
use Uiibevy\Friends\Services\Contracts\BlockServiceContract;

class BlockService extends Service implements BlockServiceContract
{
    public function __construct(string $service = null)
    {
        parent::__construct($service);
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     * @param bool                                                                                                                                     $quiet
     *
     * @return \Uiibevy\Friends\Models\Block|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function block(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null, bool $quiet = false): ?Block
    {
        $this->authorize('block', [ $user, $blocker ]);
        $blocker = $blocker ?? auth()->user();
        $block = $this->getQuery()->blockerIs($blocker)->blockedIs($user)->blockedBefore(now())->first();
        if (!is_null($block)) return $block;
        if (!$quiet) $this->fireEvent('block', $block);
        return $this->getQuery()->create([
            'blocker_id' => $blocker->getKey(),
            'blocked_id' => $user->getKey(),
            'blocked_at' => $at ?? now(),
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getQuery(): Builder|BlockContract
    {
        return parent::getQuery();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param bool                                                                                                                                     $quiet
     *
     * @return \Uiibevy\Friends\Models\Block|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unblock(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, bool $quiet = false): ?Block
    {
        $this->authorize('unblock', [ $user, $blocker ]);
        $blocker = $blocker ?? auth()->user();
        $block = $this->getQuery()->blockerIs($blocker)->blockedIs($user)->blockedBefore(now())->first();
        if (!$block) return null;
        if (!$quiet) $this->fireEvent('unblock', $block);
        $block->delete();
        return $block;
    }


    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     *
     * @return bool
     */
    public function hasBlocked(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedIs($user)->blockedBefore(now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return bool
     */
    public function hasBlockedBefore(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedIs($user)->blockedBefore($at ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return bool
     */
    public function hasBlockedAfter(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedIs($user)->blockedAfter($at ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return bool
     */
    public function hasBlockedBetween(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $from = null, Carbon $to = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedIs($user)->blockedBetween($from ?? now(), $to ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     *
     * @return bool
     */
    public function isBlockedBy(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($user)->blockedIs($blocker)->blockedBefore(now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return bool
     */
    public function isBlockedByBefore(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($user)->blockedIs($blocker)->blockedBefore($at ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return bool
     */
    public function isBlockedByAfter(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($user)->blockedIs($blocker)->blockedAfter($at ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model      $user
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return bool
     */
    public function isBlockedByBetween(UiiBlockContract|Authenticatable|Model $user, UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $from = null, Carbon $to = null): bool
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($user)->blockedIs($blocker)->blockedBetween($from ?? now(), $to ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     *
     * @return bool
     */
    public function someoneBlocked(UiiBlockContract|Authenticatable|Model $user = null): bool
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBefore(now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return bool
     */
    public function someoneBlockedBefore(UiiBlockContract|Authenticatable|Model $user = null, Carbon $at = null): bool
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBefore($at ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return bool
     */
    public function someoneBlockedAfter(UiiBlockContract|Authenticatable|Model $user = null, Carbon $at = null): bool
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedAfter($at ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return bool
     */
    public function someoneBlockedBetween(UiiBlockContract|Authenticatable|Model $user = null, Carbon $from = null, Carbon $to = null): bool
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBetween($from ?? now(), $to ?? now())->exists();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     *
     * @return int
     */
    public function getBlockedUsersCount(UiiBlockContract|Authenticatable|Model $blocker = null): int
    {
        return $this->getBlockedUsersCountBefore($blocker, now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return int
     */
    public function getBlockedUsersCountBefore(UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): int
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedBefore($at ?? now())->count();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     *
     * @return int
     */
    public function getBlockersCount(UiiBlockContract|Authenticatable|Model $user = null): int
    {
        return $this->getBlockersCountBefore($user, now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return int
     */
    public function getBlockersCountBefore(UiiBlockContract|Authenticatable|Model $user = null, Carbon $at = null): int
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBefore($at ?? now())->count();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return int
     */
    public function getBlockedUsersCountAfter(UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): int
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedAfter($at ?? now())->count();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return int
     */
    public function getBlockersCountAfter(UiiBlockContract|Authenticatable|Model $user = null, Carbon $at = null): int
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedAfter($at ?? now())->count();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return int
     */
    public function getBlockedUsersCountBetween(UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $from = null, Carbon $to = null): int
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedBetween($from ?? now(), $to ?? now())->count();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return int
     */
    public function getBlockersCountBetween(UiiBlockContract|Authenticatable|Model $user = null, Carbon $from = null, Carbon $to = null): int
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBetween($from ?? now(), $to ?? now())->count();
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockedUsers(UiiBlockContract|Authenticatable|Model $blocker = null): Builder|BlockContract
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedBefore(now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockers(UiiBlockContract|Authenticatable|Model $user = null): Builder|BlockContract
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBefore(now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockedUsersBefore(UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): Builder|BlockContract
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedBefore($at ?? now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockersBefore(UiiBlockContract|Authenticatable|Model $user = null, Carbon $at = null): Builder|BlockContract
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBefore($at ?? now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockedUsersAfter(UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $at = null): Builder|BlockContract
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedAfter($at ?? now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $at
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockersAfter(UiiBlockContract|Authenticatable|Model $user = null, Carbon $at = null): Builder|BlockContract
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedAfter($at ?? now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $blocker
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockedUsersBetween(UiiBlockContract|Authenticatable|Model $blocker = null, Carbon $from = null, Carbon $to = null): Builder|BlockContract
    {
        $blocker = $blocker ?? auth()->user();
        return $this->getQuery()->blockerIs($blocker)->blockedBetween($from ?? now(), $to ?? now());
    }

    /**
     * @param \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null $user
     * @param \Illuminate\Support\Carbon|null                                                                                                          $from
     * @param \Illuminate\Support\Carbon|null                                                                                                          $to
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Uiibevy\Friends\Contracts\BlockContract
     */
    public function getBlockersBetween(UiiBlockContract|Authenticatable|Model $user = null, Carbon $from = null, Carbon $to = null): Builder|BlockContract
    {
        $user = $user ?? auth()->user();
        return $this->getQuery()->blockedIs($user)->blockedBetween($from ?? now(), $to ?? now());
    }
}
