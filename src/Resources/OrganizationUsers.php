<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\OrganizationUsersContract;
use OpenAI\Responses\Organization\Users\DeleteUserResponse;
use OpenAI\Responses\Organization\Users\ListUsersResponse;
use OpenAI\Responses\Organization\Users\UserResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type UserResponseType from UserResponse
 * @phpstan-import-type ListUsersResponseType from ListUsersResponse
 * @phpstan-import-type DeleteUserResponseType from DeleteUserResponse
 */
final class OrganizationUsers implements OrganizationUsersContract
{
    use Concerns\Transportable;

    /**
     * Lists all of the users in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListUsersResponse
    {
        $payload = Payload::list('organization/users', $parameters);

        /** @var Response<ListUsersResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListUsersResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a user by their identifier.
     *
     * @see https://platform.openai.com/docs/api-reference/users/retrieve
     */
    public function retrieve(string $userId): UserResponse
    {
        $payload = Payload::retrieve('organization/users', $userId);

        /** @var Response<UserResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return UserResponse::from($response->data(), $response->meta());
    }

    /**
     * Modifies a user's role in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users/modify
     *
     * @param  array<string, mixed>  $parameters
     */
    public function modify(string $userId, array $parameters): UserResponse
    {
        $payload = Payload::modify('organization/users', $userId, $parameters);

        /** @var Response<UserResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return UserResponse::from($response->data(), $response->meta());
    }

    /**
     * Deletes a user from the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users/delete
     */
    public function delete(string $userId): DeleteUserResponse
    {
        $payload = Payload::delete('organization/users', $userId);

        /** @var Response<DeleteUserResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteUserResponse::from($response->data(), $response->meta());
    }
}
