<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Organization\Projects\ListProjectsResponse;
use OpenAI\Responses\Organization\Projects\ProjectResponse;

interface OrganizationProjectsContract
{
    /**
     * Returns a list of projects.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListProjectsResponse;

    /**
     * Create a new project in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): ProjectResponse;

    /**
     * Retrieves a project.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/retrieve
     */
    public function retrieve(string $projectId): ProjectResponse;

    /**
     * Modifies a project in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/modify
     *
     * @param  array<string, mixed>  $parameters
     */
    public function modify(string $projectId, array $parameters): ProjectResponse;

    /**
     * Archives a project in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/archive
     */
    public function archive(string $projectId): ProjectResponse;
}
