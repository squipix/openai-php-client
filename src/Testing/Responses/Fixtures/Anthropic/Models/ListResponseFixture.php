<?php

namespace OpenAI\Testing\Responses\Fixtures\Anthropic\Models;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'data' => [
            RetrieveResponseFixture::ATTRIBUTES,
        ],
        'has_more' => false,
        'first_id' => 'claude-opus-5-5',
        'last_id' => 'claude-opus-5-5',
    ];
}
