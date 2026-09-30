<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\AuditLogs;

final class AuditLogResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'audit_log_123456',
        'type' => 'api_key.created',
        'effective_at' => 1720000000,
        'actor' => [
            'type' => 'user',
            'user' => ['id' => 'user_123', 'email' => 'admin@example.com'],
        ],
        'api_key' => [
            'id' => 'key_123',
            'type' => 'user',
        ],
    ];
}
