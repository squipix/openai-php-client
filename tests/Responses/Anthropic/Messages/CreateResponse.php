<?php

use OpenAI\Responses\Anthropic\Messages\Content\GenericBlock;
use OpenAI\Responses\Anthropic\Messages\Content\RedactedThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\TextBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ToolUseBlock;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Anthropic\Messages\Usage;
use OpenAI\Responses\Anthropic\Messages\UsageCacheCreation;

test('from', function () {
    $response = CreateResponse::from(anthropicMessage(), meta());

    expect($response)
        ->id->toBe('msg_01XFDUDYJgAACzvnptvVoYEL')
        ->type->toBe('message')
        ->role->toBe('assistant')
        ->model->toBe('claude-opus-5-5')
        ->stopReason->toBe('tool_use')
        ->stopSequence->toBeNull()
        ->stopDetails->toBeNull()
        ->container->toBeNull()
        ->usage->toBeInstanceOf(Usage::class);
});

test('parses every content block type', function () {
    $content = CreateResponse::from(anthropicMessage(), meta())->content;

    expect($content[0])->toBeInstanceOf(ThinkingBlock::class)
        ->thinking->toBe('The user greets me.')
        ->signature->toBe('EqQBCgIYAhIM')
        ->and($content[1])->toBeInstanceOf(RedactedThinkingBlock::class)
        ->data->toBe('EmwKAhgBEgy3va3pzix')
        ->and($content[2])->toBeInstanceOf(TextBlock::class)
        ->text->toBe('Hello! ')
        ->citations->toBe([['type' => 'char_location', 'cited_text' => 'Hi']])
        ->and($content[3])->citations->toBeNull()
        ->and($content[4])->toBeInstanceOf(ToolUseBlock::class)
        ->type->toBe('tool_use')
        ->name->toBe('get_weather')
        ->input->toBe(['location' => 'Paris'])
        ->and($content[5])->toBeInstanceOf(ToolUseBlock::class)
        ->type->toBe('server_tool_use')
        ->and($content[6])->toBeInstanceOf(GenericBlock::class)
        ->type->toBe('web_search_tool_result')
        ->attributes->toHaveKey('tool_use_id', 'srvtoolu_01');
});

test('unknown block types do not throw', function () {
    $attributes = anthropicMessage();
    $attributes['content'] = [['type' => 'some_future_block', 'foo' => 'bar'], ['no_type' => true]];

    $content = CreateResponse::from($attributes, meta())->content;

    expect($content[0])->toBeInstanceOf(GenericBlock::class)->type->toBe('some_future_block')
        ->and($content[0]['foo'])->toBe('bar')
        ->and($content[1])->type->toBe('unknown');
});

test('text concatenates text blocks', function () {
    expect(CreateResponse::from(anthropicMessage(), meta())->text())->toBe('Hello! Let me check.');
});

test('exposes prompt cache usage', function () {
    $usage = CreateResponse::from(anthropicMessage(), meta())->usage;

    expect($usage)
        ->inputTokens->toBe(21)
        ->outputTokens->toBe(393)
        ->cacheCreationInputTokens->toBe(188086)
        ->cacheReadInputTokens->toBe(1500)
        ->serverToolUse->toBe(['web_search_requests' => 1])
        ->serviceTier->toBe('standard')
        ->inferenceGeo->toBeNull()
        ->cacheCreation->toBeInstanceOf(UsageCacheCreation::class)
        ->and($usage->cacheCreation)
        ->ephemeral5mInputTokens->toBe(188000)
        ->ephemeral1hInputTokens->toBe(86)
        ->and($usage->totalInputTokens())->toBe(21 + 188086 + 1500);
});

test('usage without cache fields', function () {
    $usage = Usage::from(['input_tokens' => 10, 'output_tokens' => 5]);

    expect($usage)
        ->cacheCreationInputTokens->toBeNull()
        ->cacheReadInputTokens->toBeNull()
        ->cacheCreation->toBeNull()
        ->and($usage->totalInputTokens())->toBe(10)
        ->and($usage->toArray())->toBe(['input_tokens' => 10, 'output_tokens' => 5]);
});

test('as array accessible', function () {
    $response = CreateResponse::from(anthropicMessage(), meta());

    expect($response['stop_reason'])->toBe('tool_use')
        ->and($response->content[4]['name'])->toBe('get_weather');
});

test('to array', function () {
    $message = anthropicMessage();
    $attributes = [
        ...array_diff_key($message, ['usage' => true]),
        'stop_details' => ['type' => 'refusal', 'category' => 'cyber', 'explanation' => null],
        'usage' => $message['usage'],
        'container' => ['id' => 'container_1', 'expires_at' => '2026-10-08T00:00:00Z'],
    ];

    expect(CreateResponse::from($attributes, meta())->toArray())->toBe($attributes);
});

test('fake', function () {
    $response = CreateResponse::fake();

    expect($response->text())->toBe('Hello! How can I help you today?')
        ->and($response->usage->cacheReadInputTokens)->toBe(0);
});

test('fake with override', function () {
    $response = CreateResponse::fake([
        'usage' => ['cache_read_input_tokens' => 4096],
    ]);

    expect($response->usage)
        ->inputTokens->toBe(12)
        ->cacheReadInputTokens->toBe(4096);
});
