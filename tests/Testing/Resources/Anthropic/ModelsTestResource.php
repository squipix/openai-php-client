<?php

use OpenAI\Resources\Anthropic\Models;
use OpenAI\Responses\Anthropic\Models\ListResponse;
use OpenAI\Responses\Anthropic\Models\RetrieveResponse;
use OpenAI\Testing\AnthropicClientFake;

it('records a model retrieve request', function () {
    $fake = new AnthropicClientFake([
        RetrieveResponse::fake(),
    ]);

    $fake->models()->retrieve('claude-opus-5-5');

    $fake->assertSent(Models::class, fn (string $method, string $model): bool => $method === 'retrieve' && $model === 'claude-opus-5-5');
});

it('records a model list request', function () {
    $fake = new AnthropicClientFake([
        ListResponse::fake(),
    ]);

    $fake->models()->list(['limit' => 5]);

    $fake->assertSent(Models::class, fn (string $method, array $parameters): bool => $method === 'list' && $parameters === ['limit' => 5]);
    $fake->assertNotSent(Models::class, fn (string $method): bool => $method === 'retrieve');
});

it('asserts nothing was sent', function () {
    (new AnthropicClientFake)->assertNothingSent();
});

it('throws fake exceptions', function () {
    $fake = new AnthropicClientFake([new RuntimeException('overloaded')]);

    $fake->models()->list();
})->throws(RuntimeException::class, 'overloaded');
