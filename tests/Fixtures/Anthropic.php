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

/**
 * @return array<string, mixed>
 */
function anthropicBatch(): array
{
    return [
        'id' => 'msgbatch_013Zva2CMHLNnXjNJJKqJ2EF',
        'type' => 'message_batch',
        'processing_status' => 'ended',
        'request_counts' => [
            'processing' => 0,
            'succeeded' => 98,
            'errored' => 1,
            'canceled' => 1,
            'expired' => 0,
        ],
        'ended_at' => '2026-10-08T19:37:24.100435Z',
        'created_at' => '2026-10-08T18:37:24.100435Z',
        'expires_at' => '2026-10-09T18:37:24.100435Z',
        'archived_at' => null,
        'cancel_initiated_at' => null,
        'results_url' => 'https://api.anthropic.com/v1/messages/batches/msgbatch_013Zva2CMHLNnXjNJJKqJ2EF/results',
    ];
}

/**
 * @return array<string, mixed>
 */
function anthropicBatchList(): array
{
    return [
        'data' => [anthropicBatch(), anthropicBatch()],
        'has_more' => true,
        'first_id' => 'msgbatch_013Zva2CMHLNnXjNJJKqJ2EF',
        'last_id' => 'msgbatch_013Zva2CMHLNnXjNJJKqJ2EF',
    ];
}

function anthropicBatchResults(): string
{
    $succeeded = ['custom_id' => 'my-second-request', 'result' => ['type' => 'succeeded', 'message' => [...anthropicMessage(), 'content' => [['type' => 'text', 'text' => 'Hi']]]]];

    return json_encode($succeeded)."\n"
        ."\n"
        .json_encode(['custom_id' => 'my-first-request', 'result' => ['type' => 'errored', 'error' => ['type' => 'error', 'error' => ['type' => 'invalid_request_error', 'message' => 'Bad']]]])."\r\n"
        .json_encode(['custom_id' => 'my-third-request', 'result' => ['type' => 'expired']]);
}

/**
 * @return array<string, mixed>
 */
function anthropicFile(): array
{
    return [
        'id' => 'file_011CNha8iCJcU1wXNR6q4V8w',
        'type' => 'file',
        'filename' => 'report.pdf',
        'mime_type' => 'application/pdf',
        'size_bytes' => 1024000,
        'created_at' => '2026-10-08T12:00:00Z',
        'downloadable' => true,
    ];
}
