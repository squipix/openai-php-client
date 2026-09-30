<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Users;

final class DeleteUserResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'user_123456',
        'object' => 'organization.user.deleted',
        'deleted' => true,
    ];
}
