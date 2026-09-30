<?php

use OpenAI\Resources\RealtimeCalls;
use OpenAI\Responses\Realtime\Calls\CallResponse;
use OpenAI\Testing\ClientFake;

it('records a realtime call create request', function () {
    $fake = new ClientFake([
        CallResponse::fake(),
    ]);

    $fake->realtime()->calls()->create([
        'sdp' => 'v=0\r\n',
    ]);

    $fake->assertSent(RealtimeCalls::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['sdp'] === 'v=0\r\n';
    });
});

it('records a realtime call accept request', function () {
    $fake = new ClientFake([
        CallResponse::fake(),
    ]);

    $fake->realtime()->calls()->accept('call_123456');

    $fake->assertSent(RealtimeCalls::class, function ($method, $callId) {
        return $method === 'accept' &&
            $callId === 'call_123456';
    });
});

it('records a realtime call hangup request', function () {
    $fake = new ClientFake([
        CallResponse::fake(),
    ]);

    $fake->realtime()->calls()->hangup('call_123456');

    $fake->assertSent(RealtimeCalls::class, function ($method, $callId) {
        return $method === 'hangup' &&
            $callId === 'call_123456';
    });
});

it('records a realtime call refer request', function () {
    $fake = new ClientFake([
        CallResponse::fake(),
    ]);

    $fake->realtime()->calls()->refer('call_123456', [
        'target' => 'sip:alice@example.com',
    ]);

    $fake->assertSent(RealtimeCalls::class, function ($method, $callId, $parameters) {
        return $method === 'refer' &&
            $callId === 'call_123456' &&
            $parameters['target'] === 'sip:alice@example.com';
    });
});

it('records a realtime call reject request', function () {
    $fake = new ClientFake([
        CallResponse::fake(),
    ]);

    $fake->realtime()->calls()->reject('call_123456');

    $fake->assertSent(RealtimeCalls::class, function ($method, $callId) {
        return $method === 'reject' &&
            $callId === 'call_123456';
    });
});
