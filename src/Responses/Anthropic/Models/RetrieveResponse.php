<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Models;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type RetrieveResponseType array{type: string, id: string, display_name: string, created_at: string, max_input_tokens?: ?int, max_tokens?: ?int, capabilities?: ?array<string, mixed>}
 *
 * @implements ResponseContract<RetrieveResponseType>
 */
final class RetrieveResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<RetrieveResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>|null  $capabilities
     */
    private function __construct(
        public readonly string $type,
        public readonly string $id,
        public readonly string $displayName,
        public readonly string $createdAt,
        public readonly ?int $maxInputTokens,
        public readonly ?int $maxTokens,
        public readonly ?array $capabilities,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  RetrieveResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            type: $attributes['type'],
            id: $attributes['id'],
            displayName: $attributes['display_name'],
            createdAt: $attributes['created_at'],
            maxInputTokens: $attributes['max_input_tokens'] ?? null,
            maxTokens: $attributes['max_tokens'] ?? null,
            capabilities: $attributes['capabilities'] ?? null,
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'id' => $this->id,
            'display_name' => $this->displayName,
            'created_at' => $this->createdAt,
            'max_input_tokens' => $this->maxInputTokens,
            'max_tokens' => $this->maxTokens,
            'capabilities' => $this->capabilities,
        ], fn (mixed $value): bool => $value !== null);
    }
}
