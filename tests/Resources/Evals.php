<?php

use OpenAI\Responses\Evals\DeleteEvalResponse;
use OpenAI\Responses\Evals\EvalResponse;
use OpenAI\Responses\Evals\ListEvalsResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create eval', function () {
    $client = mockClient(
        'POST',
        'evals',
        [
            'name' => 'Support Bot Quality',
            'data_source_config' => ['type' => 'custom'],
        ],
        Response::from(evalResource(), metaHeaders())
    );

    $result = $client->evals()->create([
        'name' => 'Support Bot Quality',
        'data_source_config' => ['type' => 'custom'],
    ]);

    expect($result)
        ->toBeInstanceOf(EvalResponse::class)
        ->id->toBe('eval_123456')
        ->object->toBe('eval')
        ->createdAt->toBe(1720000000)
        ->name->toBe('Support Bot Quality');

    expect($result->dataSourceConfig)
        ->toBeArray()
        ->toHaveKey('type', 'custom');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve eval', function () {
    $client = mockClient(
        'GET',
        'evals/eval_123456',
        [],
        Response::from(evalResource(), metaHeaders())
    );

    $result = $client->evals()->retrieve('eval_123456');

    expect($result)
        ->toBeInstanceOf(EvalResponse::class)
        ->id->toBe('eval_123456');
});

test('update eval', function () {
    $client = mockClient(
        'POST',
        'evals/eval_123456',
        ['name' => 'Updated Support Bot'],
        Response::from(array_merge(evalResource(), ['name' => 'Updated Support Bot']), metaHeaders())
    );

    $result = $client->evals()->update('eval_123456', [
        'name' => 'Updated Support Bot',
    ]);

    expect($result)
        ->toBeInstanceOf(EvalResponse::class)
        ->name->toBe('Updated Support Bot');
});

test('delete eval', function () {
    $client = mockClient(
        'DELETE',
        'evals/eval_123456',
        [],
        Response::from(evalDeleteResource(), metaHeaders())
    );

    $result = $client->evals()->delete('eval_123456');

    expect($result)
        ->toBeInstanceOf(DeleteEvalResponse::class)
        ->id->toBe('eval_123456')
        ->object->toBe('eval.deleted')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('list evals', function () {
    $client = mockClient(
        'GET',
        'evals',
        [],
        Response::from(evalListResource(), metaHeaders())
    );

    $result = $client->evals()->list();

    expect($result)
        ->toBeInstanceOf(ListEvalsResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(EvalResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
