<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\AdminApiKeys;

final class AdminApiKeyResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'key_123456',
        'object' => 'organization.admin_api_key',
        'name' => 'CI Deployment Key',
        'redacted_value' => 'sk-admin-...abcd',
        'value' => 'sk-admin-1234567890abcdef',
        'created_at' => 1720000000,
        'owner' => [
            'type' => 'user',
            'user' => ['id' => 'user_123', 'email' => 'admin@example.com'],
        ],
    ];
}
