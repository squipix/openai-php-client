<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Exceptions\UnknownEventException;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockDelta;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockStart;
use OpenAI\Responses\Anthropic\Messages\Streaming\ContentBlockStop;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageDelta;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageStart;
use OpenAI\Responses\Anthropic\Messages\Streaming\MessageStop;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\FakeableForStreamedResponse;

/**
 * One server-sent event of a streamed message. `ping` is skipped and `error` events throw an ErrorException.
 *
 * @phpstan-type CreateStreamedResponseType array{event: string, data: array<string, mixed>}
 *
 * @implements ResponseContract<CreateStreamedResponseType>
 */
final class CreateStreamedResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreateStreamedResponseType>
     */
    use ArrayAccessible;

    use FakeableForStreamedResponse;

    private function __construct(
        public readonly string $event,
        public readonly MessageStart|ContentBlockStart|ContentBlockDelta|ContentBlockStop|MessageDelta|MessageStop $response,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        $event = $attributes['type'] ?? null;

        if (! is_string($event)) {
            throw new UnknownEventException('Missing event type in streamed response');
        }

        /** @var MetaInformation $meta */
        $meta = $attributes['__meta'];
        unset($attributes['__meta'], $attributes['__event']);

        $response = match ($event) {
            'message_start' => MessageStart::from($attributes, $meta), // @phpstan-ignore-line
            'content_block_start' => ContentBlockStart::from($attributes), // @phpstan-ignore-line
            'content_block_delta' => ContentBlockDelta::from($attributes), // @phpstan-ignore-line
            'content_block_stop' => ContentBlockStop::from($attributes), // @phpstan-ignore-line
            'message_delta' => MessageDelta::from($attributes), // @phpstan-ignore-line
            'message_stop' => MessageStop::from($attributes), // @phpstan-ignore-line
            default => throw new UnknownEventException('Unknown Anthropic messages streaming event: '.$event),
        };

        return new self($event, $response);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'event' => $this->event,
            'data' => $this->response->toArray(),
        ];
    }
}
