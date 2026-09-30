# Client Configuration & Factory

The `OpenAI::factory()` builder provides granular control over the HTTP transport, headers, base URIs, and custom stream handlers.

---

## The Factory Pattern

When `OpenAI::client($apiKey)` is not enough, use `OpenAI::factory()` to customize:

```php
use OpenAI;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

$client = OpenAI::factory()
    ->withApiKey(getenv('OPENAI_API_KEY'))
    ->withOrganization('org-123456')
    ->withProject('proj_123456')
    ->withBaseUri('api.openai.com/v1')
    ->withHttpClient(new GuzzleClient(['timeout' => 30.0]))
    ->withHttpHeader('X-Custom-Tracking-Id', 'req-987')
    ->withQueryParam('user_context', 'internal')
    ->make();
```

---

## Configuration Options Reference

| Method | Description | Default |
|---|---|---|
| `withApiKey(string $apiKey)` | Sets OpenAI secret key (`Bearer ...`) | `null` |
| `withOrganization(?string $organization)` | Sets `OpenAI-Organization` header | `null` |
| `withProject(?string $project)` | Sets `OpenAI-Project` header | `null` |
| `withBaseUri(string $baseUri)` | Changes root API endpoint | `api.openai.com/v1` |
| `withHttpClient(ClientInterface $client)` | Supplies explicit PSR-18 client | Discovered via `php-http/discovery` |
| `withHttpHeader(string $name, string $value)` | Appends custom HTTP request header | `[]` |
| `withQueryParam(string $name, string $value)` | Injects custom query parameters into URLs | `[]` |
| `withStreamHandler(Closure $handler)` | Custom streaming executor | Auto-configured for Guzzle/Symfony |

---

## Custom Base URI & Proxies

If you route requests through an enterprise proxy, API gateway, or local mock server:

```php
$client = OpenAI::factory()
    ->withApiKey(getenv('OPENAI_API_KEY'))
    ->withBaseUri('proxy.mycompany.internal/v1')
    ->make();
```

---

## Custom Streaming Handlers

For HTTP clients other than Guzzle that need explicit streaming stream handling:

```php
$client = OpenAI::factory()
    ->withApiKey(getenv('OPENAI_API_KEY'))
    ->withHttpClient($httpClient)
    ->withStreamHandler(fn (RequestInterface $request): ResponseInterface => $httpClient->send($request, [
        'stream' => true,
    ]))
    ->make();
```
