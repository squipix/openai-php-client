# Anthropic (Claude) API

This package bundles Anthropic's official PHP SDK, [`anthropic-ai/sdk`](https://github.com/anthropics/anthropic-sdk-php), and exposes it through a single entry point. Every Anthropic API feature (messages, streaming, tool use, batches, files, skills, models, beta endpoints, managed agents, Bedrock / Vertex / Foundry) comes straight from the official SDK and stays in step with the API as Anthropic ships it.

> The SDK's own documentation is the reference for every method and parameter: <https://platform.claude.com/docs/en/api/sdks/php>

---

## Creating a Client

```php
// Reads ANTHROPIC_API_KEY / ANTHROPIC_AUTH_TOKEN / `ant auth login` profiles when no key is given.
$client = OpenAI::anthropic();

// Or pass the key, a custom base URL and your own PSR-18 HTTP client explicitly.
$client = OpenAI::anthropic(
    apiKey: getenv('ANTHROPIC_API_KEY'),
    baseUrl: 'https://my-proxy.example.com',
    httpClient: new GuzzleHttp\Client(['timeout' => 120]),
);
```

`OpenAI::anthropic()` returns a plain `Anthropic\Client`. For anything it doesn't expose (retries, timeouts, middleware, a streaming-capable HTTP client), construct the SDK client directly:

```php
use Anthropic\Client;
use Anthropic\RequestOptions;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY'),
    requestOptions: RequestOptions::with(maxRetries: 0, streamingTransporter: $myStreamingClient),
);
```

> **Streaming and custom HTTP clients:** `httpClient` is only used for non-streaming requests. Streaming uses the SDK's discovered client, because a PSR-18 `sendRequest()` call such as Guzzle's buffers the whole response. To stream through your own client, pass a streaming-capable one as `streamingTransporter`.

---

## Messages

```php
$message = $client->messages->create(
    model: 'claude-opus-5-5',
    maxTokens: 16000,
    messages: [
        ['role' => 'user', 'content' => 'What is the capital of France?'],
    ],
);

foreach ($message->content as $block) {
    if ($block->type === 'text') {
        echo $block->text;
    }
}
```

Named arguments are camelCase (`maxTokens`, `stopReason`). The SDK maps them to the API's snake_case on the wire. Always check a block's `type` before reading `->text`: thinking and tool-use blocks can come first.

### Streaming

```php
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\TextDelta;

$stream = $client->messages->createStream(
    model: 'claude-opus-5-5',
    maxTokens: 64000,
    messages: [['role' => 'user', 'content' => 'Write a haiku']],
);

foreach ($stream as $event) {
    if ($event instanceof RawContentBlockDeltaEvent && $event->delta instanceof TextDelta) {
        echo $event->delta->text;
    }
}
```

### Adaptive Thinking

```php
$message = $client->messages->create(
    model: 'claude-opus-5-5',
    maxTokens: 16000,
    thinking: ['type' => 'adaptive', 'display' => 'summarized'],
    messages: [['role' => 'user', 'content' => 'Solve: 27 * 453']],
);
```

Thinking blocks come before the text block. If you continue the conversation, send them back unchanged.

### Prompt Caching

```php
$message = $client->messages->create(
    model: 'claude-opus-5-5',
    maxTokens: 16000,
    system: [
        ['type' => 'text', 'text' => $longSystemPrompt, 'cacheControl' => ['type' => 'ephemeral']],
    ],
    messages: [['role' => 'user', 'content' => 'Summarize the key points']],
);

echo $message->usage->cacheReadInputTokens;
```

### Tool Runner (beta)

```php
use Anthropic\Lib\Tools\BetaRunnableTool;

$weather = new BetaRunnableTool(
    definition: [
        'name' => 'get_weather',
        'description' => 'Get the current weather for a location.',
        'inputSchema' => [
            'type' => 'object',
            'properties' => ['location' => ['type' => 'string']],
            'required' => ['location'],
        ],
    ],
    run: fn (array $input): string => "The weather in {$input['location']} is sunny.",
);

$runner = $client->beta->messages->toolRunner(
    model: 'claude-opus-5-5',
    maxTokens: 16000,
    messages: [['role' => 'user', 'content' => 'What is the weather in Paris?']],
    tools: [$weather],
);

foreach ($runner as $message) {
    // each assistant turn, until the model stops calling tools
}
```

---

## Message Batches

```php
$batch = $client->messages->batches->create(requests: [
    ['customID' => 'req-1', 'params' => ['model' => 'claude-opus-5-5', 'maxTokens' => 1024, 'messages' => [['role' => 'user', 'content' => 'Hi']]]],
]);

// Poll until $client->messages->batches->retrieve($batch->id)->processingStatus === 'ended', then:
foreach ($client->messages->batches->resultsStream($batch->id) as $result) {
    if ($result->result->type === 'succeeded') {
        echo $result->customID, ': ', $result->result->message->content[0]->text ?? '', PHP_EOL;
    }
}
```

Results can arrive in any order, so match them by `customID`, not by position.

## Files

```php
use Anthropic\Core\FileParam;

$file = $client->files->upload(file: FileParam::fromResource(fopen('report.pdf', 'r')));

// Reference it in a message:
// ['type' => 'document', 'source' => ['type' => 'file', 'fileID' => $file->id]]
```

## Models

```php
foreach ($client->models->list()->pagingEachItem() as $model) { // auto-paginates
    echo $model->id, PHP_EOL;
}

$model = $client->models->retrieve('claude-opus-5-5');
```

---

## Cloud Providers

| Provider | Client | Extra package |
|---|---|---|
| Amazon Bedrock | `new Anthropic\Bedrock\MantleClient(awsRegion: 'us-east-1')`. Model IDs take an `anthropic.` prefix. | `aws/aws-sdk-php` |
| Google Vertex AI | `Anthropic\Vertex\Client::fromEnvironment(location: 'us-east5', projectId: 'my-project')` | `google/auth` |
| Microsoft Foundry | `Anthropic\Foundry\Client::withCredentials(apiKey: ..., baseUrl: 'https://<resource>.services.ai.azure.com/anthropic/v1')` | none |

---

## Error Handling

```php
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\RateLimitException;

try {
    $client->messages->create(/* ... */);
} catch (RateLimitException $e) {
    // retry later; the SDK has already retried twice by default
} catch (APIStatusException $e) {
    echo $e->type?->value; // e.g. "invalid_request_error", "overloaded_error"
}
```

Anthropic exceptions are separate from this package's `OpenAI\Exceptions\*`.

---

## Testing

Pass a mocked PSR-18 client, such as Guzzle's `MockHandler`, so no real requests are sent:

```php
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

$http = new GuzzleClient(['handler' => HandlerStack::create(new MockHandler([
    new Response(200, ['Content-Type' => 'application/json'], json_encode([
        'id' => 'msg_1', 'type' => 'message', 'role' => 'assistant', 'model' => 'claude-opus-5-5',
        'content' => [['type' => 'text', 'text' => 'Hello!']],
        'stop_reason' => 'end_turn', 'stop_sequence' => null,
        'usage' => ['input_tokens' => 1, 'output_tokens' => 1],
    ])),
]))]);

$client = OpenAI::anthropic('test-key', httpClient: $http);
```

`OpenAI\Testing\ClientFake` covers the OpenAI client only.
