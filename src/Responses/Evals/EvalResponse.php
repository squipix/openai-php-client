<?php

declare(strict_types=1);

namespace OpenAI\Responses\Evals;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type EvalResponseType array{id: string, object: string, created_at: int, name?: string|null, data_source_config?: array<string, mixed>|null, testing_criteria?: array<int, mixed>|null, metadata?: array<string, string>|null}
 *
 * @implements ResponseContract<EvalResponseType>
 */
final class EvalResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<EvalResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>|null  $dataSourceConfig
     * @param  array<int, mixed>|null  $testingCriteria
     * @param  array<string, string>|null  $metadata
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $createdAt,
        public readonly ?string $name,
        public readonly ?array $dataSourceConfig,
        public readonly ?array $testingCriteria,
        public readonly ?array $metadata,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  EvalResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            createdAt: $attributes['created_at'],
            name: $attributes['name'] ?? null,
            dataSourceConfig: $attributes['data_source_config'] ?? null,
            testingCriteria: $attributes['testing_criteria'] ?? null,
            metadata: $attributes['metadata'] ?? null,
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
            'name' => $this->name,
            'data_source_config' => $this->dataSourceConfig,
            'testing_criteria' => $this->testingCriteria,
            'metadata' => $this->metadata,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
