<?php

use OpenAI\Exceptions\UnknownEventException;
use OpenAI\Responses\Anthropic\Messages\CreateStreamedResponse;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockDelta;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageStart;
use OpenAI\Responses\StreamResponse;

test('from', function () {
    $response = CreateStreamedResponse::from([
        'type' => 'content_block_delta',
        'index' => 0,
        'delta' => ['type' => 'text_delta', 'text' => 'Hi'],
        '__event' => 'content_block_delta',
        '__meta' => meta(),
    ]);

    expect($response)
        ->event->toBe('content_block_delta')
        ->response->toBeInstanceOf(ContentBlockDelta::class)
        ->and($response['data']['delta']['text'])->toBe('Hi');
});

test('to array round-trips each event', function (array $data) {
    expect(CreateStreamedResponse::from([...$data, '__meta' => meta()])->toArray())
        ->toBe(['event' => $data['type'], 'data' => $data]);
})->with([
    'message_start' => [['type' => 'message_start', 'message' => ['id' => 'msg_1', 'type' => 'message', 'role' => 'assistant', 'model' => 'claude-opus-5-5', 'content' => [], 'stop_reason' => null, 'stop_sequence' => null, 'usage' => ['input_tokens' => 1, 'output_tokens' => 1]]]],
    'content_block_start' => [['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']]],
    'content_block_delta' => [['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'some_future_delta', 'foo' => 'bar']]],
    'content_block_stop' => [['type' => 'content_block_stop', 'index' => 0]],
    'message_delta' => [['type' => 'message_delta', 'delta' => ['stop_reason' => 'refusal', 'stop_sequence' => null, 'stop_details' => ['type' => 'refusal', 'category' => 'cyber']], 'usage' => ['input_tokens' => 0, 'output_tokens' => 3]]],
    'message_stop' => [['type' => 'message_stop']],
]);

test('unknown delta types keep the raw delta', function () {
    $response = CreateStreamedResponse::from([
        'type' => 'content_block_delta',
        'index' => 0,
        'delta' => ['foo' => 'bar'],
        '__meta' => meta(),
    ]);

    expect($response->response->delta)
        ->type->toBe('unknown')
        ->text->toBeNull()
        ->citation->toBeNull()
        ->and($response->response->delta->toArray())->toBe(['foo' => 'bar']);
});

test('unknown event throws', function () {
    CreateStreamedResponse::from(['type' => 'something_new', '__meta' => meta()]);
})->throws(UnknownEventException::class, 'Unknown Anthropic messages streaming event: something_new');

test('missing event type throws', function () {
    CreateStreamedResponse::from(['__meta' => meta()]);
})->throws(UnknownEventException::class, 'Missing event type in streamed response');

test('fake', function () {
    $response = CreateStreamedResponse::fake();

    expect($response)->toBeInstanceOf(StreamResponse::class);

    $events = iterator_to_array($response, false);

    expect($events)->toHaveCount(7)
        ->and($events[0]->response)->toBeInstanceOf(MessageStart::class)
        ->and($events[2]->response->delta->text)->toBe('Hello');
});
