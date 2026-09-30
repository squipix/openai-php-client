<?php

use OpenAI\Responses\Chatkit\Threads\DeleteThreadResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadItemsResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadsResponse;
use OpenAI\Responses\Chatkit\Threads\ThreadItemResponse;
use OpenAI\Responses\Chatkit\Threads\ThreadResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('list threads', function () {
    $client = mockClient(
        'GET',
        'chatkit/threads',
        [],
        Response::from(chatkitThreadListResource(), metaHeaders())
    );

    $result = $client->chatkit()->threads()->list();

    expect($result)
        ->toBeInstanceOf(ListThreadsResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(ThreadResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve thread', function () {
    $client = mockClient(
        'GET',
        'chatkit/threads/chatkit_th_123456',
        [],
        Response::from(chatkitThreadResource(), metaHeaders())
    );

    $result = $client->chatkit()->threads()->retrieve('chatkit_th_123456');

    expect($result)
        ->toBeInstanceOf(ThreadResponse::class)
        ->id->toBe('chatkit_th_123456')
        ->object->toBe('chatkit.thread')
        ->createdAt->toBe(1720000000)
        ->title->toBe('General Inquiries')
        ->user->toBe('user_123456');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('delete thread', function () {
    $client = mockClient(
        'DELETE',
        'chatkit/threads/chatkit_th_123456',
        [],
        Response::from(chatkitThreadDeleteResource(), metaHeaders())
    );

    $result = $client->chatkit()->threads()->delete('chatkit_th_123456');

    expect($result)
        ->toBeInstanceOf(DeleteThreadResponse::class)
        ->id->toBe('chatkit_th_123456')
        ->object->toBe('chatkit.thread.deleted')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('list thread items', function () {
    $client = mockClient(
        'GET',
        'chatkit/threads/chatkit_th_123456/items',
        [],
        Response::from(chatkitThreadItemListResource(), metaHeaders())
    );

    $result = $client->chatkit()->threads()->listItems('chatkit_th_123456');

    expect($result)
        ->toBeInstanceOf(ListThreadItemsResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(ThreadItemResponse::class);

    expect($result->data[0])
        ->id->toBe('item_123456')
        ->type->toBe('user_message')
        ->content->toBe('Hello, I need help with my account.');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
