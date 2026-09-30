<?php

namespace OpenAI\Testing\Responses\Fixtures\Chatkit\Threads;

final class ThreadItemResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'item_123456',
        'object' => 'chatkit.thread_user_message_item',
        'created_at' => 1720000000,
        'type' => 'user_message',
        'content' => 'Hello, I need help with my account.',
    ];
}
