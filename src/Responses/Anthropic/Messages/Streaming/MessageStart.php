<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Meta\MetaInformation;

/**
 * First event of a stream: the message with empty content and the initial usage,
 * including the prompt-cache read/write token counts.
 *
 * @phpstan-import-type CreateResponseType from CreateResponse
 *
 * @phpstan-type MessageStartType array{type: 'message_start', message: CreateResponseType}
 *
 * @implements ResponseContract<MessageStartType>
 */
final class MessageStart implements ResponseContract
{
    /**
     * @use ArrayAccessible<MessageStartType>
     */
    use ArrayAccessible;

    /**
     * @param  'message_start'  $type
     */
    private function __construct(
        public readonly string $type,
        public readonly CreateResponse $message,
    ) {}

    /**
     * @param  MessageStartType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            type: $attributes['type'],
            message: CreateResponse::from($attributes['message'], $meta),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message->toArray(),
        ];
    }
}
