<?php

declare(strict_types=1);

namespace OpenAI\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\SkillsContract;
use OpenAI\Resources\Concerns\Transportable;
use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListResponse;
use OpenAI\Responses\Anthropic\Skills\SkillResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type SkillResponseType from SkillResponse
 * @phpstan-import-type ListResponseType from ListResponse
 * @phpstan-import-type DeleteResponseType from DeleteResponse
 */
final class Skills implements SkillsContract
{
    use Transportable;

    /**
     * Creates a custom skill from uploaded files.
     *
     * @see https://docs.claude.com/en/api/skills/create-skill
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): SkillResponse
    {
        $payload = Payload::upload('skills', $parameters);

        /** @var Response<SkillResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return SkillResponse::from($response->data(), $response->meta());
    }

    /**
     * Lists skills.
     *
     * @see https://docs.claude.com/en/api/skills/list-skills
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListResponse
    {
        $payload = Payload::list('skills', $parameters);

        /** @var Response<ListResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a skill.
     *
     * @see https://docs.claude.com/en/api/skills/get-skill
     */
    public function retrieve(string $id): SkillResponse
    {
        $payload = Payload::retrieve('skills', $id);

        /** @var Response<SkillResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return SkillResponse::from($response->data(), $response->meta());
    }

    /**
     * Deletes a skill. All of its versions must be deleted first.
     *
     * @see https://docs.claude.com/en/api/skills/delete-skill
     */
    public function delete(string $id): DeleteResponse
    {
        $payload = Payload::delete('skills', $id);

        /** @var Response<DeleteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteResponse::from($response->data(), $response->meta());
    }

    /**
     * Manage the versions of a skill.
     */
    public function versions(): SkillsVersions
    {
        return new SkillsVersions($this->transporter);
    }
}
