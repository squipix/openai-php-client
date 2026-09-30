<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Users;

final class UserResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'user_123456',
        'object' => 'organization.user',
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'role' => 'member',
        'added_at' => 1720000000,
    ];
}
