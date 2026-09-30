# Getting Started

## System Requirements

- **PHP**: `^8.2.0`
- **Composer**: Dependency manager
- **PSR-18 HTTP Client & PSR-17 Factory**: Guzzle (`guzzlehttp/guzzle`), Symfony HttpClient (`symfony/http-client`), or any PSR-18 compatible implementation.

---

## Installation

Install the package via Composer:

```bash
composer require squipix/openai-php-client
```

### HTTP Client Setup

This library uses `php-http/discovery` to discover installed PSR-18 HTTP clients and PSR-17 factories. If your project doesn't have an HTTP client installed yet, install Guzzle:

```bash
composer require guzzlehttp/guzzle
```

---

## Basic Initialization

Initialize the client with your OpenAI API token:

```php
use OpenAI;

$apiKey = getenv('OPENAI_API_KEY');
$client = OpenAI::client($apiKey);
```

### Using Organization and Project IDs

OpenAI supports project-scoped tokens and organization headers:

```php
$client = OpenAI::client(
    apiKey: getenv('OPENAI_API_KEY'),
    organization: 'org-xxxxxxxxxxxxxxxx',
    project: 'proj_xxxxxxxxxxxxxxxx'
);
```

---

## Verifying Setup

A quick script to test connectivity and list available models:

```php
use OpenAI;

require_once __DIR__ . '/vendor/autoload.php';

$client = OpenAI::client(getenv('OPENAI_API_KEY'));

$models = $client->models()->list();

foreach ($models->data as $model) {
    echo $model->id . PHP_EOL;
}
```
