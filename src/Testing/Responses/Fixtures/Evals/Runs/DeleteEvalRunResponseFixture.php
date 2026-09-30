<?php

namespace OpenAI\Testing\Responses\Fixtures\Evals\Runs;

final class DeleteEvalRunResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'eval_run_123456',
        'object' => 'eval.run.deleted',
        'deleted' => true,
    ];
}
