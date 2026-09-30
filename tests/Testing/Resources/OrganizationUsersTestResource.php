<?php

use OpenAI\Resources\OrganizationUsers;
use OpenAI\Responses\Organization\Users\DeleteUserResponse;
use OpenAI\Responses\Organization\Users\ListUsersResponse;
use OpenAI\Responses\Organization\Users\UserResponse;
use OpenAI\Testing\ClientFake;

it('records a user list request', function () {
    $fake = new ClientFake([
        ListUsersResponse::fake(),
    ]);

    $fake->organization()->users()->list();

    $fake->assertSent(OrganizationUsers::class, function ($method) {
        return $method === 'list';
    });
});

it('records a user retrieve request', function () {
    $fake = new ClientFake([
        UserResponse::fake(),
    ]);

    $fake->organization()->users()->retrieve('user_123456');

    $fake->assertSent(OrganizationUsers::class, function ($method, $userId) {
        return $method === 'retrieve' &&
            $userId === 'user_123456';
    });
});

it('records a user modify request', function () {
    $fake = new ClientFake([
        UserResponse::fake(),
    ]);

    $fake->organization()->users()->modify('user_123456', [
        'role' => 'owner',
    ]);

    $fake->assertSent(OrganizationUsers::class, function ($method, $userId, $parameters) {
        return $method === 'modify' &&
            $userId === 'user_123456' &&
            $parameters['role'] === 'owner';
    });
});

it('records a user delete request', function () {
    $fake = new ClientFake([
        DeleteUserResponse::fake(),
    ]);

    $fake->organization()->users()->delete('user_123456');

    $fake->assertSent(OrganizationUsers::class, function ($method, $userId) {
        return $method === 'delete' &&
            $userId === 'user_123456';
    });
});
