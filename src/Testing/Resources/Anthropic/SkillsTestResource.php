<?php

namespace OpenAI\Testing\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\SkillsContract;
use OpenAI\Resources\Anthropic\Skills;
use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListResponse;
use OpenAI\Responses\Anthropic\Skills\SkillResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class SkillsTestResource implements SkillsContract
{
    use Testable;

    protected function resource(): string
    {
        return Skills::class;
    }

    public function create(array $parameters): SkillResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(array $parameters = []): ListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $id): SkillResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $id): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function versions(): SkillsVersionsTestResource
    {
        return new SkillsVersionsTestResource($this->fake);
    }
}
