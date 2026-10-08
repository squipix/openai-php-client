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
 * @phpstan-type SkillVersionResponseType array{id: string, type: 'skill_version', skill_id: string, name: string, description: string, created_at: string}
 *
 * @implements ResponseContract<SkillVersionResponseType>
 */
final class SkillVersionResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<SkillVersionResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  'skill_version'  $type
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $skillId,
        public readonly string $name,
        public readonly string $description,
        public readonly string $createdAt,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  SkillVersionResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            type: $attributes['type'],
            skillId: $attributes['skill_id'],
            name: $attributes['name'],
            description: $attributes['description'],
            createdAt: $attributes['created_at'],
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
            'skill_id' => $this->skillId,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->createdAt,
        ];
    }
}
