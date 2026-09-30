<?php

use OpenAI\Responses\Evals\Runs\DeleteEvalRunResponse;
use OpenAI\Responses\Evals\Runs\EvalRunResponse;
use OpenAI\Responses\Evals\Runs\ListEvalRunsResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create eval run', function () {
    $client = mockClient(
        'POST',
        'evals/eval_123456/runs',
        [
            'name' => 'Run 1',
            'model' => 'gpt-4o-mini',
        ],
        Response::from(evalRunResource(), metaHeaders())
    );

    $result = $client->evals()->runs()->create('eval_123456', [
        'name' => 'Run 1',
        'model' => 'gpt-4o-mini',
    ]);

    expect($result)
        ->toBeInstanceOf(EvalRunResponse::class)
        ->id->toBe('eval_run_123456')
        ->object->toBe('eval.run')
        ->evalId->toBe('eval_123456')
        ->createdAt->toBe(1720000000)
        ->status->toBe('completed')
        ->name->toBe('Run 1')
        ->model->toBe('gpt-4o-mini');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve eval run', function () {
    $client = mockClient(
        'GET',
        'evals/eval_123456/runs/eval_run_123456',
        [],
        Response::from(evalRunResource(), metaHeaders())
    );

    $result = $client->evals()->runs()->retrieve('eval_123456', 'eval_run_123456');

    expect($result)
        ->toBeInstanceOf(EvalRunResponse::class)
        ->id->toBe('eval_run_123456');
});

test('list eval runs', function () {
    $client = mockClient(
        'GET',
        'evals/eval_123456/runs',
        [],
        Response::from(evalRunListResource(), metaHeaders())
    );

    $result = $client->evals()->runs()->list('eval_123456');

    expect($result)
        ->toBeInstanceOf(ListEvalRunsResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(EvalRunResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('cancel eval run', function () {
    $client = mockClient(
        'POST',
        'evals/eval_123456/runs/eval_run_123456/cancel',
        [],
        Response::from(array_merge(evalRunResource(), ['status' => 'cancelled']), metaHeaders())
    );

    $result = $client->evals()->runs()->cancel('eval_123456', 'eval_run_123456');

    expect($result)
        ->toBeInstanceOf(EvalRunResponse::class)
        ->id->toBe('eval_run_123456')
        ->status->toBe('cancelled');
});

test('delete eval run', function () {
    $client = mockClient(
        'DELETE',
        'evals/eval_123456/runs/eval_run_123456',
        [],
        Response::from(evalRunDeleteResource(), metaHeaders())
    );

    $result = $client->evals()->runs()->delete('eval_123456', 'eval_run_123456');

    expect($result)
        ->toBeInstanceOf(DeleteEvalRunResponse::class)
        ->id->toBe('eval_run_123456')
        ->object->toBe('eval.run.deleted')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
