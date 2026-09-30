<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Invites;

final class DeleteInviteResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'invite_123456',
        'object' => 'organization.invite.deleted',
        'deleted' => true,
    ];
}
