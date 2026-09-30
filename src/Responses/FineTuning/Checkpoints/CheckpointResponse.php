<?php

declare(strict_types=1);

namespace OpenAI\Responses\FineTuning\Checkpoints;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type CheckpointMetricsType array{full_valid_loss?: float|null, full_valid_mean_token_accuracy?: float|null, step?: int|null, train_loss?: float|null, train_mean_token_accuracy?: float|null, valid_loss?: float|null, valid_mean_token_accuracy?: float|null}
 * @phpstan-type CheckpointResponseType array{id: string, object: string, created_at: int, fine_tuned_model_checkpoint: string, fine_tuning_job_id: string, metrics: CheckpointMetricsType, step_number: int}
 *
 * @implements ResponseContract<CheckpointResponseType>
 */
final class CheckpointResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<CheckpointResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  CheckpointMetricsType  $metrics
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $createdAt,
        public readonly string $fineTunedModelCheckpoint,
        public readonly string $fineTuningJobId,
        public readonly array $metrics,
        public readonly int $stepNumber,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  CheckpointResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            createdAt: $attributes['created_at'],
            fineTunedModelCheckpoint: $attributes['fine_tuned_model_checkpoint'],
            fineTuningJobId: $attributes['fine_tuning_job_id'],
            metrics: $attributes['metrics'],
            stepNumber: $attributes['step_number'],
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
            'created_at' => $this->createdAt,
            'fine_tuned_model_checkpoint' => $this->fineTunedModelCheckpoint,
            'fine_tuning_job_id' => $this->fineTuningJobId,
            'metrics' => $this->metrics,
            'step_number' => $this->stepNumber,
        ];
    }
}
