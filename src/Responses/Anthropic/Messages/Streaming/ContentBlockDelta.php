<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ContentBlockDeltaType array{type: 'content_block_delta', index: int, delta: array<string, mixed>}
 *
 * @implements ResponseContract<ContentBlockDeltaType>
 */
final class ContentBlockDelta implements ResponseContract
{
    /**
     * @use ArrayAccessible<ContentBlockDeltaType>
     */
    use ArrayAccessible;

    /**
     * @param  'content_block_delta'  $type
     */
    private function __construct(
        public readonly string $type,
        public readonly int $index,
        public readonly Delta $delta,
    ) {}

    /**
     * @param  ContentBlockDeltaType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            index: $attributes['index'],
            delta: Delta::from($attributes['delta']),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'index' => $this->index,
            'delta' => $this->delta->toArray(),
        ];
    }
}
