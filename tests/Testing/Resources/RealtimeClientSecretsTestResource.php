<?php

use OpenAI\Resources\RealtimeClientSecrets;
use OpenAI\Responses\Realtime\ClientSecrets\ClientSecretResponse;
use OpenAI\Testing\ClientFake;

it('records a realtime client secrets create request', function () {
    $fake = new ClientFake([
        ClientSecretResponse::fake(),
    ]);

    $fake->realtime()->clientSecrets()->create([
        'expires_after' => 3600,
    ]);

    $fake->assertSent(RealtimeClientSecrets::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['expires_after'] === 3600;
    });
});
