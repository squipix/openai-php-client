<?php

use OpenAI\Resources\Anthropic\MessagesBatches;
use OpenAI\Responses\Anthropic\Batches\BatchResponse;
use OpenAI\Responses\Anthropic\Batches\BatchResultsResponse;
use OpenAI\Responses\Anthropic\Batches\DeleteResponse;
use OpenAI\Responses\Anthropic\Batches\ListResponse;
use OpenAI\Testing\AnthropicClientFake;

it('records batch requests', function () {
    $fake = new AnthropicClientFake([
        BatchResponse::fake(),
        BatchResponse::fake(),
        ListResponse::fake(),
        BatchResponse::fake(['processing_status' => 'canceling']),
        DeleteResponse::fake(),
        BatchResultsResponse::fake(),
    ]);

    $batches = $fake->messages()->batches();

    $batches->create(['requests' => []]);
    $batches->retrieve('msgbatch_1');
    $batches->list();
    $batches->cancel('msgbatch_1');
    $batches->delete('msgbatch_1');
    $results = $batches->results('msgbatch_1');

    expect(iterator_to_array($results, false))->toHaveCount(2);

    $fake->assertSent(MessagesBatches::class, 6);
    $fake->assertSent(MessagesBatches::class, fn (string $method, string|array|null $argument = null): bool => $method === 'results' && $argument === 'msgbatch_1');
});
