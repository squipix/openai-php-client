<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Content;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type RedactedThinkingBlockType array{type: 'redacted_thinking', data: string}
 *
 * @implements ResponseContract<RedactedThinkingBlockType>
 */
final class RedactedThinkingBlock implements ResponseContract
{
    /**
     * @use ArrayAccessible<RedactedThinkingBlockType>
     */
    use ArrayAccessible;

    /**
     * @param  'redacted_thinking'  $type
     */
    private function __construct(
        public readonly string $type,
        public readonly string $data,
    ) {}

    /**
     * @param  RedactedThinkingBlockType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            data: $attributes['data'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
        ];
    }
}
