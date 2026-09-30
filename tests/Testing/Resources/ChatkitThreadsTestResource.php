<?php

use OpenAI\Resources\ChatkitThreads;
use OpenAI\Responses\Chatkit\Threads\DeleteThreadResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadItemsResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadsResponse;
use OpenAI\Responses\Chatkit\Threads\ThreadResponse;
use OpenAI\Testing\ClientFake;

it('records a chatkit thread list request', function () {
    $fake = new ClientFake([
        ListThreadsResponse::fake(),
    ]);

    $fake->chatkit()->threads()->list();

    $fake->assertSent(ChatkitThreads::class, function ($method) {
        return $method === 'list';
    });
});

it('records a chatkit thread retrieve request', function () {
    $fake = new ClientFake([
        ThreadResponse::fake(),
    ]);

    $fake->chatkit()->threads()->retrieve('chatkit_th_123456');

    $fake->assertSent(ChatkitThreads::class, function ($method, $threadId) {
        return $method === 'retrieve' &&
            $threadId === 'chatkit_th_123456';
    });
});

it('records a chatkit thread delete request', function () {
    $fake = new ClientFake([
        DeleteThreadResponse::fake(),
    ]);

    $fake->chatkit()->threads()->delete('chatkit_th_123456');

    $fake->assertSent(ChatkitThreads::class, function ($method, $threadId) {
        return $method === 'delete' &&
            $threadId === 'chatkit_th_123456';
    });
});

it('records a chatkit thread list items request', function () {
    $fake = new ClientFake([
        ListThreadItemsResponse::fake(),
    ]);

    $fake->chatkit()->threads()->listItems('chatkit_th_123456');

    $fake->assertSent(ChatkitThreads::class, function ($method, $threadId) {
        return $method === 'listItems' &&
            $threadId === 'chatkit_th_123456';
    });
});
