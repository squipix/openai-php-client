<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Anthropic\Messages\Usage;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * Top-level message changes near the end of a stream: the stop reason and the cumulative usage.
 *
 * @phpstan-import-type UsageType from Usage
 *
 * @phpstan-type MessageDeltaType array{type: 'message_delta', delta: array{stop_reason?: ?string, stop_sequence?: ?string, stop_details?: ?array<string, mixed>}, usage: UsageType}
 *
 * @implements ResponseContract<MessageDeltaType>
 */
final class MessageDelta implements ResponseContract
{
    /**
     * @use ArrayAccessible<MessageDeltaType>
     */
    use ArrayAccessible;

    /**
     * @param  'message_delta'  $type
     * @param  array<string, mixed>|null  $stopDetails
     */
    private function __construct(
        public readonly string $type,
        public readonly ?string $stopReason,
        public readonly ?string $stopSequence,
        public readonly ?array $stopDetails,
        public readonly Usage $usage,
    ) {}

    /**
     * @param  MessageDeltaType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            stopReason: $attributes['delta']['stop_reason'] ?? null,
            stopSequence: $attributes['delta']['stop_sequence'] ?? null,
            stopDetails: $attributes['delta']['stop_details'] ?? null,
            usage: Usage::from($attributes['usage']),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $delta = [
            'stop_reason' => $this->stopReason,
            'stop_sequence' => $this->stopSequence,
        ];

        if ($this->stopDetails !== null) {
            $delta['stop_details'] = $this->stopDetails;
        }

        return [
            'type' => $this->type,
            'delta' => $delta,
            'usage' => $this->usage->toArray(),
        ];
    }
}
