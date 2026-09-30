<?php

declare(strict_types=1);

namespace OpenAI\Responses\Evals\Runs;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type EvalRunResponseType array{id: string, object: string, eval_id: string, created_at: int, status: string, name?: string|null, model?: string|null, data_source?: array<string, mixed>|null, metadata?: array<string, string>|null, per_model_usage?: array<string, mixed>|null, per_testing_criteria_results?: array<int, mixed>|null, result_counts?: array<string, int>|null, report_url?: string|null, error?: array{code: string, message: string}|null}
 *
 * @implements ResponseContract<EvalRunResponseType>
 */
final class EvalRunResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<EvalRunResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<string, mixed>|null  $dataSource
     * @param  array<string, string>|null  $metadata
     * @param  array<string, mixed>|null  $perModelUsage
     * @param  array<int, mixed>|null  $perTestingCriteriaResults
     * @param  array<string, int>|null  $resultCounts
     * @param  array{code: string, message: string}|null  $error
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly string $evalId,
        public readonly int $createdAt,
        public readonly string $status,
        public readonly ?string $name,
        public readonly ?string $model,
        public readonly ?array $dataSource,
        public readonly ?array $metadata,
        public readonly ?array $perModelUsage,
        public readonly ?array $perTestingCriteriaResults,
        public readonly ?array $resultCounts,
        public readonly ?string $reportUrl,
        public readonly ?array $error,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  EvalRunResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            evalId: $attributes['eval_id'],
            createdAt: $attributes['created_at'],
            status: $attributes['status'],
            name: $attributes['name'] ?? null,
            model: $attributes['model'] ?? null,
            dataSource: $attributes['data_source'] ?? null,
            metadata: $attributes['metadata'] ?? null,
            perModelUsage: $attributes['per_model_usage'] ?? null,
            perTestingCriteriaResults: $attributes['per_testing_criteria_results'] ?? null,
            resultCounts: $attributes['result_counts'] ?? null,
            reportUrl: $attributes['report_url'] ?? null,
            error: $attributes['error'] ?? null,
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
            'eval_id' => $this->evalId,
            'created_at' => $this->createdAt,
            'status' => $this->status,
            'name' => $this->name,
            'model' => $this->model,
            'data_source' => $this->dataSource,
            'metadata' => $this->metadata,
            'per_model_usage' => $this->perModelUsage,
            'per_testing_criteria_results' => $this->perTestingCriteriaResults,
            'result_counts' => $this->resultCounts,
            'report_url' => $this->reportUrl,
            'error' => $this->error,
        ], static fn (mixed $val): bool => $val !== null);
    }
}
