<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\AdminApiKeys;

final class ListAdminApiKeysResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            AdminApiKeyResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'key_123456',
        'last_id' => 'key_123456',
        'has_more' => false,
    ];
}
