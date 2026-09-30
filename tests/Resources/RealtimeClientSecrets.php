<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Realtime\ClientSecrets\ClientSecretResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('create client secret', function () {
    $client = mockClient(
        'POST',
        'realtime/client_secrets',
        [],
        Response::from(realtimeClientSecretResource(), metaHeaders())
    );

    $result = $client->realtime()->clientSecrets()->create();

    expect($result)
        ->toBeInstanceOf(ClientSecretResponse::class)
        ->expiresAt->toBe(1720000000)
        ->session->toBeArray();

    expect($result->value)->toBe('ek_1234567890abcdef');
    expect($result->session['voice'])->toBe('alloy');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('create client secret with params', function () {
    $client = mockClient(
        'POST',
        'realtime/client_secrets',
        ['expires_after' => 3600],
        Response::from(realtimeClientSecretResource(), metaHeaders())
    );

    $result = $client->realtime()->clientSecrets()->create([
        'expires_after' => 3600,
    ]);

    expect($result)
        ->toBeInstanceOf(ClientSecretResponse::class);

    expect($result->value)->toBe('ek_1234567890abcdef');
});
