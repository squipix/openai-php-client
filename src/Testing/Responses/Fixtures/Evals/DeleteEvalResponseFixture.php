<?php

namespace OpenAI\Testing\Responses\Fixtures\Evals;

final class DeleteEvalResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'eval_123456',
        'object' => 'eval.deleted',
        'deleted' => true,
    ];
}
