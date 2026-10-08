<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use OpenAI\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

it('may create a client', function () {
    $openAI = OpenAI::client('foo');

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets organization when provided', function () {
    $openAI = OpenAI::client('foo', 'nunomaduro');

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets project when provided', function () {
    $openAI = OpenAI::client('foo', 'nunomaduro', 'openai_proj');

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('may create a client via factory', function () {
    $openAI = OpenAI::factory()
        ->withApiKey('foo')
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets an organization via factory', function () {
    $openAI = OpenAI::factory()
        ->withOrganization('nunomaduro')
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets an project via factory', function () {
    $openAI = OpenAI::factory()
        ->withOrganization('nunomaduro')
        ->withProject('openai_proj')
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets a custom client via factory', function () {
    $openAI = OpenAI::factory()
        ->withHttpClient(new GuzzleClient)
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets a custom base url via factory', function () {
    $openAI = OpenAI::factory()
        ->withBaseUri('https://openai.example.com/v1')
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets a custom header via factory', function () {
    $openAI = OpenAI::factory()
        ->withHttpHeader('X-My-Header', 'foo')
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets a custom query parameter via factory', function () {
    $openAI = OpenAI::factory()
        ->withQueryParam('my-param', 'bar')
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('sets a custom stream handler via factory', function () {
    $openAI = OpenAI::factory()
        ->withHttpClient($client = new GuzzleClient)
        ->withStreamHandler(fn (RequestInterface $request): ResponseInterface => $client->send($request, ['stream' => true]))
        ->make();

    expect($openAI)->toBeInstanceOf(Client::class);
});

it('may create an anthropic client', function () {
    expect(OpenAI::anthropic('foo'))->toBeInstanceOf(Anthropic\Client::class);
});

/**
 * @param  array<int, array{request: RequestInterface}>  $history
 */
function anthropicMockHttpClient(array &$history): GuzzleClient
{
    $stack = HandlerStack::create(new MockHandler([
        new GuzzleResponse(200, ['Content-Type' => 'application/json'], (string) json_encode([
            'id' => 'msg_123',
            'type' => 'message',
            'role' => 'assistant',
            'model' => 'claude-opus-5-5',
            'content' => [['type' => 'text', 'text' => 'Hello!']],
            'stop_reason' => 'end_turn',
            'stop_sequence' => null,
            'usage' => ['input_tokens' => 1, 'output_tokens' => 1],
        ])),
    ]));
    $stack->push(Middleware::history($history));

    return new GuzzleClient(['handler' => $stack]);
}

it('sends anthropic requests through the given http client', function () {
    $history = [];

    $message = OpenAI::anthropic('foo', httpClient: anthropicMockHttpClient($history))->messages->create(
        model: 'claude-opus-5-5',
        maxTokens: 16,
        messages: [['role' => 'user', 'content' => 'Hi']],
    );

    $request = $history[0]['request'];

    expect($request->getMethod())->toBe('POST')
        ->and((string) $request->getUri())->toBe('https://api.anthropic.com/v1/messages')
        ->and($request->getHeaderLine('x-api-key'))->toBe('foo')
        ->and($request->getHeaderLine('anthropic-version'))->not->toBeEmpty()
        ->and($message->content[0]->text)->toBe('Hello!');
});

it('uses the given anthropic base url', function () {
    $history = [];

    OpenAI::anthropic('foo', 'https://anthropic.example.com', anthropicMockHttpClient($history))->messages->create(
        model: 'claude-opus-5-5',
        maxTokens: 16,
        messages: [['role' => 'user', 'content' => 'Hi']],
    );

    expect($history[0]['request']->getUri()->getHost())->toBe('anthropic.example.com');
});
