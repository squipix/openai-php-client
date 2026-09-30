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
 * @phpstan-type ChatkitThreadItemResponseType array{id: string, object: string, created_at: int, type?: string|null, content?: mixed}
 *
 * @implements ResponseContract<ChatkitThreadItemResponseType>
 */
final class ThreadItemResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ChatkitThreadItemResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $createdAt,
        public readonly ?string $type,
        public readonly mixed $content,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ChatkitThreadItemResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            createdAt: $attributes['created_at'],
            type: $attributes['type'] ?? null,
            content: $attributes['content'] ?? null,
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
            'type' => $this->type,
            'content' => $this->content,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
