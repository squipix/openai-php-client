<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\AuditLogs;

final class ListAuditLogsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            AuditLogResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'audit_log_123456',
        'last_id' => 'audit_log_123456',
        'has_more' => false,
    ];
}
