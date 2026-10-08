<?php

namespace OpenAI\Testing\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\ModelsContract;
use OpenAI\Resources\Anthropic\Models;
use OpenAI\Responses\Anthropic\Models\ListResponse;
use OpenAI\Responses\Anthropic\Models\RetrieveResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class ModelsTestResource implements ModelsContract
{
    use Testable;

    protected function resource(): string
    {
        return Models::class;
    }

    public function list(array $parameters = []): ListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $model): RetrieveResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
