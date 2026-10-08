<?php

declare(strict_types=1);

namespace OpenAI\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\SkillsVersionsContract;
use OpenAI\Resources\Concerns\Transportable;
use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListVersionsResponse;
use OpenAI\Responses\Anthropic\Skills\SkillVersionResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type SkillVersionResponseType from SkillVersionResponse
 * @phpstan-import-type ListVersionsResponseType from ListVersionsResponse
 * @phpstan-import-type DeleteResponseType from DeleteResponse
 */
final class SkillsVersions implements SkillsVersionsContract
{
    use Transportable;

    /**
     * Creates a new version of a skill from uploaded files.
     *
     * @see https://docs.claude.com/en/api/skills/create-skill-version
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(string $skillId, array $parameters): SkillVersionResponse
    {
        $payload = Payload::upload('skills/'.rawurlencode($skillId).'/versions', $parameters);

        /** @var Response<SkillVersionResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return SkillVersionResponse::from($response->data(), $response->meta());
    }

    /**
     * Lists the versions of a skill.
     *
     * @see https://docs.claude.com/en/api/skills/list-skill-versions
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(string $skillId, array $parameters = []): ListVersionsResponse
    {
        $payload = Payload::list('skills/'.rawurlencode($skillId).'/versions', $parameters);

        /** @var Response<ListVersionsResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListVersionsResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a version of a skill.
     *
     * @see https://docs.claude.com/en/api/skills/get-skill-version
     */
    public function retrieve(string $skillId, string $version): SkillVersionResponse
    {
        $payload = Payload::retrieve('skills/'.rawurlencode($skillId).'/versions', $version);

        /** @var Response<SkillVersionResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return SkillVersionResponse::from($response->data(), $response->meta());
    }

    /**
     * Deletes a version of a skill.
     *
     * @see https://docs.claude.com/en/api/skills/delete-skill-version
     */
    public function delete(string $skillId, string $version): DeleteResponse
    {
        $payload = Payload::delete('skills/'.rawurlencode($skillId).'/versions', $version);

        /** @var Response<DeleteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteResponse::from($response->data(), $response->meta());
    }
}
