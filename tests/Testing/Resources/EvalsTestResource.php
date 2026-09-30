<?php

use OpenAI\Resources\Evals;
use OpenAI\Responses\Evals\DeleteEvalResponse;
use OpenAI\Responses\Evals\EvalResponse;
use OpenAI\Responses\Evals\ListEvalsResponse;
use OpenAI\Testing\ClientFake;

it('records an eval create request', function () {
    $fake = new ClientFake([
        EvalResponse::fake(),
    ]);

    $fake->evals()->create([
        'name' => 'Support Bot Quality',
    ]);

    $fake->assertSent(Evals::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['name'] === 'Support Bot Quality';
    });
});

it('records an eval retrieve request', function () {
    $fake = new ClientFake([
        EvalResponse::fake(),
    ]);

    $fake->evals()->retrieve('eval_123456');

    $fake->assertSent(Evals::class, function ($method, $id) {
        return $method === 'retrieve' &&
            $id === 'eval_123456';
    });
});

it('records an eval update request', function () {
    $fake = new ClientFake([
        EvalResponse::fake(),
    ]);

    $fake->evals()->update('eval_123456', [
        'name' => 'Updated Support Bot',
    ]);

    $fake->assertSent(Evals::class, function ($method, $id, $parameters) {
        return $method === 'update' &&
            $id === 'eval_123456' &&
            $parameters['name'] === 'Updated Support Bot';
    });
});

it('records an eval delete request', function () {
    $fake = new ClientFake([
        DeleteEvalResponse::fake(),
    ]);

    $fake->evals()->delete('eval_123456');

    $fake->assertSent(Evals::class, function ($method, $id) {
        return $method === 'delete' &&
            $id === 'eval_123456';
    });
});

it('records an eval list request', function () {
    $fake = new ClientFake([
        ListEvalsResponse::fake(),
    ]);

    $fake->evals()->list();

    $fake->assertSent(Evals::class, function ($method) {
        return $method === 'list';
    });
});
