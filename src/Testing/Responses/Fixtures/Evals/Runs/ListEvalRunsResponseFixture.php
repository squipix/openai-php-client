<?php

namespace OpenAI\Testing\Responses\Fixtures\Evals\Runs;

final class ListEvalRunsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            EvalRunResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'eval_run_123456',
        'last_id' => 'eval_run_123456',
        'has_more' => false,
    ];
}
