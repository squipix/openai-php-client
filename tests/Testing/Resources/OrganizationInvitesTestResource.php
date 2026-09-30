<?php

use OpenAI\Resources\OrganizationInvites;
use OpenAI\Responses\Organization\Invites\DeleteInviteResponse;
use OpenAI\Responses\Organization\Invites\InviteResponse;
use OpenAI\Responses\Organization\Invites\ListInvitesResponse;
use OpenAI\Testing\ClientFake;

it('records an invite list request', function () {
    $fake = new ClientFake([
        ListInvitesResponse::fake(),
    ]);

    $fake->organization()->invites()->list();

    $fake->assertSent(OrganizationInvites::class, function ($method) {
        return $method === 'list';
    });
});

it('records an invite create request', function () {
    $fake = new ClientFake([
        InviteResponse::fake(),
    ]);

    $fake->organization()->invites()->create([
        'email' => 'developer@example.com',
        'role' => 'member',
    ]);

    $fake->assertSent(OrganizationInvites::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['email'] === 'developer@example.com';
    });
});

it('records an invite retrieve request', function () {
    $fake = new ClientFake([
        InviteResponse::fake(),
    ]);

    $fake->organization()->invites()->retrieve('invite_123456');

    $fake->assertSent(OrganizationInvites::class, function ($method, $inviteId) {
        return $method === 'retrieve' &&
            $inviteId === 'invite_123456';
    });
});

it('records an invite delete request', function () {
    $fake = new ClientFake([
        DeleteInviteResponse::fake(),
    ]);

    $fake->organization()->invites()->delete('invite_123456');

    $fake->assertSent(OrganizationInvites::class, function ($method, $inviteId) {
        return $method === 'delete' &&
            $inviteId === 'invite_123456';
    });
});
