<?php

use OpenAI\Resources\OrganizationAdminApiKeys;
use OpenAI\Responses\Organization\AdminApiKeys\AdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\DeleteAdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\ListAdminApiKeysResponse;
use OpenAI\Testing\ClientFake;

it('records an admin api key list request', function () {
    $fake = new ClientFake([
        ListAdminApiKeysResponse::fake(),
    ]);

    $fake->organization()->adminApiKeys()->list();

    $fake->assertSent(OrganizationAdminApiKeys::class, function ($method) {
        return $method === 'list';
    });
});

it('records an admin api key create request', function () {
    $fake = new ClientFake([
        AdminApiKeyResponse::fake(),
    ]);

    $fake->organization()->adminApiKeys()->create([
        'name' => 'CI Deployment Key',
    ]);

    $fake->assertSent(OrganizationAdminApiKeys::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['name'] === 'CI Deployment Key';
    });
});

it('records an admin api key retrieve request', function () {
    $fake = new ClientFake([
        AdminApiKeyResponse::fake(),
    ]);

    $fake->organization()->adminApiKeys()->retrieve('key_123456');

    $fake->assertSent(OrganizationAdminApiKeys::class, function ($method, $keyId) {
        return $method === 'retrieve' &&
            $keyId === 'key_123456';
    });
});

it('records an admin api key delete request', function () {
    $fake = new ClientFake([
        DeleteAdminApiKeyResponse::fake(),
    ]);

    $fake->organization()->adminApiKeys()->delete('key_123456');

    $fake->assertSent(OrganizationAdminApiKeys::class, function ($method, $keyId) {
        return $method === 'delete' &&
            $keyId === 'key_123456';
    });
});
