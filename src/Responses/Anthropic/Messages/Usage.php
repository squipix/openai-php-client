<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages;

/**
 * Token usage, including prompt-cache reads and writes.
 *
 * `inputTokens` counts only the uncached input after the last cache breakpoint;
 * use {@see totalInputTokens()} for the full prompt size.
 *
 * @phpstan-import-type UsageCacheCreationType from UsageCacheCreation
 *
 * @phpstan-type UsageType array{input_tokens?: ?int, output_tokens: int, cache_creation_input_tokens?: ?int, cache_read_input_tokens?: ?int, cache_creation?: ?UsageCacheCreationType, server_tool_use?: ?array<string, int>, service_tier?: ?string, inference_geo?: ?string}
 */
final class Usage
{
    /**
     * @param  array<string, int>|null  $serverToolUse
     */
    private function __construct(
        public readonly int $inputTokens,
        public readonly int $outputTokens,
        public readonly ?int $cacheCreationInputTokens,
        public readonly ?int $cacheReadInputTokens,
        public readonly ?UsageCacheCreation $cacheCreation,
        public readonly ?array $serverToolUse,
        public readonly ?string $serviceTier,
        public readonly ?string $inferenceGeo,
    ) {}

    /**
     * @param  UsageType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            inputTokens: $attributes['input_tokens'] ?? 0,
            outputTokens: $attributes['output_tokens'],
            cacheCreationInputTokens: $attributes['cache_creation_input_tokens'] ?? null,
            cacheReadInputTokens: $attributes['cache_read_input_tokens'] ?? null,
            cacheCreation: isset($attributes['cache_creation']) ? UsageCacheCreation::from($attributes['cache_creation']) : null,
            serverToolUse: $attributes['server_tool_use'] ?? null,
            serviceTier: $attributes['service_tier'] ?? null,
            inferenceGeo: $attributes['inference_geo'] ?? null,
        );
    }

    /**
     * All input tokens of the request: uncached + written to cache + read from cache.
     */
    public function totalInputTokens(): int
    {
        return $this->inputTokens + ($this->cacheCreationInputTokens ?? 0) + ($this->cacheReadInputTokens ?? 0);
    }

    /**
     * @return array{input_tokens: int, output_tokens: int, cache_creation_input_tokens?: int, cache_read_input_tokens?: int, cache_creation?: array{ephemeral_5m_input_tokens: int, ephemeral_1h_input_tokens: int}, server_tool_use?: array<string, int>, service_tier?: string, inference_geo?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'input_tokens' => $this->inputTokens,
            'output_tokens' => $this->outputTokens,
            'cache_creation_input_tokens' => $this->cacheCreationInputTokens,
            'cache_read_input_tokens' => $this->cacheReadInputTokens,
            'cache_creation' => $this->cacheCreation?->toArray(),
            'server_tool_use' => $this->serverToolUse,
            'service_tier' => $this->serviceTier,
            'inference_geo' => $this->inferenceGeo,
        ], fn (mixed $value): bool => $value !== null);
    }
}
