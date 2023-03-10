<?php

return [
    "user_model" => "App\Models\User",
    "systems" => [
        "driver" => env("FRIENDS_DRIVER", "default"),
        "default" => [
            "services" => [
                "subscriptions" => \Uiibevy\Friends\Services\SubscriptionService::class,
                "friendships" => \Uiibevy\Friends\Services\FriendshipService::class,
                "followership" => \Uiibevy\Friends\Services\FollowerService::class,
                "messaging" => \Uiibevy\Friends\Services\MessageService::class,
                "emotions" => \Uiibevy\Friends\Services\EmotionService::class,
                "comments" => \Uiibevy\Friends\Services\CommentService::class,
                "blocking" => \Uiibevy\Friends\Services\BlockService::class,
                "views" => \Uiibevy\Friends\Services\ViewService::class,
            ],
            "block" => [
                "status" => true,
                "model" => \Uiibevy\Friends\Models\Block::class,
                "events" => [
                    "block" => \Uiibevy\Friends\Events\BlockEvent::class,
                    "unblock" => \Uiibevy\Friends\Events\UnblockEvent::class,
                ],
                "event_channels" => [
                    "block" => \Uiibevy\Friends\Broadcasting\BlockChannel::class,
                    "unblock" => \Uiibevy\Friends\Broadcasting\UnblockChannel::class,
                ],
            ],
            "friendship" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\Friendship",
                "events" => [
                    "add" => "Uiibevy\Friends\Events\AddFriendshipEvent",
                    "remove" => "Uiibevy\Friends\Events\RemoveFriendshipEvent",
                ],
            ],
            "followership" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\Follower",
                "events" => [
                    "follow" => "Uiibevy\Friends\Events\FollowEvent",
                    "unfollow" => "Uiibevy\Friends\Events\UnfollowEvent",
                ],
            ],
            "subscription" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\Subscription",
                "events" => [
                    "subscribe" => "Uiibevy\Friends\Events\SubscribeEvent",
                    "unsubscribe" => "Uiibevy\Friends\Events\UnsubscribeEvent",
                ],
            ],
            "emotion" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\Emotion",
                "events" => [
                    "add" => "Uiibevy\Friends\Events\AddEmotionEvent",
                    "remove" => "Uiibevy\Friends\Events\RemoveEmotionEvent",
                ],
            ],
            "comment" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\Comment",
                "events" => [
                    "comment" => "Uiibevy\Friends\Events\AddCommentEvent",
                    "uncomment" => "Uiibevy\Friends\Events\RemoveCommentEvent",
                ],
            ],
            "view" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\View",
                "events" => [
                    "add" => "Uiibevy\Friends\Events\AddViewEvent",
                    "remove" => "Uiibevy\Friends\Events\RemoveViewEvent",
                ],
            ],
            "message" => [
                "status" => true,
                "model" => "Uiibevy\Friends\Models\Message",
                "events" => [
                    "message" => "Uiibevy\Friends\Events\MessageEvent",
                    "read" => "Uiibevy\Friends\Events\MessageReadEvent",
                    "received" => "Uiibevy\Friends\Events\MessageReceivedEvent",
                    "sent" => "Uiibevy\Friends\Events\MessageSentEvent",
                    "deleted" => "Uiibevy\Friends\Events\MessageDeletedEvent",
                    "archived" => "Uiibevy\Friends\Events\MessageArchivedEvent",
                    "starred" => "Uiibevy\Friends\Events\MessageStarredEvent",
                    "pinned" => "Uiibevy\Friends\Events\MessagePinnedEvent",
                    "shared" => "Uiibevy\Friends\Events\MessageSharedEvent",
                    "replied" => "Uiibevy\Friends\Events\MessageRepliedEvent",
                    "forwarded" => "Uiibevy\Friends\Events\MessageForwardedEvent",
                ],
            ],
        ],
    ],
];
