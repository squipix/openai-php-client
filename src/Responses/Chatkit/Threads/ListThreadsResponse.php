<?php

declare(strict_types=1);

namespace OpenAI\Responses\Chatkit\Threads;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type ChatkitThreadResponseType from ThreadResponse
 *
 * @phpstan-type ListChatkitThreadsResponseType array{object: string, data: array<int, ChatkitThreadResponseType>, first_id?: string|null, last_id?: string|null, has_more?: bool|null}
 *
 * @implements ResponseContract<ListChatkitThreadsResponseType>
 */
final class ListThreadsResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ListChatkitThreadsResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<int, ThreadResponse>  $data
     */
    private function __construct(
        public readonly string $object,
        public readonly array $data,
        public readonly ?string $firstId,
        public readonly ?string $lastId,
        public readonly bool $hasMore,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ListChatkitThreadsResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $data = array_map(fn (array $result): ThreadResponse => ThreadResponse::from(
            $result,
            $meta,
        ), $attributes['data']);

        return new self(
            object: $attributes['object'],
            data: $data,
            firstId: $attributes['first_id'] ?? null,
            lastId: $attributes['last_id'] ?? null,
            hasMore: $attributes['has_more'] ?? false,
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'object' => $this->object,
            'data' => array_map(
                static fn (ThreadResponse $response): array => $response->toArray(),
                $this->data,
            ),
            'first_id' => $this->firstId,
            'last_id' => $this->lastId,
            'has_more' => $this->hasMore,
        ];
    }
}
