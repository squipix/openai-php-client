<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\OrganizationUsersContract;
use OpenAI\Resources\OrganizationUsers;
use OpenAI\Responses\Organization\Users\DeleteUserResponse;
use OpenAI\Responses\Organization\Users\ListUsersResponse;
use OpenAI\Responses\Organization\Users\UserResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class OrganizationUsersTestResource implements OrganizationUsersContract
{
    use Testable;

    protected function resource(): string
    {
        return OrganizationUsers::class;
    }

    public function list(array $parameters = []): ListUsersResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $userId): UserResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function modify(string $userId, array $parameters): UserResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $userId): DeleteUserResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
