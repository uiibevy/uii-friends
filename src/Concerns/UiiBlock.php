<?php

namespace Uiibevy\Friends\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Uiibevy\Friends\Contracts\BlockContract;
use Uiibevy\Friends\Contracts\Concerns\UiiBlockContract;
use Uiibevy\Friends\Services\BlockService;

/**
 * @implements \Uiibevy\Friends\Contracts\Concerns\UiiBlockContract
 */
trait UiiBlock
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function block($at = null, UiiBlockContract|Authenticatable|Model $blocker = null, $quiet = false): BlockContract
    {
        return $this->uiiBlock()->block($this, $blocker ?? auth()->user(), $at, $quiet);
    }

    public function uiiBlock(): BlockService
    {
        return app(BlockService::class);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unblock(UiiBlockContract|Authenticatable|Model $blocker = null, $quiet = false): BlockContract
    {
        return $this->uiiBlock()->unblock($this, $blocker ?? auth()->user(), $quiet);
    }

    public function hasBlockedMe(): bool
    {
        return $this->uiiBlock()->hasBlocked(auth()->user(), $this);
    }

    public function hasBlocked(UiiBlockContract|Authenticatable|Model $user = null): bool
    {
        return $this->uiiBlock()->hasBlocked($user, $this);
    }

    public function hasBlockedMeBefore($at = null): bool
    {
        return $this->uiiBlock()->hasBlockedBefore(auth()->user(), $this, $at);
    }

    public function hasBlockedBefore(UiiBlockContract|Authenticatable|Model $user = null, $at = null): bool
    {
        return $this->uiiBlock()->hasBlockedBefore($user, $this, $at);
    }

    public function hasBlockedMeAfter($at = null): bool
    {
        return $this->uiiBlock()->hasBlockedAfter(auth()->user(), $this, $at);
    }

    public function hasBlockedAfter(UiiBlockContract|Authenticatable|Model $user = null, $at = null): bool
    {
        return $this->uiiBlock()->hasBlockedAfter($user, $this, $at);
    }

    public function hasBlockedMeBetween($from = null, $to = null): bool
    {
        return $this->uiiBlock()->hasBlockedBetween(auth()->user(), $this, $from, $to);
    }

    public function hasBlockedBetween(UiiBlockContract|Authenticatable|Model $user = null, $from = null, $to = null): bool
    {
        return $this->uiiBlock()->hasBlockedBetween($user, $this, $from, $to);
    }
}
