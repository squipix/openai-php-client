# Anthropic API Support via `anthropic-ai/sdk`: Plan for 2026-10-08

## Context

`squipix/openai-php-client` currently talks only to the OpenAI API. We want full Anthropic API support from the same package. Anthropic publishes an official PHP SDK, `anthropic-ai/sdk`, which covers the whole API: messages, streaming, batches, token counting, files, skills, models, organization/admin, beta (managed agents, tool runner, and so on), webhooks, and Bedrock/Vertex/Foundry clients. Anthropic also keeps it current as the API changes. Rebuilding it here would mean 100+ files that we'd have to keep in sync with the API by hand, so **we bridge to the official SDK instead of reimplementing it** (you chose this option).

Compatibility has been checked against the SDK's `composer.json`:
- PHP `^8.1` (we require `^8.2`), so the PHP version is fine.
- It uses the same PSR packages we already use: `php-http/discovery`, `psr/http-client`, `psr/http-message ^1|^2`, and the PSR-17 implementations.
- Its namespace is `Anthropic\`, so nothing collides with `OpenAI\`.
- Its client is built as `new Anthropic\Client(?apiKey, ?authToken, ?webhookKey, ?baseUrl, requestOptions, ?credentials)`. `RequestOptions::with(transporter: ClientInterface, streamingTransporter: ClientInterface, timeout, maxRetries, extraHeaders, ...)` accepts a PSR-18 client, so a caller's HTTP client can be passed straight in.
- With no key passed, it reads `ANTHROPIC_API_KEY`, `ANTHROPIC_AUTH_TOKEN` and `ANTHROPIC_BASE_URL` from the environment and also resolves `ant auth login` profiles.

## Steps (one commit each)

### 1. Add the dependency
- `composer.json`: add `"anthropic-ai/sdk": "^<latest stable>"` to `require`. Pin the latest tag that `composer require anthropic-ai/sdk` resolves.
- Add `anthropic` and `claude` to `keywords`, and change `description` to mention Anthropic.
- `composer update anthropic-ai/sdk`.

### 2. Entry point: `OpenAI::anthropic()` (`src/OpenAI.php`)
One static method next to `client()` and `factory()`, with no new class and no factory:

```php
/**
 * Creates an official Anthropic SDK client (anthropic-ai/sdk).
 * Falls back to ANTHROPIC_API_KEY / ANTHROPIC_AUTH_TOKEN / ant auth profiles when no key is given.
 */
public static function anthropic(?string $apiKey = null, ?string $baseUrl = null, ?ClientInterface $httpClient = null): \Anthropic\Client
{
    return new \Anthropic\Client(
        apiKey: $apiKey,
        baseUrl: $baseUrl,
        requestOptions: $httpClient ? \Anthropic\RequestOptions::with(transporter: $httpClient) : null,
    );
}
```
- `$httpClient` is passed only as `transporter`. `streamingTransporter` is left to the SDK default because Guzzle's `sendRequest` buffers the whole response, which breaks SSE. Callers who need a custom streaming client build `Anthropic\Client` directly, and the docs will say so.
- Everything else (timeouts, retries, middleware, Bedrock/Vertex/Foundry) goes through the SDK directly. We don't wrap it.
- If the `openai` arch test in `tests/Arch.php` rejects the new imports, add `Anthropic\Client`, `Anthropic\RequestOptions` and `Psr\Http\Client\ClientInterface` to its allow-list.

### 3. Tests (`tests/OpenAI.php`)
- `OpenAI::anthropic('foo')` returns an `Anthropic\Client` instance.
- Send one request through a Guzzle `MockHandler` + `Middleware::history` client (Guzzle is already in require-dev): `$client->messages->create(model: 'claude-opus-5-5', maxTokens: 16, messages: [...])` against a canned JSON response. Assert that the request goes to `POST https://api.anthropic.com/v1/messages`, that the `x-api-key: foo` and `anthropic-version` headers are set, and that the parsed `content[0]->text` is correct. This proves the injected PSR-18 client is actually used.
- With a custom `$baseUrl`, the request host changes.

### 4. Docs
- New `docs/anthropic.md` covering:
  - install;
  - `OpenAI::anthropic()` and plain `new Anthropic\Client()`;
  - basic message, streaming (`createStream`), adaptive thinking, prompt caching, batches, files, models, and the beta tool runner, all using **SDK-documented** PHP signatures (camelCase named args) and the `claude-opus-5-5` model;
  - Bedrock (`Anthropic\Bedrock\MantleClient`), Vertex (`Anthropic\Vertex\Client::fromEnvironment`) and Foundry;
  - error handling (`Anthropic\Core\Exceptions\APIStatusException`);
  - testing with a PSR-18 mock client.
- `README.md`: a short "Anthropic (Claude)" section linking to `docs/anthropic.md`. Add a line to `docs/architecture.md` saying Anthropic calls are delegated to the official SDK.

## Deliberately skipped
- **A native Anthropic Resources/Responses/Transporter layer.** The SDK already provides it. Revisit only if the SDK can't do something we need.
- **An Anthropic `ClientFake`.** Testing with a PSR-18 mock client (step 3) covers it. Add a fake if users ask for `assertSent`-style ergonomics.
- **Sharing `OpenAI\Factory` config (headers, query params, stream handler) with Anthropic.** The two APIs have different auth and headers, so mixing them in one factory would be confusing. Add it if someone needs one shared config object.

## Critical files
- `composer.json`
- `src/OpenAI.php`
- `tests/OpenAI.php`, and `tests/Arch.php` if needed
- `docs/anthropic.md` (new), `README.md`, `docs/architecture.md`

## Verification
- `composer test`: runs Pint, PHPStan at level max (it must accept the `Anthropic\` types), 100% type coverage, and the Pest unit and arch tests.
- Optional manual smoke test: `php -r 'require "vendor/autoload.php"; var_dump(OpenAI::anthropic()->messages->create(model: "claude-opus-5-5", maxTokens: 64, messages: [["role"=>"user","content"=>"hi"]])->content[0]->text);'` with `ANTHROPIC_API_KEY` set. This makes a real API call that costs money, so only run it with your OK.
