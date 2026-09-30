<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Organization\Invites\DeleteInviteResponse;
use OpenAI\Responses\Organization\Invites\InviteResponse;
use OpenAI\Responses\Organization\Invites\ListInvitesResponse;

interface OrganizationInvitesContract
{
    /**
     * List all invites in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListInvitesResponse;

    /**
     * Create an invite for a person to the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): InviteResponse;

    /**
     * Retrieve an invite.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/retrieve
     */
    public function retrieve(string $inviteId): InviteResponse;

    /**
     * Delete an invite. If the invite is pending, then delete it.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/delete
     */
    public function delete(string $inviteId): DeleteInviteResponse;
}
