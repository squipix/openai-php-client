<?php

use GuzzleHttp\Psr7\Response as PsrResponse;
use GuzzleHttp\Psr7\Utils;
use OpenAI\Responses\Anthropic\Batches\BatchRequestCounts;
use OpenAI\Responses\Anthropic\Batches\BatchResponse;
use OpenAI\Responses\Anthropic\Batches\BatchResult;
use OpenAI\Responses\Anthropic\Batches\BatchResultsResponse;
use OpenAI\Responses\Anthropic\Batches\DeleteResponse;
use OpenAI\Responses\Anthropic\Batches\ListResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('create', function () {
    $parameters = [
        'requests' => [
            ['custom_id' => 'my-first-request', 'params' => ['model' => 'claude-opus-5-5', 'max_tokens' => 1024, 'messages' => [['role' => 'user', 'content' => 'Hello']]]],
        ],
    ];

    $client = anthropicMockClient('POST', 'messages/batches', $parameters, Response::from(anthropicBatch(), anthropicMetaHeaders()));

    $result = $client->messages()->batches()->create($parameters);

    expect($result)
        ->toBeInstanceOf(BatchResponse::class)
        ->id->toBe('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF')
        ->processingStatus->toBe('ended')
        ->requestCounts->toBeInstanceOf(BatchRequestCounts::class)
        ->and($result->requestCounts->succeeded)->toBe(98)
        ->and($result->meta()->requestId)->toBe('req_011CSHoEeqs5C35K2UUqR7Fy');
});

test('retrieve', function () {
    $client = anthropicMockClient('GET', 'messages/batches/msgbatch_013Zva2CMHLNnXjNJJKqJ2EF', [], Response::from(anthropicBatch(), anthropicMetaHeaders()));

    expect($client->messages()->batches()->retrieve('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF'))
        ->resultsUrl->toEndWith('/results');
});

test('list', function () {
    $client = anthropicMockClient('GET', 'messages/batches', ['limit' => 2], Response::from(anthropicBatchList(), anthropicMetaHeaders()));

    $result = $client->messages()->batches()->list(['limit' => 2]);

    expect($result)
        ->toBeInstanceOf(ListResponse::class)
        ->data->toHaveCount(2)
        ->data->each->toBeInstanceOf(BatchResponse::class)
        ->hasMore->toBeTrue();
});

test('cancel', function () {
    $client = anthropicMockClient('POST', 'messages/batches/msgbatch_013Zva2CMHLNnXjNJJKqJ2EF/cancel', [], Response::from([...anthropicBatch(), 'processing_status' => 'canceling'], anthropicMetaHeaders()), validateParams: false);

    expect($client->messages()->batches()->cancel('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF'))
        ->processingStatus->toBe('canceling');
});

test('delete', function () {
    $client = anthropicMockClient('DELETE', 'messages/batches/msgbatch_013Zva2CMHLNnXjNJJKqJ2EF', [], Response::from(['id' => 'msgbatch_013Zva2CMHLNnXjNJJKqJ2EF', 'type' => 'message_batch_deleted'], anthropicMetaHeaders()));

    expect($client->messages()->batches()->delete('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF'))
        ->toBeInstanceOf(DeleteResponse::class)
        ->type->toBe('message_batch_deleted');
});

test('results', function () {
    $client = anthropicMockStreamClient('GET', 'messages/batches/msgbatch_013Zva2CMHLNnXjNJJKqJ2EF/results', [], new PsrResponse(200, anthropicMetaHeaders(), Utils::streamFor(anthropicBatchResults())));

    $results = $client->messages()->batches()->results('msgbatch_013Zva2CMHLNnXjNJJKqJ2EF');

    expect($results)->toBeInstanceOf(BatchResultsResponse::class)
        ->and($results->meta()->requestId)->toBe('req_011CSHoEeqs5C35K2UUqR7Fy');

    $items = iterator_to_array($results, false);

    expect($items)->toHaveCount(3)
        ->each->toBeInstanceOf(BatchResult::class)
        ->and($items[0])->customId->toBe('my-second-request')->type->toBe('succeeded')->error->toBeNull()
        ->and($items[0]->message)->toBeInstanceOf(CreateResponse::class)
        ->and($items[0]->message->text())->toBe('Hi')
        ->and($items[0]->message->usage->cacheReadInputTokens)->toBe(1500)
        ->and($items[1])->type->toBe('errored')->message->toBeNull()
        ->and($items[1]->error['error']['message'])->toBe('Bad')
        ->and($items[2])->type->toBe('expired')
        ->and($items[2]->toArray())->toBe(['custom_id' => 'my-third-request', 'result' => ['type' => 'expired']]);
});

test('results read lines across chunk boundaries', function () {
    $line = json_encode(['custom_id' => str_repeat('x', 70000), 'result' => ['type' => 'canceled']]);

    $results = BatchResultsResponse::fake($line."\n".$line."\n");

    expect(array_map(fn (BatchResult $result): int => strlen($result->customId), iterator_to_array($results, false)))
        ->toBe([70000, 70000]);
});
