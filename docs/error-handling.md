# Error Handling & Exceptions

This guide documents the exception hierarchy in `squipix/openai-php-client` and recommended patterns for handling errors in production.

---

## Exception Hierarchy

All exceptions thrown by this package implement `OpenAI\Exceptions\ExceptionContract` or extend `\Exception` / `\RuntimeException`.

| Exception Class | Trigger Condition |
|---|---|
| `OpenAI\Exceptions\ErrorException` | Returned when OpenAI's API responds with an error payload (HTTP 4xx/5xx). |
| `OpenAI\Exceptions\TransporterException` | Thrown when a network-level or PSR-18 transport failure occurs (e.g. connection timeout, DNS failure). |
| `OpenAI\Exceptions\UnserializableResponse` | Thrown if the API response is not valid JSON or violates expected schema. |
| `OpenAI\Exceptions\MissingApiKeyException` | Thrown if an API call is made without supplying an API key. |
| `OpenAI\Exceptions\WebhookVerificationException` | Thrown by `WebhookSignatureVerifier` when incoming webhook signatures are invalid, expired, or headers are missing. |

---

## Handling API Errors (`ErrorException`)

When OpenAI returns an error, `ErrorException` encapsulates the error message, type, code, and HTTP status code:

```php
use OpenAI;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;

$client = OpenAI::client(getenv('OPENAI_API_KEY'));

try {
    $response = $client->chat()->create([
        'model' => 'gpt-4o',
        'messages' => [
            ['role' => 'user', 'content' => 'Hello'],
        ],
    ]);
} catch (ErrorException $e) {
    // API-level error (e.g. rate limit, invalid model, context length exceeded)
    echo "API Error Code: " . $e->getErrorCode() . PHP_EOL;
    echo "API Error Type: " . $e->getErrorType() . PHP_EOL;
    echo "Message: " . $e->getMessage() . PHP_EOL;
} catch (TransporterException $e) {
    // Connection / Network timeout error
    echo "Network Transport Error: " . $e->getMessage() . PHP_EOL;
}
```

---

## Common Error Types & Handling Strategies

### 1. Rate Limiting (`insufficient_quota` or `rate_limit_exceeded`)
- Implement exponential backoff or retry mechanisms with jitter.
- Inspect HTTP headers for rate limits (`x-ratelimit-remaining-requests`, `x-ratelimit-reset-requests`) via response metadata.

### 2. Context Length Exceeded (`context_length_exceeded`)
- Truncate prompt history or use sliding window token management before sending requests.

### 3. Missing API Key
- Ensure environment variables are loaded properly in your deployment pipeline before client instantiation.
