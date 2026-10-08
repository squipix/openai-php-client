<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Batches;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type BatchRequestCountsType from BatchRequestCounts
 *
 * @phpstan-type BatchResponseType array{id: string, type: 'message_batch', processing_status: 'in_progress'|'canceling'|'ended', request_counts: BatchRequestCountsType, ended_at: ?string, created_at: string, expires_at: string, archived_at: ?string, cancel_initiated_at: ?string, results_url: ?string}
 *
 * @implements ResponseContract<BatchResponseType>
 */
final class BatchResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<BatchResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  'message_batch'  $type
     * @param  'in_progress'|'canceling'|'ended'  $processingStatus
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $processingStatus,
        public readonly BatchRequestCounts $requestCounts,
        public readonly ?string $endedAt,
        public readonly string $createdAt,
        public readonly string $expiresAt,
        public readonly ?string $archivedAt,
        public readonly ?string $cancelInitiatedAt,
        public readonly ?string $resultsUrl,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  BatchResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            type: $attributes['type'],
            processingStatus: $attributes['processing_status'],
            requestCounts: BatchRequestCounts::from($attributes['request_counts']),
            endedAt: $attributes['ended_at'],
            createdAt: $attributes['created_at'],
            expiresAt: $attributes['expires_at'],
            archivedAt: $attributes['archived_at'],
            cancelInitiatedAt: $attributes['cancel_initiated_at'],
            resultsUrl: $attributes['results_url'],
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
            'type' => $this->type,
            'processing_status' => $this->processingStatus,
            'request_counts' => $this->requestCounts->toArray(),
            'ended_at' => $this->endedAt,
            'created_at' => $this->createdAt,
            'expires_at' => $this->expiresAt,
            'archived_at' => $this->archivedAt,
            'cancel_initiated_at' => $this->cancelInitiatedAt,
            'results_url' => $this->resultsUrl,
        ];
    }
}
