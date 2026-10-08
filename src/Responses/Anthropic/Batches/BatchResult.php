<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Batches;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Meta\MetaInformation;

/**
 * One line of a batch results file. `message` is set when `type` is `succeeded`,
 * `error` when it is `errored`; `canceled` and `expired` carry neither.
 *
 * @phpstan-import-type CreateResponseType from CreateResponse
 *
 * @phpstan-type BatchResultType array{custom_id: string, result: array{type: 'succeeded'|'errored'|'canceled'|'expired', message?: CreateResponseType, error?: array<string, mixed>}}
 *
 * @implements ResponseContract<BatchResultType>
 */
final class BatchResult implements ResponseContract
{
    /**
     * @use ArrayAccessible<BatchResultType>
     */
    use ArrayAccessible;

    /**
     * @param  'succeeded'|'errored'|'canceled'|'expired'  $type
     * @param  array<string, mixed>|null  $error
     */
    private function __construct(
        public readonly string $customId,
        public readonly string $type,
        public readonly ?CreateResponse $message,
        public readonly ?array $error,
    ) {}

    /**
     * @param  BatchResultType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $result = $attributes['result'];

        return new self(
            customId: $attributes['custom_id'],
            type: $result['type'],
            message: isset($result['message']) ? CreateResponse::from($result['message'], $meta) : null,
            error: $result['error'] ?? null,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $result = ['type' => $this->type];

        if ($this->message instanceof CreateResponse) {
            $result['message'] = $this->message->toArray();
        }

        if ($this->error !== null) {
            $result['error'] = $this->error;
        }

        return [
            'custom_id' => $this->customId,
            'result' => $result,
        ];
    }
}
