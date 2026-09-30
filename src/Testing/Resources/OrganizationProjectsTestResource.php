<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\OrganizationProjectsContract;
use OpenAI\Resources\OrganizationProjects;
use OpenAI\Responses\Organization\Projects\ListProjectsResponse;
use OpenAI\Responses\Organization\Projects\ProjectResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class OrganizationProjectsTestResource implements OrganizationProjectsContract
{
    use Testable;

    protected function resource(): string
    {
        return OrganizationProjects::class;
    }

    public function list(array $parameters = []): ListProjectsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function create(array $parameters): ProjectResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $projectId): ProjectResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function modify(string $projectId, array $parameters): ProjectResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function archive(string $projectId): ProjectResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
