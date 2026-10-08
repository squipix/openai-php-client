<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Files;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type FileResponseType array{id: string, type: 'file', filename: string, mime_type: string, size_bytes: int, created_at: string, downloadable?: ?bool}
 *
 * @implements ResponseContract<FileResponseType>
 */
final class FileResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<FileResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  'file'  $type
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $filename,
        public readonly string $mimeType,
        public readonly int $sizeBytes,
        public readonly string $createdAt,
        public readonly ?bool $downloadable,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  FileResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            type: $attributes['type'],
            filename: $attributes['filename'],
            mimeType: $attributes['mime_type'],
            sizeBytes: $attributes['size_bytes'],
            createdAt: $attributes['created_at'],
            downloadable: $attributes['downloadable'] ?? null,
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
            'type' => $this->type,
            'filename' => $this->filename,
            'mime_type' => $this->mimeType,
            'size_bytes' => $this->sizeBytes,
            'created_at' => $this->createdAt,
            'downloadable' => $this->downloadable,
        ], fn (mixed $value): bool => $value !== null);
    }
}
