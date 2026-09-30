# Testing & Mocking Guide

The library includes first-class testing utilities with `OpenAI\Testing\ClientFake`, allowing you to mock API responses and write expressive assertions without making network calls or spending API credits.

---

## Setting Up `ClientFake`

Replace your production client with `ClientFake`:

```php
use OpenAI\Testing\ClientFake;
use OpenAI\Responses\Responses\CreateResponse;

$client = new ClientFake([
    CreateResponse::fake([
        'id' => 'resp_fake123',
        'output' => [
            [
                'type' => 'message',
                'role' => 'assistant',
                'content' => [
                    [
                        'type' => 'output_text',
                        'text' => 'Hello from fake response!',
                    ],
                ],
            ],
        ],
    ]),
]);

$response = $client->responses()->create([
    'model' => 'gpt-4o',
    'input' => 'Hello',
]);

echo $response->outputText; // "Hello from fake response!"
```

---

## Mocking Chat Completions

```php
use OpenAI\Testing\ClientFake;
use OpenAI\Responses\Chat\CreateResponse;

$client = new ClientFake([
    CreateResponse::fake([
        'choices' => [
            [
                'message' => [
                    'role' => 'assistant',
                    'content' => 'Mocked chat reply',
                ],
            ],
        ],
    ]),
]);

$result = $client->chat()->create([
    'model' => 'gpt-4o',
    'messages' => [['role' => 'user', 'content' => 'Hi!']],
]);

expect($result->choices[0]->message->content)->toBe('Mocked chat reply');
```

---

## Mocking Streamed Responses

Provide a fake readable stream using `CreateStreamedResponse::fake()`:

```php
use OpenAI\Testing\ClientFake;
use OpenAI\Responses\Chat\CreateStreamedResponse;

$streamResource = fopen('php://memory', 'r+');
fwrite($streamResource, "data: " . json_encode([
    'id' => 'chatcmpl-test',
    'choices' => [
        [
            'delta' => ['content' => 'Streamed '],
        ],
    ],
]) . "\n\n");
fwrite($streamResource, "data: " . json_encode([
    'id' => 'chatcmpl-test',
    'choices' => [
        [
            'delta' => ['content' => 'output!'],
        ],
    ],
]) . "\n\n");
rewind($streamResource);

$client = new ClientFake([
    CreateStreamedResponse::fake($streamResource),
]);

$stream = $client->chat()->createStreamed([
    'model' => 'gpt-4o',
    'messages' => [['role' => 'user', 'content' => 'Stream test']],
]);

$output = '';
foreach ($stream as $chunk) {
    $output .= $chunk->choices[0]->delta->content ?? '';
}

// $output is "Streamed output!"
```

---

## Request Assertions

Verify that your application sent expected calls with the correct parameters:

```php
use OpenAI\Resources\Chat;
use OpenAI\Resources\Responses;

// Assert a specific resource method was called with expected parameters
$client->assertSent(Chat::class, function (string $method, array $parameters): bool {
    return $method === 'create'
        && $parameters['model'] === 'gpt-4o'
        && $parameters['messages'][0]['content'] === 'Hi!';
});

// Or using resource helper directly
$client->chat()->assertSent(function (string $method, array $parameters): bool {
    return $parameters['model'] === 'gpt-4o';
});

// Assert number of times sent
$client->assertSent(Chat::class, 1);

// Assert resource was not called
$client->assertNotSent(Responses::class);

// Assert absolutely nothing was sent
$client->assertNothingSent();
```

---

## Mocking Errors & Exceptions

Simulate network or API failures by passing `Throwable` instances into `ClientFake`:

```php
use OpenAI\Testing\ClientFake;
use OpenAI\Exceptions\ErrorException;

$client = new ClientFake([
    new ErrorException([
        'message' => 'The model `gpt-unknown` does not exist',
        'type' => 'invalid_request_error',
        'code' => 'model_not_found',
    ], 404),
]);

// This call will throw the ErrorException
$client->chat()->create([
    'model' => 'gpt-unknown',
    'messages' => [['role' => 'user', 'content' => 'Test']],
]);
```
