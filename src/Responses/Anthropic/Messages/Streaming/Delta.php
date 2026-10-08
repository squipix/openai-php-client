<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

/**
 * The `delta` of a `content_block_delta` event. Which field is set depends on `type`:
 * `text_delta` → text, `input_json_delta` → partialJson, `thinking_delta` → thinking,
 * `signature_delta` → signature, `citations_delta` → citation. Other types keep the raw delta.
 *
 * @phpstan-type DeltaType array<string, mixed>
 */
final class Delta
{
    /**
     * @param  array<string, mixed>|null  $citation
     * @param  array<string, mixed>  $attributes
     */
    private function __construct(
        public readonly string $type,
        public readonly ?string $text,
        public readonly ?string $partialJson,
        public readonly ?string $thinking,
        public readonly ?string $signature,
        public readonly ?array $citation,
        private readonly array $attributes,
    ) {}

    /**
     * @param  DeltaType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: self::stringOrNull($attributes['type'] ?? null) ?? 'unknown',
            text: self::stringOrNull($attributes['text'] ?? null),
            partialJson: self::stringOrNull($attributes['partial_json'] ?? null),
            thinking: self::stringOrNull($attributes['thinking'] ?? null),
            signature: self::stringOrNull($attributes['signature'] ?? null),
            citation: is_array($attributes['citation'] ?? null) ? $attributes['citation'] : null, // @phpstan-ignore-line
            attributes: $attributes,
        );
    }

    /**
     * @return DeltaType
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    private static function stringOrNull(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }
}
