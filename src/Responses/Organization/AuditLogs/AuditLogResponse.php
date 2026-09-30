<?php

declare(strict_types=1);

namespace OpenAI\Responses\Organization\AuditLogs;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type AuditLogResponseType array{id: string, type: string, effective_at: int, actor: array<string, mixed>, api_key?: array<string, mixed>|null, invite?: array<string, mixed>|null, user?: array<string, mixed>|null, project?: array<string, mixed>|null}
 *
 * @implements ResponseContract<AuditLogResponseType>
 */
final class AuditLogResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<AuditLogResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>  $actor
     * @param  array<string, mixed>|null  $apiKey
     * @param  array<string, mixed>|null  $invite
     * @param  array<string, mixed>|null  $user
     * @param  array<string, mixed>|null  $project
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly int $effectiveAt,
        public readonly array $actor,
        public readonly ?array $apiKey,
        public readonly ?array $invite,
        public readonly ?array $user,
        public readonly ?array $project,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  AuditLogResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            type: $attributes['type'],
            effectiveAt: $attributes['effective_at'],
            actor: $attributes['actor'],
            apiKey: $attributes['api_key'] ?? null,
            invite: $attributes['invite'] ?? null,
            user: $attributes['user'] ?? null,
            project: $attributes['project'] ?? null,
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'type' => $this->type,
            'effective_at' => $this->effectiveAt,
            'actor' => $this->actor,
            'api_key' => $this->apiKey,
            'invite' => $this->invite,
            'user' => $this->user,
            'project' => $this->project,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
