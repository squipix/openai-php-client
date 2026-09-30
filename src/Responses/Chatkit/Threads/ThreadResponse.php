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
 * @phpstan-type ChatkitThreadResponseType array{id: string, object: string, created_at: int, title?: string|null, user?: string|null, status?: array<string, mixed>|string|null}
 *
 * @implements ResponseContract<ChatkitThreadResponseType>
 */
final class ThreadResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ChatkitThreadResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>|string|null  $status
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $createdAt,
        public readonly ?string $title,
        public readonly ?string $user,
        public readonly array|string|null $status,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ChatkitThreadResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            createdAt: $attributes['created_at'],
            title: $attributes['title'] ?? null,
            user: $attributes['user'] ?? null,
            status: $attributes['status'] ?? null,
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
            'created_at' => $this->createdAt,
            'title' => $this->title,
            'user' => $this->user,
            'status' => $this->status,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
