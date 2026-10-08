# Native Anthropic (Claude) Client: Plan for 2026-10-08

## Context

The bridge to `anthropic-ai/sdk` (commits `cad83aa`…`5d06397` on `feat/anthropic-sdk-bridge`) works, but it uses a different pattern from the rest of the package: camelCase named arguments, properties instead of methods, SDK exceptions, and no `ClientFake`. You chose to **replace it with a native layer that follows this package's OpenAI pattern exactly**:

```php
$client = OpenAI::anthropic('sk-ant-...');
$response = $client->messages()->create([
    'model' => 'claude-opus-5-5',
    'max_tokens' => 1024,
    'messages' => [['role' => 'user', 'content' => 'Hi']],
]);
$response->content[0]->text;
$response->usage->cacheReadInputTokens;
```

**Scope (your choice):** the core GA endpoints, which are Messages (create, stream, count_tokens), Message Batches, Models, Files, and Skills with versions, plus first-class **prompt-cache handling**. Admin and beta (managed agents, etc.) are out of scope. They can be added later in the same pattern, and `anthropic-beta` can already be sent with `withHttpHeader()`.

The official SDK stays installed **during development only**, as the reference for wire shapes (`vendor/anthropic-ai/sdk/src/Messages/*.php` etc.). The last step removes it.

## Design

**Placement:** each layer goes in its existing namespace under an `Anthropic` sub-namespace. This way the `tests/Arch.php` rules apply automatically, and `Fakeable`'s namespace-replace fixture lookup keeps working.
- `src/Resources/Anthropic/*`
- `src/Contracts/Resources/Anthropic/*Contract.php`
- `src/Responses/Anthropic/<Area>/*`
- `src/Actions/Anthropic/*`
- `src/Testing/Resources/Anthropic/*`
- `src/Testing/Responses/Fixtures/Anthropic/<Area>/*`
- `tests/Resources/Anthropic/*`, `tests/Responses/Anthropic/*`, `tests/Fixtures/Anthropic*.php`, `tests/Fixtures/Streams/Anthropic*.txt`

**Reused unchanged** (checked during exploration):
- **`HttpTransporter`:** Anthropic's error body `{"type":"error","error":{"type","message"}}` fits `ErrorException`, 429 maps to `RateLimitException`, and 529 overloaded maps to `ServerException`.
- **`Payload`** (`list`/`retrieve`/`retrieveContent`/`create`/`upload`/`cancel`/`delete`) and **`ResourceUri`**: these cover every in-scope path. Anthropic pagination (`after_id`, `before_id`, `limit`) is passed as GET query parameters.
- **`StreamResponse`:** it parses `event:` and `data:` lines, skips `ping`, throws `ErrorException` on `{"error":…}`, and ends at EOF (Anthropic sends no `[DONE]`).
- **`ArrayAccessible`, `HasMetaInformation`, `Fakeable` / `FakeableForStreamedResponse`, `Streamable`, `Transportable`, `ClientFake`'s `TestRequest` / `Testable` machinery.**

**New or changed infrastructure:**
- **`Headers`** (`src/ValueObjects/Transporter/Headers.php`): add `withAnthropicAuthorization(ApiKey $key, string $version = '2023-06-01')`, which sets `x-api-key` and `anthropic-version`.
- **`MetaInformation`:** `requestId` falls back from `x-request-id` to `request-id` (Anthropic's header). `anthropic-ratelimit-*` headers stay readable through `->custom`; no typed class for them yet.
- **`Factory`:** extract the private `makeStreamHandler()` into `public static function streamHandlerFor(ClientInterface, ?Closure): Closure`, so both factories share it.
- **New `src/AnthropicFactory.php`:**
  - Methods: `withApiKey`, `withHttpClient`, `withStreamHandler`, `withBaseUri` (default `api.anthropic.com/v1`), `withHttpHeader`, `withQueryParam`, `withVersion`.
  - `make()` returns an `AnthropicClient`.
- **New `src/AnthropicClient.php`:** implements `Contracts\AnthropicClientContract`, with `messages()`, `models()`, `files()` and `skills()`. Batches are reached as `messages()->batches()`, mirroring the API path.
- **New `src/Testing/AnthropicClientFake.php`:** it can't extend `ClientFake`, because accessor names like `models()` and `files()` would clash on return types.
  - Move `ClientFake`'s record/assert bookkeeping (about 100 lines) into a trait, `Testing\Concerns\RecordsRequests`, used by both fakes.
  - Change `Testable`'s constructor parameter type to `ClientFake|AnthropicClientFake`.

**Polymorphic data:**
- **Content blocks:** `Actions\Anthropic\ContentBlocks::parse()` follows the `Actions\Responses\OutputObjects` match pattern. It has typed classes for `text` (with `citations` as an array), `thinking`, `redacted_thinking`, `tool_use` and `server_tool_use`.
- **Unknown block types** become a `GenericBlock` (`type` plus raw `attributes`) instead of throwing. Anthropic keeps adding server-tool result blocks, and one of them shouldn't crash a response. Stream deltas work the same way: typed `text_delta`, `input_json_delta`, `thinking_delta`, `signature_delta`, `citations_delta`, with `GenericDelta` as the fallback.
- **Unknown stream *events*** throw `UnknownEventException`, matching the existing streaming responses.

**Prompt-cache handling:**
- **Request side:** `cache_control` passes through untouched on `system`, `tools`, message content blocks, and at the top level. It's covered by a request-body test.
- **Response side:** `Responses\Anthropic\Messages\Usage` exposes:
  - `inputTokens`, `outputTokens`, `cacheCreationInputTokens`, `cacheReadInputTokens`;
  - `cacheCreation` (`ephemeral5mInputTokens`, `ephemeral1hInputTokens`);
  - `serverToolUse`, `serviceTier`;
  - a helper, `totalInputTokens()` = input + cache creation + cache read.
- **The same `Usage`** is parsed from `message_start` and `message_delta` stream events and from batch results.

## Steps (one commit each, tests green at each)

0. **Save the plan.** Write this plan to docs and mark the bridge plan as superseded.
1. **Foundation + Models:**
   - Infrastructure: the `Headers` method, the `MetaInformation` fallback, `Factory::streamHandlerFor`, `AnthropicFactory`, `AnthropicClient`, `AnthropicClientContract`.
   - Testing: the `RecordsRequests` trait, `AnthropicClientFake`, and an `anthropicMockClient()` helper in `tests/Pest.php` (it builds requests with `x-api-key` and base URI `api.anthropic.com/v1`).
   - Models (`list`, `retrieve`): resource, responses (`ModelInfo` with `id`, `display_name`, `created_at`, `max_input_tokens`, `max_tokens`, `capabilities`), fixtures, test resource and tests.
   - `OpenAI::anthropic()` is left alone for now. The new client is reached through `new AnthropicFactory` until step 7.
2. **Messages `create` + `countTokens`:**
   - `CreateResponse`: `id`, `type`, `role`, `model`, `content[]`, `stop_reason`, `stop_sequence`, `stop_details`, `usage`, `container`.
   - Content-block classes and the `ContentBlocks` action.
   - `Usage` with all the cache fields, and `CountTokensResponse`.
   - `create()` rejects `stream: true` (via `Streamable`).
   - Tests: block parsing (including the generic fallback), `cache_control` passthrough, and cache usage fields.
3. **Messages `createStreamed`:**
   - `CreateStreamedResponse` maps the event `type` (`message_start`, `content_block_start`, `content_block_delta`, `content_block_stop`, `message_delta`, `message_stop`) to classes in `Responses/Anthropic/Messages/Streaming/`.
   - Add an SSE fixture `.txt` for `fake()` and `tests/Fixtures/Streams/AnthropicMessages.txt`.
   - Tests: text deltas, `input_json_delta`, cache usage in `message_start`, and the in-stream `error` event.
4. **Message Batches** (`messages()->batches()`):
   - `create`, `retrieve`, `list`, `cancel`, `delete`.
   - `results($id)` reads the **JSONL** results file through `requestStream` and returns `BatchResultsResponse`. This is a small line-by-line iterator, not SSE. Each line has `custom_id` and `result` (`succeeded` with a message, or `errored`, `canceled` or `expired`).
5. **Files:**
   - `upload` (multipart, via `Payload::upload`), `list`, `retrieve` (metadata), `download` (`requestContent`, returns a string) and `delete`.
6. **Skills + Versions:**
   - `skills()`: `create` (multipart `display_title` plus `files[]`), `list`, `retrieve`, `delete`.
   - `skills()->versions()`: `create`, `list`, `retrieve`, `delete`.
7. **Replace the bridge:**
   - `OpenAI::anthropic(string $apiKey): AnthropicClient` and `OpenAI::anthropicFactory(): AnthropicFactory`.
   - `composer remove anthropic-ai/sdk`.
   - Remove the `Anthropic\*` entries from the `tests/Arch.php` allow-list, and rewrite the bridge tests in `tests/OpenAI.php`.
   - Rewrite `docs/anthropic.md` (snake_case arrays, prompt caching, streaming, batches, files, skills, testing with `AnthropicClientFake`) and update the README section, `docs/README.md` and `docs/architecture.md`.

Expected size: about 90–110 new files, mostly response classes, fixtures and tests, in the same proportions as Models (14 files) and Batches (18 files) on the OpenAI side.

## Deliberately skipped
- **Admin API, beta and managed agents, Bedrock/Vertex/Foundry auth.** Out of scope, by your choice.
- **Automatic retries** (the SDK did 2 by default). The OpenAI side has none either; add them as transporter middleware if needed.
- **Typed `anthropic-ratelimit-*` meta.** `->meta()->custom` covers it; add a typed class if someone needs one.
- **The `ANTHROPIC_API_KEY` env fallback.** The OpenAI side takes an explicit key; keep them consistent.

## Critical files
- **New:** `src/AnthropicFactory.php`, `src/AnthropicClient.php`, `src/Contracts/AnthropicClientContract.php`, `src/Testing/AnthropicClientFake.php`, `src/Testing/Concerns/RecordsRequests.php`, `src/Actions/Anthropic/ContentBlocks.php`, `src/Resources/Anthropic/{Messages,MessagesBatches,Models,Files,Skills,SkillsVersions}.php` and their contracts, responses, fixtures and tests.
- **Changed:** `src/ValueObjects/Transporter/Headers.php`, `src/Responses/Meta/MetaInformation.php`, `src/Factory.php`, `src/Testing/ClientFake.php`, `src/Testing/Resources/Concerns/Testable.php`, `src/OpenAI.php`, `tests/Pest.php`, `tests/Arch.php`, `tests/OpenAI.php`, `composer.json`, `docs/anthropic.md`, `README.md`, `docs/README.md`, `docs/architecture.md`.

## Verification
- Per step: the narrowest Pest files (`tests/Resources/Anthropic/<X>.php`, `tests/Responses/Anthropic/<X>/*`, `tests/Testing/Resources/Anthropic/*`), plus `vendor/bin/phpstan analyse` and `pint --test` on the touched files.
- At the end: `composer test:types`, `composer test:type-coverage` (100%), `composer test:unit`, and the arch tests. `test:lint` currently fails on about 20 untouched files with CRLF line endings; that's pre-existing and fixed separately with `vendor/bin/pint`.
- Optional live smoke test (real API, costs money, only with your OK): `OpenAI::anthropic(getenv('ANTHROPIC_API_KEY'))->messages()->create([...])` once with a cached system prompt, then again, checking `usage->cacheReadInputTokens > 0` on the second call.
