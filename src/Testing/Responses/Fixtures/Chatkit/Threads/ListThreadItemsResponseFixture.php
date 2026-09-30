<?php

namespace OpenAI\Testing\Responses\Fixtures\Chatkit\Threads;

final class ListThreadItemsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            ThreadItemResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'item_123456',
        'last_id' => 'item_123456',
        'has_more' => false,
    ];
}
