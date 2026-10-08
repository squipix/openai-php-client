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
