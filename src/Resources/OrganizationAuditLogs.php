<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\OrganizationAuditLogsContract;
use OpenAI\Responses\Organization\AuditLogs\ListAuditLogsResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ListAuditLogsResponseType from ListAuditLogsResponse
 */
final class OrganizationAuditLogs implements OrganizationAuditLogsContract
{
    use Concerns\Transportable;

    /**
     * List user actions and configuration changes within your organization.
     *
     * @see https://platform.openai.com/docs/api-reference/audit-logs/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListAuditLogsResponse
    {
        $payload = Payload::list('organization/audit_logs', $parameters);

        /** @var Response<ListAuditLogsResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListAuditLogsResponse::from($response->data(), $response->meta());
    }
}
