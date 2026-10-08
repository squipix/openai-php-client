<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use OpenAI\AnthropicClient;
use OpenAI\AnthropicFactory;
use Psr\Http\Message\RequestInterface;

/**
 * @param  array<int, array{request: RequestInterface}>  $history
 */
function anthropicHistoryHttpClient(array &$history): GuzzleClient
{
    $stack = HandlerStack::create(new MockHandler([
        new GuzzleResponse(200, ['Content-Type' => 'application/json', 'request-id' => 'req_1'], (string) json_encode(anthropicModel())),
    ]));
    $stack->push(Middleware::history($history));

    return new GuzzleClient(['handler' => $stack]);
}

it('may create an anthropic client', function () {
    expect((new AnthropicFactory)->withApiKey('foo')->make())->toBeInstanceOf(AnthropicClient::class);
});

it('sends anthropic authentication and version headers', function () {
    $history = [];

    $model = (new AnthropicFactory)
        ->withApiKey(' sk-ant-foo ')
        ->withHttpClient(anthropicHistoryHttpClient($history))
        ->withHttpHeader('anthropic-beta', 'some-beta-2026-01-01')
        ->make()
        ->models()
        ->retrieve('claude-opus-5-5');

    $request = $history[0]['request'];

    expect((string) $request->getUri())->toBe('https://api.anthropic.com/v1/models/claude-opus-5-5')
        ->and($request->getHeaderLine('x-api-key'))->toBe('sk-ant-foo')
        ->and($request->getHeaderLine('anthropic-version'))->toBe('2023-06-01')
        ->and($request->getHeaderLine('anthropic-beta'))->toBe('some-beta-2026-01-01')
        ->and($request->hasHeader('Authorization'))->toBeFalse()
        ->and($model->id)->toBe('claude-opus-5-5')
        ->and($model->meta()->requestId)->toBe('req_1');
});

it('uses a custom base uri, version and query parameter', function () {
    $history = [];

    (new AnthropicFactory)
        ->withApiKey('foo')
        ->withVersion('2024-01-01')
        ->withBaseUri('https://anthropic.example.com/v1')
        ->withQueryParam('foo', 'bar')
        ->withHttpClient(anthropicHistoryHttpClient($history))
        ->withStreamHandler(fn () => throw new LogicException)
        ->make()
        ->models()
        ->retrieve('claude-opus-5-5');

    $request = $history[0]['request'];

    expect((string) $request->getUri())->toBe('https://anthropic.example.com/v1/models/claude-opus-5-5?foo=bar')
        ->and($request->getHeaderLine('anthropic-version'))->toBe('2024-01-01');
});

it('sends the version header without an api key', function () {
    $history = [];

    (new AnthropicFactory)
        ->withHttpClient(anthropicHistoryHttpClient($history))
        ->make()
        ->models()
        ->retrieve('claude-opus-5-5');

    expect($history[0]['request']->hasHeader('x-api-key'))->toBeFalse()
        ->and($history[0]['request']->getHeaderLine('anthropic-version'))->toBe('2023-06-01');
});
