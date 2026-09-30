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
 * @phpstan-type InviteResponseType array{id: string, object: string, email: string, role: string, status: string, invited_at: int, expires_at: int, accepted_at?: int|null, projects?: array<int, mixed>|null}
 *
 * @implements ResponseContract<InviteResponseType>
 */
final class InviteResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<InviteResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<int, mixed>|null  $projects
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $email,
        public readonly string $role,
        public readonly string $status,
        public readonly int $invitedAt,
        public readonly int $expiresAt,
        public readonly ?int $acceptedAt,
        public readonly ?array $projects,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  InviteResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            email: $attributes['email'],
            role: $attributes['role'],
            status: $attributes['status'],
            invitedAt: $attributes['invited_at'],
            expiresAt: $attributes['expires_at'],
            acceptedAt: $attributes['accepted_at'] ?? null,
            projects: $attributes['projects'] ?? null,
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
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'invited_at' => $this->invitedAt,
            'expires_at' => $this->expiresAt,
            'accepted_at' => $this->acceptedAt,
            'projects' => $this->projects,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
