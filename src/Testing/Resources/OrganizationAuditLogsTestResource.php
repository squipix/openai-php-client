<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\OrganizationAuditLogsContract;
use OpenAI\Resources\OrganizationAuditLogs;
use OpenAI\Responses\Organization\AuditLogs\ListAuditLogsResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class OrganizationAuditLogsTestResource implements OrganizationAuditLogsContract
{
    use Testable;

    protected function resource(): string
    {
        return OrganizationAuditLogs::class;
    }

    public function list(array $parameters = []): ListAuditLogsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
