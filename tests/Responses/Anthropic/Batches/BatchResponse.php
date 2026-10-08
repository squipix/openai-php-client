<?php

use OpenAI\Responses\Anthropic\Batches\BatchResponse;
use OpenAI\Responses\Anthropic\Batches\BatchResult;
use OpenAI\Responses\Anthropic\Batches\BatchResultsResponse;
use OpenAI\Responses\Anthropic\Batches\DeleteResponse;
use OpenAI\Responses\Anthropic\Batches\ListResponse;
use OpenAI\Responses\Meta\MetaInformation;

test('from', function () {
    $response = BatchResponse::from(anthropicBatch(), meta());

    expect($response)
        ->id->toBe('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF')
        ->type->toBe('message_batch')
        ->endedAt->toBe('2026-10-08T19:37:24.100435Z')
        ->createdAt->toBe('2026-10-08T18:37:24.100435Z')
        ->expiresAt->toBe('2026-10-09T18:37:24.100435Z')
        ->archivedAt->toBeNull()
        ->cancelInitiatedAt->toBeNull()
        ->meta()->toBeInstanceOf(MetaInformation::class)
        ->and($response->requestCounts)
        ->processing->toBe(0)
        ->errored->toBe(1)
        ->canceled->toBe(1)
        ->expired->toBe(0);
});

test('as array accessible', function () {
    expect(BatchResponse::from(anthropicBatch(), meta())['processing_status'])->toBe('ended');
});

test('to array', function () {
    expect(BatchResponse::from(anthropicBatch(), meta())->toArray())->toBe(anthropicBatch())
        ->and(ListResponse::from(anthropicBatchList(), meta())->toArray())->toBe(anthropicBatchList());
});

test('fake', function () {
    expect(BatchResponse::fake(['processing_status' => 'ended']))
        ->processingStatus->toBe('ended')
        ->requestCounts->processing->toBe(100)
        ->and(ListResponse::fake()->data[0]->id)->toBe('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF')
        ->and(DeleteResponse::fake()->type)->toBe('message_batch_deleted');
});

test('fake results', function () {
    $results = iterator_to_array(BatchResultsResponse::fake(), false);

    expect($results)->toHaveCount(2)
        ->each->toBeInstanceOf(BatchResult::class)
        ->and($results[0]->message->text())->toBe('Hello! How can I help you today?')
        ->and($results[1]['result']['type'])->toBe('errored');
});
