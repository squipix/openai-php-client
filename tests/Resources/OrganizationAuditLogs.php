<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Organization\AuditLogs\AuditLogResponse;
use OpenAI\Responses\Organization\AuditLogs\ListAuditLogsResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('list audit logs', function () {
    $client = mockClient(
        'GET',
        'organization/audit_logs',
        [],
        Response::from(auditLogListResource(), metaHeaders())
    );

    $result = $client->organization()->auditLogs()->list();

    expect($result)
        ->toBeInstanceOf(ListAuditLogsResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(AuditLogResponse::class);

    expect($result->data[0])
        ->id->toBe('audit_log_123456')
        ->type->toBe('api_key.created')
        ->effectiveAt->toBe(1720000000)
        ->actor->toBeArray()
        ->apiKey->toBeArray();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
