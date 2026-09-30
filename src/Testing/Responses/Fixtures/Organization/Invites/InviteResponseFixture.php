<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Invites;

final class InviteResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'invite_123456',
        'object' => 'organization.invite',
        'email' => 'developer@example.com',
        'role' => 'member',
        'status' => 'pending',
        'invited_at' => 1720000000,
        'expires_at' => 1722592000,
        'accepted_at' => null,
        'projects' => [
            ['id' => 'proj_123', 'role' => 'member'],
        ],
    ];
}
