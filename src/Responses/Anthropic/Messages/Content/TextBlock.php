<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Content;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type TextBlockType array{type: 'text', text: string, citations?: ?array<int, array<string, mixed>>}
 *
 * @implements ResponseContract<TextBlockType>
 */
final class TextBlock implements ResponseContract
{
    /**
     * @use ArrayAccessible<TextBlockType>
     */
    use ArrayAccessible;

    /**
     * @param  'text'  $type
     * @param  array<int, array<string, mixed>>|null  $citations
     */
    private function __construct(
        public readonly string $type,
        public readonly string $text,
        public readonly ?array $citations,
    ) {}

    /**
     * @param  TextBlockType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            text: $attributes['text'],
            citations: $attributes['citations'] ?? null,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'text' => $this->text,
            'citations' => $this->citations,
        ], fn (mixed $value): bool => $value !== null);
    }
}
