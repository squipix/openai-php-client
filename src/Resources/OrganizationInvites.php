<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\OrganizationInvitesContract;
use OpenAI\Responses\Organization\Invites\DeleteInviteResponse;
use OpenAI\Responses\Organization\Invites\InviteResponse;
use OpenAI\Responses\Organization\Invites\ListInvitesResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type InviteResponseType from InviteResponse
 * @phpstan-import-type ListInvitesResponseType from ListInvitesResponse
 * @phpstan-import-type DeleteInviteResponseType from DeleteInviteResponse
 */
final class OrganizationInvites implements OrganizationInvitesContract
{
    use Concerns\Transportable;

    /**
     * List all invites in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListInvitesResponse
    {
        $payload = Payload::list('organization/invites', $parameters);

        /** @var Response<ListInvitesResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListInvitesResponse::from($response->data(), $response->meta());
    }

    /**
     * Create an invite for a person to the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): InviteResponse
    {
        $payload = Payload::create('organization/invites', $parameters);

        /** @var Response<InviteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return InviteResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve an invite.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/retrieve
     */
    public function retrieve(string $inviteId): InviteResponse
    {
        $payload = Payload::retrieve('organization/invites', $inviteId);

        /** @var Response<InviteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return InviteResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete an invite. If the invite is pending, then delete it.
     *
     * @see https://platform.openai.com/docs/api-reference/invites/delete
     */
    public function delete(string $inviteId): DeleteInviteResponse
    {
        $payload = Payload::delete('organization/invites', $inviteId);

        /** @var Response<DeleteInviteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteInviteResponse::from($response->data(), $response->meta());
    }
}
