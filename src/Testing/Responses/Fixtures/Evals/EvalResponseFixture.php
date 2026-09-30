<?php

namespace OpenAI\Testing\Responses\Fixtures\Evals;

final class EvalResponseFixture
{
    public const ATTRIBUTES = [
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
