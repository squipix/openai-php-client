<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListVersionsResponse;
use OpenAI\Responses\Anthropic\Skills\SkillVersionResponse;

interface SkillsVersionsContract
{
    /**
     * Creates a new version of a skill from uploaded files.
     *
     * @see https://docs.claude.com/en/api/skills/create-skill-version
     *
     * @param  array<string, mixed>  $parameters  `['files' => [fopen(...), ...]]`
     */
    public function create(string $skillId, array $parameters): SkillVersionResponse;

    /**
     * Lists the versions of a skill.
     *
     * @see https://docs.claude.com/en/api/skills/list-skill-versions
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(string $skillId, array $parameters = []): ListVersionsResponse;

    /**
     * Retrieves a version of a skill.
     *
     * @see https://docs.claude.com/en/api/skills/get-skill-version
     */
    public function retrieve(string $skillId, string $version): SkillVersionResponse;

    /**
     * Deletes a version of a skill.
     *
     * @see https://docs.claude.com/en/api/skills/delete-skill-version
     */
    public function delete(string $skillId, string $version): DeleteResponse;
}
