<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages;

/**
 * Cache-write tokens split by cache TTL.
 *
 * @phpstan-type UsageCacheCreationType array{ephemeral_5m_input_tokens?: ?int, ephemeral_1h_input_tokens?: ?int}
 */
final class UsageCacheCreation
{
    private function __construct(
        public readonly int $ephemeral5mInputTokens,
        public readonly int $ephemeral1hInputTokens,
    ) {}

    /**
     * @param  UsageCacheCreationType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            ephemeral5mInputTokens: $attributes['ephemeral_5m_input_tokens'] ?? 0,
            ephemeral1hInputTokens: $attributes['ephemeral_1h_input_tokens'] ?? 0,
        );
    }

    /**
     * @return array{ephemeral_5m_input_tokens: int, ephemeral_1h_input_tokens: int}
     */
    public function toArray(): array
    {
        return [
            'ephemeral_5m_input_tokens' => $this->ephemeral5mInputTokens,
            'ephemeral_1h_input_tokens' => $this->ephemeral1hInputTokens,
        ];
    }
}
