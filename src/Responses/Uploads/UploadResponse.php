<?php

declare(strict_types=1);

namespace OpenAI\Responses\Uploads;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Files\CreateResponse as FileResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type UploadFileType array{id: string, object: string, created_at: int, expires_at: int|null, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}
 * @phpstan-type UploadResponseType array{id: string, object: string, bytes: int, created_at: int, expires_at: int, filename: string, purpose: string, status: string, file?: UploadFileType|null}
 *
 * @implements ResponseContract<UploadResponseType>
 */
final class UploadResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<UploadResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $bytes,
        public readonly int $createdAt,
        public readonly int $expiresAt,
        public readonly string $filename,
        public readonly string $purpose,
        public readonly string $status,
        public readonly ?FileResponse $file,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  UploadResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            bytes: $attributes['bytes'],
            createdAt: $attributes['created_at'],
            expiresAt: $attributes['expires_at'],
            filename: $attributes['filename'],
            purpose: $attributes['purpose'],
            status: $attributes['status'],
            file: isset($attributes['file']) ? FileResponse::from($attributes['file'], $meta) : null,
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'bytes' => $this->bytes,
            'created_at' => $this->createdAt,
            'expires_at' => $this->expiresAt,
            'filename' => $this->filename,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'file' => $this->file?->toArray(),
        ];
    }
}
