<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\EvalsRunsContract;
use OpenAI\Resources\EvalsRuns;
use OpenAI\Responses\Evals\Runs\DeleteEvalRunResponse;
use OpenAI\Responses\Evals\Runs\EvalRunResponse;
use OpenAI\Responses\Evals\Runs\ListEvalRunsResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class EvalsRunsTestResource implements EvalsRunsContract
{
    use Testable;

    protected function resource(): string
    {
        return EvalsRuns::class;
    }

    public function create(string $evalId, array $parameters): EvalRunResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $evalId, string $runId): EvalRunResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(string $evalId, array $parameters = []): ListEvalRunsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function cancel(string $evalId, string $runId): EvalRunResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $evalId, string $runId): DeleteEvalRunResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
