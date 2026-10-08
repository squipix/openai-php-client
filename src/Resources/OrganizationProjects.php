<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\OrganizationProjectsContract;
use OpenAI\Responses\Organization\Projects\ListProjectsResponse;
use OpenAI\Responses\Organization\Projects\ProjectResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ProjectResponseType from ProjectResponse
 * @phpstan-import-type ListProjectsResponseType from ListProjectsResponse
 */
final class OrganizationProjects implements OrganizationProjectsContract
{
    use Concerns\Transportable;

    /**
     * Returns a list of projects.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListProjectsResponse
    {
        $payload = Payload::list('organization/projects', $parameters);

        /** @var Response<ListProjectsResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListProjectsResponse::from($response->data(), $response->meta());
    }

    /**
     * Create a new project in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): ProjectResponse
    {
        $payload = Payload::create('organization/projects', $parameters);

        /** @var Response<ProjectResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ProjectResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a project.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/retrieve
     */
    public function retrieve(string $projectId): ProjectResponse
    {
        $payload = Payload::retrieve('organization/projects', $projectId);

        /** @var Response<ProjectResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ProjectResponse::from($response->data(), $response->meta());
    }

    /**
     * Modifies a project in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/modify
     *
     * @param  array<string, mixed>  $parameters
     */
    public function modify(string $projectId, array $parameters): ProjectResponse
    {
        $payload = Payload::modify('organization/projects', $projectId, $parameters);

        /** @var Response<ProjectResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ProjectResponse::from($response->data(), $response->meta());
    }

    /**
     * Archives a project in the organization.
     *
     * @see https://platform.openai.com/docs/api-reference/projects/archive
     */
    public function archive(string $projectId): ProjectResponse
    {
        $payload = Payload::create('organization/projects/'.rawurlencode($projectId).'/archive', []);

        /** @var Response<ProjectResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ProjectResponse::from($response->data(), $response->meta());
    }
}
