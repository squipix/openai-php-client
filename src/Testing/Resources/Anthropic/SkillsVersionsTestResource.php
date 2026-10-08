<?php

namespace OpenAI\Testing\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\SkillsVersionsContract;
use OpenAI\Resources\Anthropic\SkillsVersions;
use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListVersionsResponse;
use OpenAI\Responses\Anthropic\Skills\SkillVersionResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class SkillsVersionsTestResource implements SkillsVersionsContract
{
    use Testable;

    protected function resource(): string
    {
        return SkillsVersions::class;
    }

    public function create(string $skillId, array $parameters): SkillVersionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(string $skillId, array $parameters = []): ListVersionsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $skillId, string $version): SkillVersionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $skillId, string $version): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
