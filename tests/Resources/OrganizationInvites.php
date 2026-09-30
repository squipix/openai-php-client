<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Organization\Invites\DeleteInviteResponse;
use OpenAI\Responses\Organization\Invites\InviteResponse;
use OpenAI\Responses\Organization\Invites\ListInvitesResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('list invites', function () {
    $client = mockClient(
        'GET',
        'organization/invites',
        [],
        Response::from(inviteListResource(), metaHeaders())
    );

    $result = $client->organization()->invites()->list();

    expect($result)
        ->toBeInstanceOf(ListInvitesResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(InviteResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('create invite', function () {
    $client = mockClient(
        'POST',
        'organization/invites',
        [
            'email' => 'developer@example.com',
            'role' => 'member',
        ],
        Response::from(inviteResource(), metaHeaders())
    );

    $result = $client->organization()->invites()->create([
        'email' => 'developer@example.com',
        'role' => 'member',
    ]);

    expect($result)
        ->toBeInstanceOf(InviteResponse::class)
        ->id->toBe('invite_123456')
        ->object->toBe('organization.invite')
        ->email->toBe('developer@example.com')
        ->role->toBe('member')
        ->status->toBe('pending')
        ->invitedAt->toBe(1720000000)
        ->expiresAt->toBe(1722592000)
        ->projects->toBeArray();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve invite', function () {
    $client = mockClient(
        'GET',
        'organization/invites/invite_123456',
        [],
        Response::from(inviteResource(), metaHeaders())
    );

    $result = $client->organization()->invites()->retrieve('invite_123456');

    expect($result)
        ->toBeInstanceOf(InviteResponse::class)
        ->id->toBe('invite_123456');
});

test('delete invite', function () {
    $client = mockClient(
        'DELETE',
        'organization/invites/invite_123456',
        [],
        Response::from(inviteDeleteResource(), metaHeaders())
    );

    $result = $client->organization()->invites()->delete('invite_123456');

    expect($result)
        ->toBeInstanceOf(DeleteInviteResponse::class)
        ->id->toBe('invite_123456')
        ->object->toBe('organization.invite.deleted')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
