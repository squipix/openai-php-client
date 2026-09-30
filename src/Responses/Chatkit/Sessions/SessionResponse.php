<?php

declare(strict_types=1);

namespace OpenAI\Responses\Chatkit\Sessions;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type ChatkitSessionResponseType array{id: string, object: string, client_secret: string, expires_at: int, chatkit_configuration?: array<string, mixed>|null}
 *
 * @implements ResponseContract<ChatkitSessionResponseType>
 */
final class SessionResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ChatkitSessionResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>|null  $chatkitConfiguration
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $clientSecret,
        public readonly int $expiresAt,
        public readonly ?array $chatkitConfiguration,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  ChatkitSessionResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            clientSecret: $attributes['client_secret'],
            expiresAt: $attributes['expires_at'],
            chatkitConfiguration: $attributes['chatkit_configuration'] ?? null,
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
            'client_secret' => $this->clientSecret,
            'expires_at' => $this->expiresAt,
            'chatkit_configuration' => $this->chatkitConfiguration,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
