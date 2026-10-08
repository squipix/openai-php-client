<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Models;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type RetrieveResponseType from RetrieveResponse
 *
 * @phpstan-type ListResponseType array{data: array<int, RetrieveResponseType>, has_more: bool, first_id: ?string, last_id: ?string}
 *
 * @implements ResponseContract<ListResponseType>
 */
final class ListResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ListResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<int, RetrieveResponse>  $data
     */
    private function __construct(
        public readonly array $data,
        public readonly bool $hasMore,
        public readonly ?string $firstId,
        public readonly ?string $lastId,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ListResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            data: array_map(fn (array $model): RetrieveResponse => RetrieveResponse::from($model, $meta), $attributes['data']),
            hasMore: $attributes['has_more'],
            firstId: $attributes['first_id'],
            lastId: $attributes['last_id'],
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(fn (RetrieveResponse $model): array => $model->toArray(), $this->data),
            'has_more' => $this->hasMore,
            'first_id' => $this->firstId,
            'last_id' => $this->lastId,
        ];
    }
}
