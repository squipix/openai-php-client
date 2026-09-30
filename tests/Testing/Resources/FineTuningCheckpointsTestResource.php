<?php

use OpenAI\Resources\FineTuningCheckpoints;
use OpenAI\Responses\FineTuning\Checkpoints\DeletePermissionResponse;
use OpenAI\Responses\FineTuning\Checkpoints\ListPermissionsResponse;
use OpenAI\Testing\ClientFake;

it('records a fine tuning checkpoint create permission request', function () {
    $fake = new ClientFake([
        ListPermissionsResponse::fake(),
    ]);

    $fake->fineTuning()->checkpoints()->createPermission('ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB', [
        'project_ids' => ['proj_abGMw1llN8IrBb6SvvY5A1iH'],
    ]);

    $fake->assertSent(FineTuningCheckpoints::class, function ($method, $checkpoint, $parameters) {
        return $method === 'createPermission' &&
            $checkpoint === 'ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB' &&
            $parameters['project_ids'] === ['proj_abGMw1llN8IrBb6SvvY5A1iH'];
    });
});

it('records a fine tuning checkpoint delete permission request', function () {
    $fake = new ClientFake([
        DeletePermissionResponse::fake(),
    ]);

    $fake->fineTuning()->checkpoints()->deletePermission('ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB', 'cp_zc4Q7MP6XxulcVzj4MZdwsAB');

    $fake->assertSent(FineTuningCheckpoints::class, function ($method, $checkpoint, $permission) {
        return $method === 'deletePermission' &&
            $checkpoint === 'ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB' &&
            $permission === 'cp_zc4Q7MP6XxulcVzj4MZdwsAB';
    });
});
