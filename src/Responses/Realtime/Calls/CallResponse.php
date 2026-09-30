<?php

declare(strict_types=1);

namespace OpenAI\Responses\Realtime\Calls;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type CallResponseType array{id: string, object: string, status?: string|null, sdp?: string|null}
 *
 * @implements ResponseContract<CallResponseType>
 */
final class CallResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<CallResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly ?string $status,
        public readonly ?string $sdp,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  CallResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            status: $attributes['status'] ?? null,
            sdp: $attributes['sdp'] ?? null,
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'object' => $this->object,
            'status' => $this->status,
            'sdp' => $this->sdp,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
