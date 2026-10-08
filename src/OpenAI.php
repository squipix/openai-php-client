<?php

declare(strict_types=1);

use Anthropic\Client as AnthropicClient;
use Anthropic\RequestOptions;
use OpenAI\Client;
use OpenAI\Factory;
use Psr\Http\Client\ClientInterface;

final class OpenAI
{
    /**
     * Creates a new Open AI Client with the given API token.
     */
    public static function client(string $apiKey, ?string $organization = null, ?string $project = null): Client
    {
        return self::factory()
            ->withApiKey($apiKey)
            ->withOrganization($organization)
            ->withProject($project)
            ->make();
    }

    /**
     * Creates a new factory instance to configure a custom Open AI Client
     */
    public static function factory(): Factory
    {
        return new Factory;
    }

    /**
     * Creates an official Anthropic SDK client (anthropic-ai/sdk).
     * Falls back to ANTHROPIC_API_KEY / ANTHROPIC_AUTH_TOKEN / ant auth profiles when no key is given.
     */
    public static function anthropic(?string $apiKey = null, ?string $baseUrl = null, ?ClientInterface $httpClient = null): AnthropicClient
    {
        return new AnthropicClient(
            apiKey: $apiKey,
            baseUrl: $baseUrl,
            requestOptions: $httpClient instanceof ClientInterface ? RequestOptions::with(transporter: $httpClient) : null,
        );
    }
}
