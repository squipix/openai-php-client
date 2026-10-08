<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Batches;

/**
 * @phpstan-type BatchRequestCountsType array{processing: int, succeeded: int, errored: int, canceled: int, expired: int}
 */
final class BatchRequestCounts
{
    private function __construct(
        public readonly int $processing,
        public readonly int $succeeded,
        public readonly int $errored,
        public readonly int $canceled,
        public readonly int $expired,
    ) {}

    /**
     * @param  BatchRequestCountsType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            processing: $attributes['processing'],
            succeeded: $attributes['succeeded'],
            errored: $attributes['errored'],
            canceled: $attributes['canceled'],
            expired: $attributes['expired'],
        );
    }

    /**
     * @return BatchRequestCountsType
     */
    public function toArray(): array
    {
        return [
            'processing' => $this->processing,
            'succeeded' => $this->succeeded,
            'errored' => $this->errored,
            'canceled' => $this->canceled,
            'expired' => $this->expired,
        ];
    }
}
