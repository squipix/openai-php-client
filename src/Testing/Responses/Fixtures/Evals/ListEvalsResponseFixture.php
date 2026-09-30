<?php

namespace OpenAI\Testing\Responses\Fixtures\Evals;

final class ListEvalsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            EvalResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'eval_123456',
        'last_id' => 'eval_123456',
        'has_more' => false,
    ];
}
