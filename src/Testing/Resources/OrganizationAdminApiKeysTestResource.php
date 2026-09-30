<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\OrganizationAdminApiKeysContract;
use OpenAI\Resources\OrganizationAdminApiKeys;
use OpenAI\Responses\Organization\AdminApiKeys\AdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\DeleteAdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\ListAdminApiKeysResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class OrganizationAdminApiKeysTestResource implements OrganizationAdminApiKeysContract
{
    use Testable;

    protected function resource(): string
    {
        return OrganizationAdminApiKeys::class;
    }

    public function list(array $parameters = []): ListAdminApiKeysResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function create(array $parameters): AdminApiKeyResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $keyId): AdminApiKeyResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $keyId): DeleteAdminApiKeyResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
