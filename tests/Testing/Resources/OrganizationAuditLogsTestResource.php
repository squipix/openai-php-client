<?php

use OpenAI\Resources\OrganizationAuditLogs;
use OpenAI\Responses\Organization\AuditLogs\ListAuditLogsResponse;
use OpenAI\Testing\ClientFake;

it('records an audit log list request', function () {
    $fake = new ClientFake([
        ListAuditLogsResponse::fake(),
    ]);

    $fake->organization()->auditLogs()->list();

    $fake->assertSent(OrganizationAuditLogs::class, function ($method) {
        return $method === 'list';
    });
});
