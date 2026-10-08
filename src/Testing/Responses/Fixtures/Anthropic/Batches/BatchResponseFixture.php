<?php

namespace OpenAI\Testing\Responses\Fixtures\Anthropic\Batches;

final class BatchResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'msgbatch_013Zva2CMHLNnXjNJJKqJ2EF',
        'type' => 'message_batch',
        'processing_status' => 'in_progress',
        'request_counts' => [
            'processing' => 100,
            'succeeded' => 0,
            'errored' => 0,
            'canceled' => 0,
            'expired' => 0,
        ],
        'ended_at' => null,
        'created_at' => '2026-10-08T18:37:24.100435Z',
        'expires_at' => '2026-10-09T18:37:24.100435Z',
        'archived_at' => null,
        'cancel_initiated_at' => null,
        'results_url' => null,
    ];
}
