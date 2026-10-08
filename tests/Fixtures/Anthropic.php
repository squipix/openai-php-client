<?php

/**
 * @return array<string, mixed>
 */
function anthropicModel(): array
{
    return [
        'type' => 'model',
        'id' => 'claude-opus-5-5',
        'display_name' => 'Claude Opus 5.5',
        'created_at' => '2026-09-01T00:00:00Z',
        'max_input_tokens' => 1000000,
        'max_tokens' => 128000,
        'capabilities' => ['thinking' => ['supported' => true]],
    ];
}

/**
 * @return array<string, mixed>
 */
function anthropicModelList(): array
{
    return [
        'data' => [
            anthropicModel(),
            anthropicModel(),
        ],
        'has_more' => false,
        'first_id' => 'claude-opus-5-5',
        'last_id' => 'claude-opus-5-5',
    ];
}

/**
 * @return array<string, array<int, string>>
 */
function anthropicMetaHeaders(): array
{
    return [
        'request-id' => ['req_011CSHoEeqs5C35K2UUqR7Fy'],
        'anthropic-ratelimit-requests-remaining' => ['49'],
    ];
}

/**
 * @return array<string, mixed>
 */
function anthropicMessage(): array
{
    return [
        'id' => 'msg_01XFDUDYJgAACzvnptvVoYEL',
        'type' => 'message',
        'role' => 'assistant',
        'model' => 'claude-opus-5-5',
        'content' => [
            ['type' => 'thinking', 'thinking' => 'The user greets me.', 'signature' => 'EqQBCgIYAhIM'],
            ['type' => 'redacted_thinking', 'data' => 'EmwKAhgBEgy3va3pzix'],
            ['type' => 'text', 'text' => 'Hello! ', 'citations' => [['type' => 'char_location', 'cited_text' => 'Hi']]],
            ['type' => 'text', 'text' => 'Let me check.'],
            ['type' => 'tool_use', 'id' => 'toolu_01A09q90qw90lq917835lq9', 'name' => 'get_weather', 'input' => ['location' => 'Paris']],
            ['type' => 'server_tool_use', 'id' => 'srvtoolu_01', 'name' => 'web_search', 'input' => ['query' => 'weather paris']],
            ['type' => 'web_search_tool_result', 'tool_use_id' => 'srvtoolu_01', 'content' => [['type' => 'web_search_result', 'url' => 'https://example.com']]],
        ],
        'stop_reason' => 'tool_use',
        'stop_sequence' => null,
        'usage' => anthropicUsage(),
    ];
}

/**
 * @return array<string, mixed>
 */
function anthropicUsage(): array
{
    return [
        'input_tokens' => 21,
        'output_tokens' => 393,
        'cache_creation_input_tokens' => 188086,
        'cache_read_input_tokens' => 1500,
        'cache_creation' => [
            'ephemeral_5m_input_tokens' => 188000,
            'ephemeral_1h_input_tokens' => 86,
        ],
        'server_tool_use' => ['web_search_requests' => 1],
        'service_tier' => 'standard',
    ];
}

/**
 * @return resource
 */
function anthropicMessagesStream()
{
    return fopen(__DIR__.'/Streams/AnthropicMessagesCreate.txt', 'r');
}

/**
 * @return resource
 */
function anthropicMessagesErrorStream()
{
    return fopen(__DIR__.'/Streams/AnthropicMessagesError.txt', 'r');
}
