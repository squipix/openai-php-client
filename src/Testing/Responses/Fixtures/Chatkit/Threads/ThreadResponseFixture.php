<?php

namespace OpenAI\Testing\Responses\Fixtures\Chatkit\Threads;

final class ThreadResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'chatkit_th_123456',
        'object' => 'chatkit.thread',
        'created_at' => 1720000000,
        'title' => 'General Inquiries',
        'user' => 'user_123456',
        'status' => 'active',
    ];
}
