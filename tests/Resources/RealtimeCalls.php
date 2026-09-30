<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Realtime\Calls\CallResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('create call', function () {
    $client = mockClient(
        'POST',
        'realtime/calls',
        ['sdp' => 'v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\n'],
        Response::from(realtimeCallResource(), metaHeaders())
    );

    $result = $client->realtime()->calls()->create([
        'sdp' => 'v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\n',
    ]);

    expect($result)
        ->toBeInstanceOf(CallResponse::class)
        ->id->toBe('call_123456')
        ->object->toBe('realtime.call')
        ->status->toBe('active')
        ->sdp->toBe('v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\n');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('accept call', function () {
    $client = mockClient(
        'POST',
        'realtime/calls/call_123456/accept',
        [],
        Response::from(realtimeCallResource(), metaHeaders())
    );

    $result = $client->realtime()->calls()->accept('call_123456');

    expect($result)
        ->toBeInstanceOf(CallResponse::class)
        ->id->toBe('call_123456');
});

test('hangup call', function () {
    $client = mockClient(
        'POST',
        'realtime/calls/call_123456/hangup',
        [],
        Response::from(realtimeCallResource(), metaHeaders())
    );

    $result = $client->realtime()->calls()->hangup('call_123456');

    expect($result)
        ->toBeInstanceOf(CallResponse::class)
        ->id->toBe('call_123456');
});

test('refer call', function () {
    $client = mockClient(
        'POST',
        'realtime/calls/call_123456/refer',
        ['target' => 'sip:alice@example.com'],
        Response::from(realtimeCallResource(), metaHeaders())
    );

    $result = $client->realtime()->calls()->refer('call_123456', [
        'target' => 'sip:alice@example.com',
    ]);

    expect($result)
        ->toBeInstanceOf(CallResponse::class)
        ->id->toBe('call_123456');
});

test('reject call', function () {
    $client = mockClient(
        'POST',
        'realtime/calls/call_123456/reject',
        [],
        Response::from(realtimeCallResource(), metaHeaders())
    );

    $result = $client->realtime()->calls()->reject('call_123456');

    expect($result)
        ->toBeInstanceOf(CallResponse::class)
        ->id->toBe('call_123456');
});
