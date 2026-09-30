<?php

declare(strict_types=1);

namespace OpenAI\Responses\Organization\Projects;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type ProjectResponseType array{id: string, object: string, name: string, created_at: int, archived_at?: int|null, status: string}
 *
 * @implements ResponseContract<ProjectResponseType>
 */
final class ProjectResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ProjectResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $name,
        public readonly int $createdAt,
        public readonly ?int $archivedAt,
        public readonly string $status,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ProjectResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            name: $attributes['name'],
            createdAt: $attributes['created_at'],
            archivedAt: $attributes['archived_at'] ?? null,
            status: $attributes['status'],
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
            'object' => $this->object,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'archived_at' => $this->archivedAt,
            'status' => $this->status,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
