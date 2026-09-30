<?php

declare(strict_types=1);

namespace OpenAI\Responses\Audio\VoiceConsents;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type VoiceConsentResponseType array{id: string, object: string, created_at: int, language: string, name: string}
 *
 * @implements ResponseContract<VoiceConsentResponseType>
 */
final class VoiceConsentResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<VoiceConsentResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $createdAt,
        public readonly string $language,
        public readonly string $name,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  VoiceConsentResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            createdAt: $attributes['created_at'],
            language: $attributes['language'],
            name: $attributes['name'],
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
            'object' => $this->object,
            'created_at' => $this->createdAt,
            'language' => $this->language,
            'name' => $this->name,
        ];
    }
}
