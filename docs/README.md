# OpenAI PHP Client Documentation & Usage Manual

Welcome to the documentation and usage manual for `squipix/openai-php-client`, a robust, community-maintained PHP client for the OpenAI API with support for modern PHP 8.2+, PSR-18 HTTP clients, streaming, real-time endpoints, assistant tools, containers, skills, and testing fakes.

---

## Table of Contents

1. [Architecture & Overview](architecture.md)
2. [Getting Started & Installation](getting-started.md)
3. [Client Configuration & Factory](configuration.md)
4. [Core API Guides](core-apis.md)
   - [Responses API](core-apis.md#responses-api)
   - [Chat Completions](core-apis.md#chat-completions)
   - [Conversations & Items](core-apis.md#conversations--items)
   - [Containers & Code Interpreter](core-apis.md#containers--code-interpreter)
   - [Skills & Versions](core-apis.md#skills--skill-versions)
   - [Embeddings](core-apis.md#embeddings)
   - [Audio (Speech & Transcriptions)](core-apis.md#audio)
   - [Images (DALL·E)](core-apis.md#images)
   - [Files & Batches](core-apis.md#files--batches)
   - [Vector Stores](core-apis.md#vector-stores)
   - [Fine-Tuning & Moderations](core-apis.md#fine-tuning--moderations)
   - [Realtime Sessions](core-apis.md#realtime-sessions)
5. [Advanced Features & Customization](advanced.md)
   - [Streaming Responses](advanced.md#streaming-responses)
   - [Webhook Signature Verification](advanced.md#webhook-signature-verification)
   - [Azure OpenAI Service Configuration](advanced.md#azure-openai-service)
6. [Testing & Mocking Guide](testing.md)
7. [Error Handling & Exceptions](error-handling.md)

---

## Quick Example

```php
use OpenAI;

$client = OpenAI::client(getenv('OPENAI_API_KEY'));

$response = $client->responses()->create([
    'model' => 'gpt-4o',
    'input' => 'Explain quantum computing in one sentence.',
]);

echo $response->outputText;
```
