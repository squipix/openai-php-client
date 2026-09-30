<?php

use OpenAI\Responses\Chatkit\Sessions\SessionResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create session', function () {
    $client = mockClient(
        'POST',
        'chatkit/sessions',
        [
            'workflow' => ['id' => 'wf_123456'],
            'user' => 'user_123456',
        ],
        Response::from(chatkitSessionResource(), metaHeaders())
    );

    $result = $client->chatkit()->sessions()->create([
        'workflow' => ['id' => 'wf_123456'],
        'user' => 'user_123456',
    ]);

    expect($result)
        ->toBeInstanceOf(SessionResponse::class)
        ->id->toBe('chatkit_sess_123456')
        ->object->toBe('chatkit.session')
        ->clientSecret->toBe('ck_sec_1234567890abcdef')
        ->expiresAt->toBe(1720000000)
        ->chatkitConfiguration->toBeArray();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('cancel session', function () {
    $client = mockClient(
        'POST',
        'chatkit/sessions/chatkit_sess_123456/cancel',
        [],
        Response::from(chatkitSessionResource(), metaHeaders())
    );

    $result = $client->chatkit()->sessions()->cancel('chatkit_sess_123456');

    expect($result)
        ->toBeInstanceOf(SessionResponse::class)
        ->id->toBe('chatkit_sess_123456');
});
