# Advanced Features

This guide covers streaming Server-Sent Events (SSE), Webhook verification, and Azure OpenAI integration.

---

## Streaming Responses

Streaming enables token-by-token output in real time using Server-Sent Events (SSE). Both `chat()->createStreamed()` and `responses()->createStreamed()` return an instance of `OpenAI\Responses\StreamResponse`.

### Server-Sent Events in HTTP Controllers (e.g., Laravel / Symfony)

```php
use OpenAI;
use Symfony\Component\HttpFoundation\StreamedResponse;

public function streamChat()
{
    $client = OpenAI::client(env('OPENAI_API_KEY'));

    return new StreamedResponse(function () use ($client) {
        $stream = $client->chat()->createStreamed([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => 'Write a short poem about code refactoring.'],
            ],
        ]);

        foreach ($stream as $response) {
            $delta = $response->choices[0]->delta->content;
            if ($delta !== null) {
                echo "data: " . json_encode(['text' => $delta]) . "\n\n";
                ob_flush();
                flush();
            }
        }

        echo "data: [DONE]\n\n";
        ob_flush();
        flush();
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'X-Accel-Buffering' => 'no',
    ]);
}
```

---

## Webhook Signature Verification

OpenAI sends cryptographic signatures on webhooks (e.g. batch completion notifications or fine-tuning updates). Use `OpenAI\Webhooks\WebhookSignatureVerifier` to protect your endpoints against spoofing and replay attacks.

### Verification Example (PSR-7 Request)

```php
use OpenAI\Webhooks\WebhookSignatureVerifier;
use OpenAI\Exceptions\WebhookVerificationException;
use Psr\Http\Message\ServerRequestInterface;

$verifier = new WebhookSignatureVerifier(
    secret: getenv('OPENAI_WEBHOOK_SECRET'), // Format: whsec_... or base64
    tolerance: 300 // Maximum 300 seconds clock skew tolerance
);

try {
    /** @var ServerRequestInterface $request */
    $verifier->verify($request);

    // Signature is valid. Process the payload:
    $payload = json_decode((string) $request->getBody(), true);
    
    // Handle webhook event (e.g., batch.completed)
} catch (WebhookVerificationException $e) {
    // Signature verification failed (invalid signature, header missing, or expired timestamp)
    http_response_code(400);
    echo 'Invalid signature: ' . $e->getMessage();
    exit;
}
```

### Unwrapping Webhooks Directly

You can verify and parse the payload into an associative array in a single call using `unwrap()`:

```php
try {
    $payload = $verifier->unwrap($request);

    $eventType = $payload['type'];
    $data = $payload['data'];
} catch (WebhookVerificationException $e) {
    // Verification failed or invalid JSON payload
}
```

---

## Azure OpenAI Service

To connect to Azure OpenAI Service, instantiate the client using `OpenAI::factory()` with your Azure resource URL, deployment ID, and API version.

```php
use OpenAI;

$client = OpenAI::factory()
    ->withBaseUri('{your-resource-name}.openai.azure.com/openai/deployments/{deployment-id}')
    ->withHttpHeader('api-key', '{your-azure-api-key}')
    ->withQueryParam('api-version', '2024-02-15-preview')
    ->make();
```

> **Note**: Because `{deployment-id}` is embedded in the `BaseUri`, you do not pass the `model` parameter in chat or completion calls when using Azure:

```php
$response = $client->chat()->create([
    'messages' => [
        ['role' => 'user', 'content' => 'Hello Azure OpenAI!'],
    ],
]);

echo $response->choices[0]->message->content;
```
