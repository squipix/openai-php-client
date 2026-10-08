# Architecture & Internal Design

This document details the internal design and key components of `squipix/openai-php-client`.

---

## Architectural Principles

1. **PSR Compliant**: Decoupled from specific HTTP clients through PSR-18 (`ClientInterface`) and PSR-17 (`RequestFactoryInterface`, `StreamFactoryInterface`) via `php-http/discovery`.
2. **Resource-Oriented Design**: Each OpenAI endpoint domain is isolated inside its own Resource class under `src/Resources/` (e.g. [Responses](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Responses.php), [Chat](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Chat.php), [Containers](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Containers.php)).
3. **Strong Typing & Value Objects**: Request payloads and response structures are mapped into immutable value objects and response objects with full PHPStan level 8+ type coverage.
4. **First-Class Testing Support**: Includes a comprehensive [ClientFake](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Testing/ClientFake.php) enabling developers to mock any resource call without hitting real endpoints.

---

## Component Flow

```
+--------------------------------------------------------+
|                      Application                       |
+--------------------------------------------------------+
                           |
                           v
+--------------------------------------------------------+
|          OpenAI (Entrypoint) / Factory                 |
+--------------------------------------------------------+
                           |
                           v
+--------------------------------------------------------+
|                  Client (ClientContract)               |
+--------------------------------------------------------+
          |                  |                 |
          v                  v                 v
   +--------------+   +--------------+  +--------------+
   | Responses    |   | Chat         |  | Containers   | ... (Other Resources)
   +--------------+   +--------------+  +--------------+
          \                  |                 /
           \                 |                /
            v                v               v
         +---------------------------------------+
         |     Transporter (HttpTransporter)     |
         +---------------------------------------+
                             |
                             v
         +---------------------------------------+
         |   PSR-18 HTTP Client (Guzzle/Symfony) |
         +---------------------------------------+
                             |
                             v
         +---------------------------------------+
         |           OpenAI REST API             |
         +---------------------------------------+
```

---

## Key Directories

- `src/Resources`: Endpoint implementations that construct payloads and invoke the transporter.
- `src/Responses`: Value objects representing structured API responses with typed accessors.
- `src/Testing`: Test resources and fake client implementations.
- `src/Transporters`: Transport layer converting high-level payloads to PSR-7 requests and dispatching them.
- `src/Webhooks`: Cryptographic signature verification for inbound OpenAI webhooks.

Anthropic (Claude) calls bypass this stack entirely: `OpenAI::anthropic()` returns the official `anthropic-ai/sdk` client, which brings its own resources, transport, retries and exceptions. See [anthropic.md](anthropic.md).
