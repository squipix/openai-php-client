<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Organization\AuditLogs\ListAuditLogsResponse;

interface OrganizationAuditLogsContract
{
    /**
     * List user actions and configuration changes within your organization.
     *
     * @see https://platform.openai.com/docs/api-reference/audit-logs/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListAuditLogsResponse;
}
