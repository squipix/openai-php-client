<?php

namespace OpenAI\Testing\Responses\Fixtures\Evals\Runs;

final class EvalRunResponseFixture
{
    public const ATTRIBUTES = [
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
