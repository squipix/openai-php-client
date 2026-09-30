<?php

declare(strict_types=1);

namespace OpenAI\Responses\Organization\Invites;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type InviteResponseType from InviteResponse
 *
 * @phpstan-type ListInvitesResponseType array{object: string, data: array<int, InviteResponseType>, first_id?: string|null, last_id?: string|null, has_more?: bool|null}
 *
 * @implements ResponseContract<ListInvitesResponseType>
 */
final class ListInvitesResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ListInvitesResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<int, InviteResponse>  $data
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
     * @param  ListInvitesResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $data = array_map(fn (array $result): InviteResponse => InviteResponse::from(
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
                static fn (InviteResponse $response): array => $response->toArray(),
                $this->data,
            ),
            'first_id' => $this->firstId,
            'last_id' => $this->lastId,
            'has_more' => $this->hasMore,
        ];
    }
}
