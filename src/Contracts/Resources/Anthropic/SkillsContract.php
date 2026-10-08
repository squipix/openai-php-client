<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListResponse;
use OpenAI\Responses\Anthropic\Skills\SkillResponse;

interface SkillsContract
{
    /**
     * Creates a custom skill from uploaded files (a `SKILL.md` at the top-level folder plus any resources).
     *
     * @see https://docs.claude.com/en/api/skills/create-skill
     *
     * @param  array<string, mixed>  $parameters  `['display_name' => ..., 'files' => [fopen(...), ...]]`
     */
    public function create(array $parameters): SkillResponse;

    /**
     * Lists skills.
     *
     * @see https://docs.claude.com/en/api/skills/list-skills
     *
     * @param  array<string, mixed>  $parameters  e.g. `limit`, `page`, `source`
     */
    public function list(array $parameters = []): ListResponse;

    /**
     * Retrieves a skill.
     *
     * @see https://docs.claude.com/en/api/skills/get-skill
     */
    public function retrieve(string $id): SkillResponse;

    /**
     * Deletes a skill. All of its versions must be deleted first.
     *
     * @see https://docs.claude.com/en/api/skills/delete-skill
     */
    public function delete(string $id): DeleteResponse;

    /**
     * Manage the versions of a skill.
     */
    public function versions(): SkillsVersionsContract;
}
