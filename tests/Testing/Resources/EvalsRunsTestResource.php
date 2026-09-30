<?php

use OpenAI\Resources\EvalsRuns;
use OpenAI\Responses\Evals\Runs\DeleteEvalRunResponse;
use OpenAI\Responses\Evals\Runs\EvalRunResponse;
use OpenAI\Responses\Evals\Runs\ListEvalRunsResponse;
use OpenAI\Testing\ClientFake;

it('records an eval run create request', function () {
    $fake = new ClientFake([
        EvalRunResponse::fake(),
    ]);

    $fake->evals()->runs()->create('eval_123456', [
        'name' => 'Run 1',
    ]);

    $fake->assertSent(EvalsRuns::class, function ($method, $evalId, $parameters) {
        return $method === 'create' &&
            $evalId === 'eval_123456' &&
            $parameters['name'] === 'Run 1';
    });
});

it('records an eval run retrieve request', function () {
    $fake = new ClientFake([
        EvalRunResponse::fake(),
    ]);

    $fake->evals()->runs()->retrieve('eval_123456', 'eval_run_123456');

    $fake->assertSent(EvalsRuns::class, function ($method, $evalId, $runId) {
        return $method === 'retrieve' &&
            $evalId === 'eval_123456' &&
            $runId === 'eval_run_123456';
    });
});

it('records an eval run list request', function () {
    $fake = new ClientFake([
        ListEvalRunsResponse::fake(),
    ]);

    $fake->evals()->runs()->list('eval_123456');

    $fake->assertSent(EvalsRuns::class, function ($method, $evalId) {
        return $method === 'list' &&
            $evalId === 'eval_123456';
    });
});

it('records an eval run cancel request', function () {
    $fake = new ClientFake([
        EvalRunResponse::fake(),
    ]);

    $fake->evals()->runs()->cancel('eval_123456', 'eval_run_123456');

    $fake->assertSent(EvalsRuns::class, function ($method, $evalId, $runId) {
        return $method === 'cancel' &&
            $evalId === 'eval_123456' &&
            $runId === 'eval_run_123456';
    });
});

it('records an eval run delete request', function () {
    $fake = new ClientFake([
        DeleteEvalRunResponse::fake(),
    ]);

    $fake->evals()->runs()->delete('eval_123456', 'eval_run_123456');

    $fake->assertSent(EvalsRuns::class, function ($method, $evalId, $runId) {
        return $method === 'delete' &&
            $evalId === 'eval_123456' &&
            $runId === 'eval_run_123456';
    });
});
