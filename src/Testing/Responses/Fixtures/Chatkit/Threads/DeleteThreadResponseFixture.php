<?php

namespace OpenAI\Testing\Responses\Fixtures\Chatkit\Threads;

final class DeleteThreadResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'chatkit_th_123456',
        'object' => 'chatkit.thread.deleted',
        'deleted' => true,
    ];
}
