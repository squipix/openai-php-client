<?php

namespace OpenAI\Testing\Responses\Fixtures\FineTuning\Checkpoints;

final class ListJobCheckpointsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            CheckpointResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB',
        'last_id' => 'ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB',
        'has_more' => false,
    ];
}
