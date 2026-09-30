<?php

namespace OpenAI\Testing\Responses\Fixtures\Chatkit\Threads;

final class ListThreadsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            ThreadResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'chatkit_th_123456',
        'last_id' => 'chatkit_th_123456',
        'has_more' => false,
    ];
}
