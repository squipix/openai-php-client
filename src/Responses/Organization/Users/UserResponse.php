<?php

declare(strict_types=1);

namespace OpenAI\Responses\Organization\Users;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type UserResponseType array{id: string, object: string, name?: string|null, email?: string|null, role: string, added_at: int}
 *
 * @implements ResponseContract<UserResponseType>
 */
final class UserResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<UserResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly string $role,
        public readonly int $addedAt,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  UserResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            name: $attributes['name'] ?? null,
            email: $attributes['email'] ?? null,
            role: $attributes['role'],
            addedAt: $attributes['added_at'],
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'added_at' => $this->addedAt,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
