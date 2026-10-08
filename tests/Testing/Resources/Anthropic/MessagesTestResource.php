<?php

use OpenAI\Resources\Anthropic\Messages;
use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Anthropic\Messages\CreateStreamedResponse;
use OpenAI\Testing\AnthropicClientFake;

it('records a message create request', function () {
    $fake = new AnthropicClientFake([
        CreateResponse::fake(),
    ]);

    $fake->messages()->create([
        'model' => 'claude-opus-5-5',
        'max_tokens' => 1024,
        'messages' => [['role' => 'user', 'content' => 'Hello']],
    ]);

    $fake->assertSent(Messages::class, fn (string $method, array $parameters): bool => $method === 'create' && $parameters['model'] === 'claude-opus-5-5');
});

it('records a count tokens request', function () {
    $fake = new AnthropicClientFake([
        CountTokensResponse::fake(),
    ]);

    $result = $fake->messages()->countTokens(['model' => 'claude-opus-5-5', 'messages' => []]);

    expect($result->inputTokens)->toBe(2095);
    $fake->assertSent(Messages::class, 1);
});

it('records a streamed message create request', function () {
    $fake = new AnthropicClientFake([
        CreateStreamedResponse::fake(),
    ]);

    $stream = $fake->messages()->createStreamed(['model' => 'claude-opus-5-5', 'max_tokens' => 1024, 'messages' => []]);

    expect(iterator_to_array($stream, false))->toHaveCount(7);
    $fake->assertSent(Messages::class, fn (string $method): bool => $method === 'createStreamed');
});
