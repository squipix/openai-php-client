<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\OrganizationAdminApiKeysContract;
use OpenAI\Responses\Organization\AdminApiKeys\AdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\DeleteAdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\ListAdminApiKeysResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type AdminApiKeyResponseType from AdminApiKeyResponse
 * @phpstan-import-type ListAdminApiKeysResponseType from ListAdminApiKeysResponse
 * @phpstan-import-type DeleteAdminApiKeyResponseType from DeleteAdminApiKeyResponse
 */
final class OrganizationAdminApiKeys implements OrganizationAdminApiKeysContract
{
    use Concerns\Transportable;

    /**
     * Retrieve a list of admin API keys.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListAdminApiKeysResponse
    {
        $payload = Payload::list('organization/admin_api_keys', $parameters);

        /** @var Response<ListAdminApiKeysResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListAdminApiKeysResponse::from($response->data(), $response->meta());
    }

    /**
     * Create a new admin-level API key for the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): AdminApiKeyResponse
    {
        $payload = Payload::create('organization/admin_api_keys', $parameters);

        /** @var Response<AdminApiKeyResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return AdminApiKeyResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve a single admin API key.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/retrieve
     */
    public function retrieve(string $keyId): AdminApiKeyResponse
    {
        $payload = Payload::retrieve('organization/admin_api_keys', $keyId);

        /** @var Response<AdminApiKeyResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return AdminApiKeyResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete an admin API key.
     *
     * @see https://platform.openai.com/docs/api-reference/admin-api-keys/delete
     */
    public function delete(string $keyId): DeleteAdminApiKeyResponse
    {
        $payload = Payload::delete('organization/admin_api_keys', $keyId);

        /** @var Response<DeleteAdminApiKeyResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteAdminApiKeyResponse::from($response->data(), $response->meta());
    }
}
