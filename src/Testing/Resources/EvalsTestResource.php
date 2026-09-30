<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\EvalsContract;
use OpenAI\Resources\Evals;
use OpenAI\Responses\Evals\DeleteEvalResponse;
use OpenAI\Responses\Evals\EvalResponse;
use OpenAI\Responses\Evals\ListEvalsResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class EvalsTestResource implements EvalsContract
{
    use Testable;

    protected function resource(): string
    {
        return Evals::class;
    }

    public function create(array $parameters): EvalResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $id): EvalResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function update(string $id, array $parameters): EvalResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $id): DeleteEvalResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(array $parameters = []): ListEvalsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function runs(): EvalsRunsTestResource
    {
        return new EvalsRunsTestResource($this->fake);
    }
}
