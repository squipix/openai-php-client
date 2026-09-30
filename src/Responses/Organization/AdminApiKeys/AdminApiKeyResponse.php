<?php

declare(strict_types=1);

namespace OpenAI\Responses\Organization\AdminApiKeys;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type AdminApiKeyResponseType array{id: string, object: string, name: string, redacted_value?: string|null, value?: string|null, created_at: int, owner?: array<string, mixed>|null}
 *
 * @implements ResponseContract<AdminApiKeyResponseType>
 */
final class AdminApiKeyResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<AdminApiKeyResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>|null  $owner
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $name,
        public readonly ?string $redactedValue,
        public readonly ?string $value,
        public readonly int $createdAt,
        public readonly ?array $owner,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  AdminApiKeyResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            name: $attributes['name'],
            redactedValue: $attributes['redacted_value'] ?? null,
            value: $attributes['value'] ?? null,
            createdAt: $attributes['created_at'],
            owner: $attributes['owner'] ?? null,
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
            'redacted_value' => $this->redactedValue,
            'value' => $this->value,
            'created_at' => $this->createdAt,
            'owner' => $this->owner,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
