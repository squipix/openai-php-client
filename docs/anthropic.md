# Anthropic (Claude) API

The package includes a native Anthropic client built on the same transporter, response objects and testing fakes as the OpenAI client. Parameters are plain arrays with the API's own snake_case names, so the [Claude API reference](https://docs.claude.com/en/api/messages) applies one to one.

Supported: **Messages** (create, stream, count tokens), **Message Batches**, **Models**, **Files** and **Skills** (with versions), with first-class **prompt-cache** usage.

---

## Creating a Client

```php
$client = OpenAI::anthropic(getenv('ANTHROPIC_API_KEY'));
```

Or configure it through the factory:

```php
$client = OpenAI::anthropicFactory()
    ->withApiKey(getenv('ANTHROPIC_API_KEY'))
    ->withBaseUri('anthropic.example.com/v1')           // default: api.anthropic.com/v1
    ->withVersion('2023-06-01')                         // `anthropic-version` header (default)
    ->withHttpHeader('anthropic-beta', 'some-beta-2026-01-01') // opt into beta features
    ->withHttpClient(new \GuzzleHttp\Client(['timeout' => 600]))
    ->withStreamHandler(fn (RequestInterface $request): ResponseInterface => $httpClient->send($request, ['stream' => true]))
    ->make();
```

As with the OpenAI client, Guzzle and Symfony HTTP clients stream without a custom stream handler.

---

## Messages

```php
$response = $client->messages()->create([
    'model' => 'claude-opus-5-5',
    'max_tokens' => 16000,
    'messages' => [
        ['role' => 'user', 'content' => 'What is the capital of France?'],
    ],
]);

$response->id;          // 'msg_01XFDUDYJgAACzvnptvVoYEL'
$response->stopReason;  // 'end_turn'
$response->text();      // all text blocks, concatenated

foreach ($response->content as $block) {
    match ($block->type) {
        'text' => $block->text,                       // TextBlock (with ->citations)
        'thinking' => $block->thinking,               // ThinkingBlock (with ->signature)
        'tool_use', 'server_tool_use' => $block->input, // ToolUseBlock (->id, ->name, ->input)
        default => $block->attributes,                // GenericBlock: any other block type, kept raw
    };
}

$response->toArray(); // ['id' => 'msg_...', 'type' => 'message', ...]
```

Content blocks are typed as `TextBlock`, `ThinkingBlock`, `RedactedThinkingBlock` and `ToolUseBlock`, all under `OpenAI\Responses\Anthropic\Messages\Content`. Every other block type, such as server-tool results or `container_upload`, becomes a `GenericBlock`, so new block types never break parsing. When you continue a conversation, send the assistant's content back unchanged, using `$block->toArray()`.

When a request is refused, `stopReason` is `'refusal'` and `$response->stopDetails` holds the category.

### Streaming

```php
$stream = $client->messages()->createStreamed([
    'model' => 'claude-opus-5-5',
    'max_tokens' => 64000,
    'messages' => [['role' => 'user', 'content' => 'Write a haiku']],
]);

foreach ($stream as $event) {
    if ($event->event === 'content_block_delta' && $event->response->delta->type === 'text_delta') {
        echo $event->response->delta->text;
    }
}
```

| `$event->event` | `$event->response` |
|---|---|
| `message_start` | `MessageStart` (`->message` is a `CreateResponse` with initial usage) |
| `content_block_start` | `ContentBlockStart` (`->index`, `->contentBlock`) |
| `content_block_delta` | `ContentBlockDelta` (`->delta->text` / `->partialJson` / `->thinking` / `->signature` / `->citation`) |
| `content_block_stop` | `ContentBlockStop` |
| `message_delta` | `MessageDelta` (`->stopReason`, cumulative `->usage`) |
| `message_stop` | `MessageStop` |

`ping` events are skipped. An `error` event, such as `overloaded_error`, throws `OpenAI\Exceptions\ErrorException`. For tool calls, concatenate each `partialJson` and `json_decode` the result after `content_block_stop`.

### Adaptive Thinking

```php
$response = $client->messages()->create([
    'model' => 'claude-opus-5-5',
    'max_tokens' => 16000,
    'thinking' => ['type' => 'adaptive', 'display' => 'summarized'],
    'output_config' => ['effort' => 'high'],
    'messages' => [['role' => 'user', 'content' => 'Solve: 27 * 453']],
]);
```

### Tool Use

```php
$response = $client->messages()->create([
    'model' => 'claude-opus-5-5',
    'max_tokens' => 16000,
    'tools' => [[
        'name' => 'get_weather',
        'description' => 'Get the current weather for a location.',
        'input_schema' => [
            'type' => 'object',
            'properties' => ['location' => ['type' => 'string']],
            'required' => ['location'],
        ],
    ]],
    'messages' => $messages,
]);

if ($response->stopReason === 'tool_use') {
    $messages[] = ['role' => 'assistant', 'content' => $response->toArray()['content']];

    $results = [];
    foreach ($response->content as $block) {
        if ($block->type === 'tool_use') {
            $results[] = ['type' => 'tool_result', 'tool_use_id' => $block->id, 'content' => getWeather($block->input['location'])];
        }
    }

    $messages[] = ['role' => 'user', 'content' => $results]; // all results in one message
}
```

### Counting Tokens

```php
$count = $client->messages()->countTokens([
    'model' => 'claude-opus-5-5',
    'messages' => [['role' => 'user', 'content' => 'Hello']],
]);

$count->inputTokens; // 14
```

---

## Prompt Caching

Add `cache_control` wherever the API accepts it: at the top level (automatic placement) or on `tools`, `system` and message content blocks. The client sends it as-is.

```php
$response = $client->messages()->create([
    'model' => 'claude-opus-5-5',
    'max_tokens' => 16000,
    'system' => [
        ['type' => 'text', 'text' => $longSystemPrompt, 'cache_control' => ['type' => 'ephemeral', 'ttl' => '1h']],
    ],
    'messages' => [['role' => 'user', 'content' => 'Summarize the key points']],
]);

$usage = $response->usage;

$usage->inputTokens;              // uncached input after the last breakpoint
$usage->cacheCreationInputTokens; // tokens written to the cache
$usage->cacheReadInputTokens;     // tokens read from the cache
$usage->cacheCreation?->ephemeral5mInputTokens; // cache writes per TTL
$usage->cacheCreation?->ephemeral1hInputTokens;
$usage->totalInputTokens();       // input + cache writes + cache reads
```

Streams report the same `Usage` on `message_start` and `message_delta`, and batch results do too. If `cacheReadInputTokens` stays at `0` across repeated requests, something in the cached prefix is changing between calls, for example a timestamp in the system prompt.

---

## Message Batches

```php
$batch = $client->messages()->batches()->create([
    'requests' => [
        ['custom_id' => 'req-1', 'params' => ['model' => 'claude-opus-5-5', 'max_tokens' => 1024, 'messages' => [['role' => 'user', 'content' => 'Hi']]]],
    ],
]);

// Poll until processing has ended:
$batch = $client->messages()->batches()->retrieve($batch->id);
$batch->processingStatus;          // 'in_progress' | 'canceling' | 'ended'
$batch->requestCounts->succeeded;

foreach ($client->messages()->batches()->results($batch->id) as $result) {
    if ($result->type === 'succeeded') {
        echo $result->customId, ': ', $result->message->text(), PHP_EOL;
    }
}

$client->messages()->batches()->list(['limit' => 20]);
$client->messages()->batches()->cancel($batch->id);
$client->messages()->batches()->delete($batch->id);
```

`results()` streams the JSON Lines results file one result at a time. Results arrive in any order, so match them by `customId`.

---

## Files

```php
$file = $client->files()->upload(['file' => fopen('report.pdf', 'r')]);

// Reference it in a message:
// ['type' => 'document', 'source' => ['type' => 'file', 'file_id' => $file->id]]

$client->files()->list(['limit' => 20]);
$client->files()->retrieve($file->id);   // metadata: filename, mimeType, sizeBytes, downloadable
$client->files()->download($file->id);   // string contents (files created by skills / code execution)
$client->files()->delete($file->id);
```

## Skills

```php
$skill = $client->skills()->create([
    'display_name' => 'Excel Report Builder',
    'files' => [fopen('excel-report/SKILL.md', 'r'), fopen('excel-report/build.py', 'r')],
]);

$client->skills()->list(['source' => 'custom']);
$client->skills()->retrieve($skill->id);

$client->skills()->versions()->create($skill->id, ['files' => [...]]);
$client->skills()->versions()->list($skill->id);
$client->skills()->versions()->retrieve($skill->id, $versionId);
$client->skills()->versions()->delete($skill->id, $versionId);
$client->skills()->delete($skill->id);
```

## Models

```php
$models = $client->models()->list(['limit' => 20]);

foreach ($models->data as $model) {
    echo $model->id, ' ', $model->maxInputTokens, PHP_EOL;
}

$client->models()->retrieve('claude-opus-5-5')->displayName; // 'Claude Opus 5.5'
```

---

## Pagination

List endpoints return `data`, `hasMore`, `firstId` and `lastId`. Pass `after_id` / `before_id` to page through results:

```php
$page = $client->messages()->batches()->list(['limit' => 100]);

while ($page->hasMore) {
    $page = $client->messages()->batches()->list(['limit' => 100, 'after_id' => $page->lastId]);
}
```

## Meta Information

```php
$response->meta()->requestId;   // Anthropic `request-id` header
$response->meta()->custom->toArray(); // every other header, e.g. anthropic-ratelimit-*
```

## Error Handling

Errors use the same exceptions as the OpenAI client:

```php
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\RateLimitException;
use OpenAI\Exceptions\ServerException;

try {
    $client->messages()->create([...]);
} catch (RateLimitException $e) {        // 429
    // back off and retry
} catch (ServerException $e) {           // 5xx, including 529 overloaded
    // retry later
} catch (ErrorException $e) {            // 4xx
    $e->getErrorType();    // e.g. 'invalid_request_error'
    $e->getErrorMessage();
}
```

The client does not retry automatically.

---

## Testing

`OpenAI\Testing\AnthropicClientFake` works like the OpenAI `ClientFake`:

```php
use OpenAI\Resources\Anthropic\Messages;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Anthropic\Messages\CreateStreamedResponse;
use OpenAI\Testing\AnthropicClientFake;

$client = new AnthropicClientFake([
    CreateResponse::fake([
        'content' => [['type' => 'text', 'text' => 'Paris']],
        'usage' => ['cache_read_input_tokens' => 4096],
    ]),
    CreateStreamedResponse::fake(), // or ::fake(fopen('my-stream.txt', 'r'))
]);

$response = $client->messages()->create(['model' => 'claude-opus-5-5', 'max_tokens' => 1024, 'messages' => []]);

$response->text(); // 'Paris'

$client->assertSent(Messages::class, function (string $method, array $parameters): bool {
    return $method === 'create' && $parameters['model'] === 'claude-opus-5-5';
});
```

Every Anthropic response class has a `fake()` method. Batch results take a JSON Lines string: `BatchResultsResponse::fake($jsonLines)`.
