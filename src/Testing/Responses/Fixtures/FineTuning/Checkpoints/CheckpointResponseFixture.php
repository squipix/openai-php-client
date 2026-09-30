<?php

namespace OpenAI\Testing\Responses\Fixtures\FineTuning\Checkpoints;

final class CheckpointResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'fine_tuning.job.checkpoint',
        'id' => 'ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB',
        'created_at' => 1721764867,
        'fine_tuned_model_checkpoint' => 'ft:gpt-4o-mini-2024-07-18:my-org:custom-suffix:96olL566:ckpt-step-2000',
        'metrics' => [
            'full_valid_loss' => 0.134,
            'full_valid_mean_token_accuracy' => 0.874,
            'step' => 2000,
            'train_loss' => 0.111,
            'train_mean_token_accuracy' => 0.902,
            'valid_loss' => 0.123,
            'valid_mean_token_accuracy' => 0.888,
        ],
        'fine_tuning_job_id' => 'ftjob-abc123',
        'step_number' => 2000,
    ];
}
