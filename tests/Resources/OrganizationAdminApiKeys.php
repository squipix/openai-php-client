<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Organization\AdminApiKeys\AdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\DeleteAdminApiKeyResponse;
use OpenAI\Responses\Organization\AdminApiKeys\ListAdminApiKeysResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('list admin api keys', function () {
    $client = mockClient(
        'GET',
        'organization/admin_api_keys',
        [],
        Response::from(adminApiKeyListResource(), metaHeaders())
    );

    $result = $client->organization()->adminApiKeys()->list();

    expect($result)
        ->toBeInstanceOf(ListAdminApiKeysResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(AdminApiKeyResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('create admin api key', function () {
    $client = mockClient(
        'POST',
        'organization/admin_api_keys',
        ['name' => 'CI Deployment Key'],
        Response::from(adminApiKeyResource(), metaHeaders())
    );

    $result = $client->organization()->adminApiKeys()->create([
        'name' => 'CI Deployment Key',
    ]);

    expect($result)
        ->toBeInstanceOf(AdminApiKeyResponse::class)
        ->id->toBe('key_123456')
        ->object->toBe('organization.admin_api_key')
        ->name->toBe('CI Deployment Key')
        ->redactedValue->toBe('sk-admin-...abcd')
        ->createdAt->toBe(1720000000)
        ->owner->toBeArray();

    expect($result->value)->toBe('sk-admin-1234567890abcdef');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve admin api key', function () {
    $client = mockClient(
        'GET',
        'organization/admin_api_keys/key_123456',
        [],
        Response::from(adminApiKeyResource(), metaHeaders())
    );

    $result = $client->organization()->adminApiKeys()->retrieve('key_123456');

    expect($result)
        ->toBeInstanceOf(AdminApiKeyResponse::class)
        ->id->toBe('key_123456');
});

test('delete admin api key', function () {
    $client = mockClient(
        'DELETE',
        'organization/admin_api_keys/key_123456',
        [],
        Response::from(adminApiKeyDeleteResource(), metaHeaders())
    );

    $result = $client->organization()->adminApiKeys()->delete('key_123456');

    expect($result)
        ->toBeInstanceOf(DeleteAdminApiKeyResponse::class)
        ->id->toBe('key_123456')
        ->object->toBe('organization.admin_api_key.deleted')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
