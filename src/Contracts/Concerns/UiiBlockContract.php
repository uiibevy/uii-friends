<?php

namespace Uiibevy\Friends\Contracts\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Uiibevy\Friends\Contracts\BlockContract;
use Uiibevy\Friends\Services\Contracts\BlockServiceContract;

interface UiiBlockContract
{
    public function uiiBlock(): BlockServiceContract;

    public function block($at = null, UiiBlockContract|Authenticatable|Model $blocker = null, $quiet = false): BlockContract;

    public function unblock(UiiBlockContract|Authenticatable|Model $blocker = null, $quiet = false): BlockContract;

    public function hasBlocked(UiiBlockContract|Authenticatable|Model $user = null): bool;

    public function hasBlockedMe(): bool;

    public function hasBlockedBefore(UiiBlockContract|Authenticatable|Model $user = null, $at = null): bool;

    public function hasBlockedMeBefore($at = null): bool;

    public function hasBlockedAfter(UiiBlockContract|Authenticatable|Model $user = null, $at = null): bool;

    public function hasBlockedMeAfter($at = null): bool;

    public function hasBlockedBetween(UiiBlockContract|Authenticatable|Model $user = null, $from = null, $to = null): bool;

    public function hasBlockedMeBetween($from = null, $to = null): bool;
}
