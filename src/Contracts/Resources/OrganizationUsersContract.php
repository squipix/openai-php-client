<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Organization\Users\DeleteUserResponse;
use OpenAI\Responses\Organization\Users\ListUsersResponse;
use OpenAI\Responses\Organization\Users\UserResponse;

interface OrganizationUsersContract
{
    /**
     * Lists all of the users in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListUsersResponse;

    /**
     * Retrieves a user by their identifier.
     *
     * @see https://platform.openai.com/docs/api-reference/users/retrieve
     */
    public function retrieve(string $userId): UserResponse;

    /**
     * Modifies a user's role in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users/modify
     *
     * @param  array<string, mixed>  $parameters
     */
    public function modify(string $userId, array $parameters): UserResponse;

    /**
     * Deletes a user from the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/users/delete
     */
    public function delete(string $userId): DeleteUserResponse;
}
