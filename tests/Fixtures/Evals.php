<?php

/**
 * @return array<string, mixed>
 */
function evalResource(): array
{
    return [
        'id' => 'eval_123456',
        'object' => 'eval',
        'created_at' => 1720000000,
        'name' => 'Support Bot Quality',
        'data_source_config' => [
            'type' => 'custom',
        ],
        'testing_criteria' => [
            ['type' => 'string_check', 'operation' => 'contains', 'value' => 'refund'],
        ],
        'metadata' => [
            'team' => 'support',
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function evalListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            evalResource(),
        ],
        'first_id' => 'eval_123456',
        'last_id' => 'eval_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function evalDeleteResource(): array
{
    return [
        'id' => 'eval_123456',
        'object' => 'eval.deleted',
        'deleted' => true,
    ];
}

/**
 * @return array<string, mixed>
 */
function evalRunResource(): array
{
    return [
        'id' => 'eval_run_123456',
        'object' => 'eval.run',
        'eval_id' => 'eval_123456',
        'created_at' => 1720000000,
        'status' => 'completed',
        'name' => 'Run 1',
        'model' => 'gpt-4o-mini',
        'data_source' => [
            'type' => 'custom',
        ],
        'metadata' => [
            'batch' => '1',
        ],
        'per_model_usage' => [
            'total_tokens' => 1500,
        ],
        'per_testing_criteria_results' => [
            ['criteria_index' => 0, 'passed' => 10, 'failed' => 0],
        ],
        'result_counts' => [
            'total' => 10,
            'passed' => 10,
            'failed' => 0,
        ],
        'report_url' => 'https://platform.openai.com/evals/eval_123456/runs/eval_run_123456',
        'error' => null,
    ];
}

/**
 * @return array<string, mixed>
 */
function evalRunListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            evalRunResource(),
        ],
        'first_id' => 'eval_run_123456',
        'last_id' => 'eval_run_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function evalRunDeleteResource(): array
{
    return [
        'id' => 'eval_run_123456',
        'object' => 'eval.run.deleted',
        'deleted' => true,
    ];
}
