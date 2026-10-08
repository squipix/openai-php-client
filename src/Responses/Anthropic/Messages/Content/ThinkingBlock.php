<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Content;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * Pass thinking blocks back unchanged (including the signature) when continuing a conversation.
 *
 * @phpstan-type ThinkingBlockType array{type: 'thinking', thinking: string, signature: string}
 *
 * @implements ResponseContract<ThinkingBlockType>
 */
final class ThinkingBlock implements ResponseContract
{
    /**
     * @use ArrayAccessible<ThinkingBlockType>
     */
    use ArrayAccessible;

    /**
     * @param  'thinking'  $type
     */
    private function __construct(
        public readonly string $type,
        public readonly string $thinking,
        public readonly string $signature,
    ) {}

    /**
     * @param  ThinkingBlockType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            thinking: $attributes['thinking'],
            signature: $attributes['signature'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'thinking' => $this->thinking,
            'signature' => $this->signature,
        ];
    }
}
