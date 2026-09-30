<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Organization\AdminApiKeys\AdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\DeleteAdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\ListAdminApiKeysResponse;

interface OrganizationAdminApiKeysContract
{
    /**
     * Retrieve a list of admin API keys.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListAdminApiKeysResponse;

    /**
     * Create a new admin-level API key for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): AdminApiKeyResponse;

    /**
     * Retrieve a single admin API key.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/retrieve
     */
    public function retrieve(string $keyId): AdminApiKeyResponse;

    /**
     * Delete an admin API key.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/delete
     */
    public function delete(string $keyId): DeleteAdminApiKeyResponse;
}
