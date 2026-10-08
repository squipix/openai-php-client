<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Content;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * Any content block without a dedicated class, e.g. `web_search_tool_result`, `container_upload`
 * or a block type added to the API later. The raw block is kept in `attributes`.
 *
 * @phpstan-type GenericBlockType array<string, mixed>
 *
 * @implements ResponseContract<GenericBlockType>
 */
final class GenericBlock implements ResponseContract
{
    /**
     * @use ArrayAccessible<GenericBlockType>
     */
    use ArrayAccessible;

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function __construct(
        public readonly string $type,
        public readonly array $attributes,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: is_string($attributes['type'] ?? null) ? $attributes['type'] : 'unknown',
            attributes: $attributes,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
