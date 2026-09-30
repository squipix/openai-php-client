<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Invites;

final class ListInvitesResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            InviteResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'invite_123456',
        'last_id' => 'invite_123456',
        'has_more' => false,
    ];
}
