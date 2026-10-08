<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Anthropic\Messages\Content\TextBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ToolUseBlock;
use OpenAI\Responses\Anthropic\Messages\CreateStreamedResponse;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockDelta;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockStart;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockStop;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageDelta;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageStart;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageStop;
use OpenAI\Responses\StreamResponse;

/**
 * @return array<int, CreateStreamedResponse>
 */
function streamedAnthropicEvents(): array
{
    $client = anthropicMockStreamClient('POST', 'messages', [
        'model' => 'claude-opus-5-5',
        'max_tokens' => 1024,
        'messages' => [['role' => 'user', 'content' => 'Weather in Paris?']],
        'stream' => true,
    ], new Response(headers: anthropicMetaHeaders(), body: new Stream(anthropicMessagesStream())));

    $stream = $client->messages()->createStreamed([
        'model' => 'claude-opus-5-5',
        'max_tokens' => 1024,
        'messages' => [['role' => 'user', 'content' => 'Weather in Paris?']],
    ]);

    expect($stream)->toBeInstanceOf(StreamResponse::class)
        ->and($stream->meta()->requestId)->toBe('req_011CSHoEeqs5C35K2UUqR7Fy');

    return iterator_to_array($stream, false);
}

test('create streamed yields every event and skips ping', function () {
    $events = streamedAnthropicEvents();

    expect(array_map(fn (CreateStreamedResponse $event): string => $event->event, $events))->toBe([
        'message_start',
        'content_block_start', 'content_block_delta', 'content_block_delta', 'content_block_stop',
        'content_block_start', 'content_block_delta', 'content_block_delta', 'content_block_stop',
        'content_block_start', 'content_block_delta', 'content_block_delta', 'content_block_stop',
        'message_delta',
        'message_stop',
    ])
        ->and($events[0]->response)->toBeInstanceOf(MessageStart::class)
        ->and($events[4]->response)->toBeInstanceOf(ContentBlockStop::class)->index->toBe(0)
        ->and($events[13]->response)->toBeInstanceOf(MessageDelta::class)
        ->and($events[14]->response)->toBeInstanceOf(MessageStop::class);
});

test('create streamed exposes prompt cache usage', function () {
    $events = streamedAnthropicEvents();

    expect($events[0]->response->message->usage)
        ->cacheCreationInputTokens->toBe(2048)
        ->cacheReadInputTokens->toBe(4096)
        ->and($events[0]->response->message->usage->cacheCreation->ephemeral5mInputTokens)->toBe(2048)
        ->and($events[13]->response)
        ->stopReason->toBe('tool_use')
        ->and($events[13]->response->usage)
        ->outputTokens->toBe(89)
        ->cacheReadInputTokens->toBe(4096)
        ->and($events[13]->response->usage->totalInputTokens())->toBe(12 + 2048 + 4096);
});

test('create streamed parses content blocks and deltas', function () {
    $events = streamedAnthropicEvents();

    expect($events[1]->response)->toBeInstanceOf(ContentBlockStart::class)
        ->contentBlock->toBeInstanceOf(ThinkingBlock::class)
        ->and($events[2]->response)->toBeInstanceOf(ContentBlockDelta::class)
        ->and($events[2]->response->delta)->type->toBe('thinking_delta')->thinking->toBe('Let me look up the weather.')->text->toBeNull()
        ->and($events[3]->response->delta)->signature->toBe('EqQBCgIYAhIM1gbcDa9GJwZA')
        ->and($events[5]->response->contentBlock)->toBeInstanceOf(TextBlock::class)
        ->and($events[6]->response->delta)->text->toBe('Checking')
        ->and($events[7]->response->delta)->citation->toBe(['type' => 'char_location', 'cited_text' => 'Paris'])
        ->and($events[9]->response->contentBlock)->toBeInstanceOf(ToolUseBlock::class)->name->toBe('get_weather');

    $json = $events[10]->response->delta->partialJson.$events[11]->response->delta->partialJson;

    expect(json_decode($json, true))->toBe(['location' => 'Paris']);
});

test('create streamed throws on an error event', function () {
    $client = anthropicMockStreamClient('POST', 'messages', [], new Response(body: new Stream(anthropicMessagesErrorStream())), validateParams: false);

    $stream = $client->messages()->createStreamed(['model' => 'claude-opus-5-5']);

    iterator_to_array($stream);
})->throws(ErrorException::class, 'Overloaded');
