<?php

use OpenAI\AnthropicFactory;
use OpenAI\Exceptions\InvalidArgumentException;
use OpenAI\Responses\Anthropic\Messages\Content\TextBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ToolUseBlock;
use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create', function () {
    $client = anthropicMockClient('POST', 'messages', [
        'model' => 'claude-opus-5-5',
        'max_tokens' => 1024,
        'messages' => [['role' => 'user', 'content' => 'Hello']],
    ], Response::from(anthropicMessage(), anthropicMetaHeaders()));

    $result = $client->messages()->create([
        'model' => 'claude-opus-5-5',
        'max_tokens' => 1024,
        'messages' => [['role' => 'user', 'content' => 'Hello']],
    ]);

    expect($result)
        ->toBeInstanceOf(CreateResponse::class)
        ->id->toBe('msg_01XFDUDYJgAACzvnptvVoYEL')
        ->stopReason->toBe('tool_use')
        ->content->toHaveCount(7)
        ->and($result->content[2])->toBeInstanceOf(TextBlock::class)
        ->and($result->content[4])->toBeInstanceOf(ToolUseBlock::class)
        ->and($result->meta())->toBeInstanceOf(MetaInformation::class);
});

test('create sends cache_control untouched', function () {
    $parameters = [
        'model' => 'claude-opus-5-5',
        'max_tokens' => 1024,
        'cache_control' => ['type' => 'ephemeral'],
        'system' => [
            ['type' => 'text', 'text' => 'You are a helpful assistant.', 'cache_control' => ['type' => 'ephemeral', 'ttl' => '1h']],
        ],
        'tools' => [
            ['name' => 'get_weather', 'input_schema' => ['type' => 'object'], 'cache_control' => ['type' => 'ephemeral']],
        ],
        'messages' => [
            ['role' => 'user', 'content' => [['type' => 'text', 'text' => 'Hello', 'cache_control' => ['type' => 'ephemeral']]]],
        ],
    ];

    $client = anthropicMockClient('POST', 'messages', $parameters, Response::from(anthropicMessage(), anthropicMetaHeaders()));

    $result = $client->messages()->create($parameters);

    expect($result->usage)
        ->cacheCreationInputTokens->toBe(188086)
        ->cacheReadInputTokens->toBe(1500);
});

test('create throws an exception if stream option is true', function () {
    (new AnthropicFactory)->withApiKey('foo')->make()
        ->messages()
        ->create(['model' => 'claude-opus-5-5', 'stream' => true]);
})->throws(InvalidArgumentException::class, 'Stream option is not supported. Please use the createStreamed() method instead.');

test('count tokens', function () {
    $parameters = [
        'model' => 'claude-opus-5-5',
        'messages' => [['role' => 'user', 'content' => 'Hello']],
    ];

    $client = anthropicMockClient('POST', 'messages/count_tokens', $parameters, Response::from(['input_tokens' => 14], anthropicMetaHeaders()));

    $result = $client->messages()->countTokens($parameters);

    expect($result)
        ->toBeInstanceOf(CountTokensResponse::class)
        ->inputTokens->toBe(14);
});
