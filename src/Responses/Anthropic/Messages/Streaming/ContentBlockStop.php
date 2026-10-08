<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ContentBlockStopType array{type: 'content_block_stop', index: int}
 *
 * @implements ResponseContract<ContentBlockStopType>
 */
final class ContentBlockStop implements ResponseContract
{
    /**
     * @use ArrayAccessible<ContentBlockStopType>
     */
    use ArrayAccessible;

    /**
     * @param  'content_block_stop'  $type
     */
    private function __construct(
        public readonly string $type,
        public readonly int $index,
    ) {}

    /**
     * @param  ContentBlockStopType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['type'], $attributes['index']);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'index' => $this->index,
        ];
    }
}
