<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\OrganizationInvitesContract;
use OpenAI\Resources\OrganizationInvites;
use OpenAI\Responses\Organization\Invites\DeleteInviteResponse;
use OpenAI\Responses\Organization\Invites\InviteResponse;
use OpenAI\Responses\Organization\Invites\ListInvitesResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class OrganizationInvitesTestResource implements OrganizationInvitesContract
{
    use Testable;

    protected function resource(): string
    {
        return OrganizationInvites::class;
    }

    public function list(array $parameters = []): ListInvitesResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function create(array $parameters): InviteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $inviteId): InviteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $inviteId): DeleteInviteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
