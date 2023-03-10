<?php

namespace Uiibevy\Friends\Broadcasting;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Uiibevy\Friends\Contracts\Concerns\UiiBlockContract;
use Uiibevy\Friends\Models\Block;

class BlockChannel
{
    public function join(UiiBlockContract|Authenticatable|Model $user, Block $block): bool
    {
        return $block->blocked->is($user) || $block->blocker->is($user);
    }
}
