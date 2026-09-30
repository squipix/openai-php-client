<?php

use OpenAI\Resources\ChatkitSessions;
use OpenAI\Responses\Chatkit\Sessions\SessionResponse;
use OpenAI\Testing\ClientFake;

it('records a chatkit session create request', function () {
    $fake = new ClientFake([
        SessionResponse::fake(),
    ]);

    $fake->chatkit()->sessions()->create([
        'workflow' => ['id' => 'wf_123456'],
        'user' => 'user_123456',
    ]);

    $fake->assertSent(ChatkitSessions::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['user'] === 'user_123456';
    });
});

it('records a chatkit session cancel request', function () {
    $fake = new ClientFake([
        SessionResponse::fake(),
    ]);

    $fake->chatkit()->sessions()->cancel('chatkit_sess_123456');

    $fake->assertSent(ChatkitSessions::class, function ($method, $sessionId) {
        return $method === 'cancel' &&
            $sessionId === 'chatkit_sess_123456';
    });
});
