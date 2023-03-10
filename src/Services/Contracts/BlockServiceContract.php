<?php

namespace Uiibevy\Friends\Services\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Uiibevy\Friends\Contracts\BlockContract;
use Uiibevy\Friends\Contracts\Concerns\UiiBlockContract;
use Uiibevy\Friends\Models\Block;

interface BlockServiceContract extends ServiceContract
{
    public function getQuery(): Builder|BlockContract;

    public function block(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $at = null, bool $quiet = false): ?Block;

    public function unblock(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, bool $quiet = false): ?Block;

    public function hasBlocked(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null): bool;

    public function hasBlockedBefore(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $at = null): bool;

    public function hasBlockedAfter(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $at = null): bool;

    public function hasBlockedBetween(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $from = null, Carbon $to = null): bool;

    public function isBlockedBy(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null): bool;

    public function isBlockedByBefore(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $at = null): bool;

    public function isBlockedByAfter(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $at = null): bool;

    public function isBlockedByBetween(UiiBlockContract|Model $user, UiiBlockContract|Model $blocker = null, Carbon $from = null, Carbon $to = null): bool;

    public function someoneBlocked(UiiBlockContract|Model $user = null): bool;

    public function someoneBlockedBefore(UiiBlockContract|Model $user = null, Carbon $at = null): bool;

    public function someoneBlockedAfter(UiiBlockContract|Model $user = null, Carbon $at = null): bool;

    public function someoneBlockedBetween(UiiBlockContract|Model $user = null, Carbon $from = null, Carbon $to = null): bool;

    public function getBlockedUsersCount(UiiBlockContract|Model $blocker = null): int;

    public function getBlockersCount(UiiBlockContract|Model $user = null): int;

    public function getBlockedUsersCountBefore(UiiBlockContract|Model $blocker = null, Carbon $at = null): int;

    public function getBlockersCountBefore(UiiBlockContract|Model $user = null, Carbon $at = null): int;

    public function getBlockedUsersCountAfter(UiiBlockContract|Model $blocker = null, Carbon $at = null): int;

    public function getBlockersCountAfter(UiiBlockContract|Model $user = null, Carbon $at = null): int;

    public function getBlockedUsersCountBetween(UiiBlockContract|Model $blocker = null, Carbon $from = null, Carbon $to = null): int;

    public function getBlockersCountBetween(UiiBlockContract|Model $user = null, Carbon $from = null, Carbon $to = null): int;

    public function getBlockedUsers(UiiBlockContract|Model $blocker = null): Builder|BlockContract;

    public function getBlockers(UiiBlockContract|Model $user = null): Builder|BlockContract;

    public function getBlockedUsersBefore(UiiBlockContract|Model $blocker = null, Carbon $at = null): Builder|BlockContract;

    public function getBlockersBefore(UiiBlockContract|Model $user = null, Carbon $at = null): Builder|BlockContract;

    public function getBlockedUsersAfter(UiiBlockContract|Model $blocker = null, Carbon $at = null): Builder|BlockContract;

    public function getBlockersAfter(UiiBlockContract|Model $user = null, Carbon $at = null): Builder|BlockContract;

    public function getBlockedUsersBetween(UiiBlockContract|Model $blocker = null, Carbon $from = null, Carbon $to = null): Builder|BlockContract;

    public function getBlockersBetween(UiiBlockContract|Model $user = null, Carbon $from = null, Carbon $to = null): Builder|BlockContract;
}
