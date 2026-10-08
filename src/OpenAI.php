<?php

declare(strict_types=1);

use OpenAI\AnthropicClient;
use OpenAI\AnthropicFactory;
use OpenAI\Client;
use OpenAI\Factory;

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
     * Creates a new Anthropic (Claude) Client with the given API key.
     */
    public static function anthropic(string $apiKey): AnthropicClient
    {
        return self::anthropicFactory()
            ->withApiKey($apiKey)
            ->make();
    }

    /**
     * Creates a new factory instance to configure a custom Anthropic (Claude) Client.
     */
    public static function anthropicFactory(): AnthropicFactory
    {
        return new AnthropicFactory;
    }
}
