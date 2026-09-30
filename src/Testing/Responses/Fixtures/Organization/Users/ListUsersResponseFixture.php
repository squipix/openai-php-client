<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Users;

final class ListUsersResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            UserResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'user_123456',
        'last_id' => 'user_123456',
        'has_more' => false,
    ];
}
