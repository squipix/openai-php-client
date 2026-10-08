<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type MessageStopType array{type: 'message_stop'}
 *
 * @implements ResponseContract<MessageStopType>
 */
final class MessageStop implements ResponseContract
{
    /**
     * @use ArrayAccessible<MessageStopType>
     */
    use ArrayAccessible;

    /**
     * @param  'message_stop'  $type
     */
    private function __construct(public readonly string $type) {}

    /**
     * @param  MessageStopType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['type']);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type];
    }
}
