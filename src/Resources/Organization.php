<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\OrganizationContract;

final class Organization implements OrganizationContract
{
    use Concerns\Transportable;

    /**
     * Manage audit logs for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/audit-logs
     */
    public function auditLogs(): OrganizationAuditLogs
    {
        return new OrganizationAuditLogs($this->transporter);
    }

    /**
     * Manage invites for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/invites
     */
    public function invites(): OrganizationInvites
    {
        return new OrganizationInvites($this->transporter);
    }

    /**
     * Manage users in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users
     */
    public function users(): OrganizationUsers
    {
        return new OrganizationUsers($this->transporter);
    }

    /**
     * Manage projects in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects
     */
    public function projects(): OrganizationProjects
    {
        return new OrganizationProjects($this->transporter);
    }

    /**
     * Manage admin API keys for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys
     */
    public function adminApiKeys(): OrganizationAdminApiKeys
    {
        return new OrganizationAdminApiKeys($this->transporter);
    }
}
