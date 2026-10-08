<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Skills;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type SkillResponseType array{id: string, type: 'skill', display_name: string, latest_version_id: ?string, source: string, created_at: string, updated_at: string}
 *
 * @implements ResponseContract<SkillResponseType>
 */
final class SkillResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<SkillResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  'skill'  $type
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $displayName,
        public readonly ?string $latestVersionId,
        public readonly string $source,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  SkillResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            type: $attributes['type'],
            displayName: $attributes['display_name'],
            latestVersionId: $attributes['latest_version_id'],
            source: $attributes['source'],
            createdAt: $attributes['created_at'],
            updatedAt: $attributes['updated_at'],
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'display_name' => $this->displayName,
            'latest_version_id' => $this->latestVersionId,
            'source' => $this->source,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
