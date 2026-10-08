<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Skills;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type SkillVersionResponseType from SkillVersionResponse
 *
 * @phpstan-type ListVersionsResponseType array{data: array<int, SkillVersionResponseType>, has_more: bool, first_id: ?string, last_id: ?string}
 *
 * @implements ResponseContract<ListVersionsResponseType>
 */
final class ListVersionsResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ListVersionsResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<int, SkillVersionResponse>  $data
     */
    private function __construct(
        public readonly array $data,
        public readonly bool $hasMore,
        public readonly ?string $firstId,
        public readonly ?string $lastId,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ListVersionsResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            data: array_map(fn (array $version): SkillVersionResponse => SkillVersionResponse::from($version, $meta), $attributes['data']),
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
            'data' => array_map(fn (SkillVersionResponse $version): array => $version->toArray(), $this->data),
            'has_more' => $this->hasMore,
            'first_id' => $this->firstId,
            'last_id' => $this->lastId,
        ];
    }
}
