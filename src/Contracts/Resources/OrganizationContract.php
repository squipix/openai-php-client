<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

interface OrganizationContract
{
    /**
     * Manage audit logs for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/audit-logs
     */
    public function auditLogs(): OrganizationAuditLogsContract;

    /**
     * Manage invites for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/invites
     */
    public function invites(): OrganizationInvitesContract;

    /**
     * Manage users in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users
     */
    public function users(): OrganizationUsersContract;

    /**
     * Manage projects in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects
     */
    public function projects(): OrganizationProjectsContract;

    /**
     * Manage admin API keys for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys
     */
    public function adminApiKeys(): OrganizationAdminApiKeysContract;
}
