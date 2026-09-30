<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Organization\Users\DeleteUserResponse;
use OpenAI\Responses\Organization\Users\ListUsersResponse;
use OpenAI\Responses\Organization\Users\UserResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('list users', function () {
    $client = mockClient(
        'GET',
        'organization/users',
        [],
        Response::from(userListResource(), metaHeaders())
    );

    $result = $client->organization()->users()->list();

    expect($result)
        ->toBeInstanceOf(ListUsersResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(UserResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve user', function () {
    $client = mockClient(
        'GET',
        'organization/users/user_123456',
        [],
        Response::from(userResource(), metaHeaders())
    );

    $result = $client->organization()->users()->retrieve('user_123456');

    expect($result)
        ->toBeInstanceOf(UserResponse::class)
        ->id->toBe('user_123456')
        ->object->toBe('organization.user')
        ->name->toBe('John Doe')
        ->email->toBe('john.doe@example.com')
        ->role->toBe('member')
        ->addedAt->toBe(1720000000);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('modify user', function () {
    $client = mockClient(
        'POST',
        'organization/users/user_123456',
        ['role' => 'owner'],
        Response::from(array_merge(userResource(), ['role' => 'owner']), metaHeaders())
    );

    $result = $client->organization()->users()->modify('user_123456', [
        'role' => 'owner',
    ]);

    expect($result)
        ->toBeInstanceOf(UserResponse::class)
        ->id->toBe('user_123456')
        ->role->toBe('owner');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('delete user', function () {
    $client = mockClient(
        'DELETE',
        'organization/users/user_123456',
        [],
        Response::from(userDeleteResource(), metaHeaders())
    );

    $result = $client->organization()->users()->delete('user_123456');

    expect($result)
        ->toBeInstanceOf(DeleteUserResponse::class)
        ->id->toBe('user_123456')
        ->object->toBe('organization.user.deleted')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
