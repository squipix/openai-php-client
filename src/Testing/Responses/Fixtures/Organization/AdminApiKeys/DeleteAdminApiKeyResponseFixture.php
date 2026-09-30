<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\AdminApiKeys;

final class DeleteAdminApiKeyResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'key_123456',
        'object' => 'organization.admin_api_key.deleted',
        'deleted' => true,
    ];
}
