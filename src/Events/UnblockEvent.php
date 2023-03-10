<?php

namespace Uiibevy\Friends\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Uiibevy\Friends\Broadcasting\UnblockChannel;
use Uiibevy\Friends\Contracts\Concerns\UiiBlockContract;
use Uiibevy\Friends\Models\Block;

class UnblockEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Block $block;
    private UiiBlockContract|Authenticatable|Model $blocker;
    private UiiBlockContract|Authenticatable|Model $blocked;

    public function __construct(Block $block)
    {
        $this->block = $block;
        $this->blocker = $block->blocker;
        $this->blocked = $block->blocked;
    }

    public function broadcastOn(): array
    {
        return [
            new UnblockChannel(),
        ];
    }
}
