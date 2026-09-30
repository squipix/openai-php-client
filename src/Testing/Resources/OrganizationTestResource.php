<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\OrganizationContract;
use OpenAI\Resources\Organization;
use OpenAI\Testing\Resources\Concerns\Testable;

final class OrganizationTestResource implements OrganizationContract
{
    use Testable;

    protected function resource(): string
    {
        return Organization::class;
    }

    public function auditLogs(): OrganizationAuditLogsTestResource
    {
        return new OrganizationAuditLogsTestResource($this->fake);
    }

    public function invites(): OrganizationInvitesTestResource
    {
        return new OrganizationInvitesTestResource($this->fake);
    }

    public function users(): OrganizationUsersTestResource
    {
        return new OrganizationUsersTestResource($this->fake);
    }

    public function projects(): OrganizationProjectsTestResource
    {
        return new OrganizationProjectsTestResource($this->fake);
    }

    public function adminApiKeys(): OrganizationAdminApiKeysTestResource
    {
        return new OrganizationAdminApiKeysTestResource($this->fake);
    }
}
