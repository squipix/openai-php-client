<?php

use OpenAI\Responses\FineTuning\Checkpoints\DeletePermissionResponse;
use OpenAI\Responses\FineTuning\Checkpoints\ListPermissionsResponse;
use OpenAI\Responses\FineTuning\Checkpoints\PermissionResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create permission', function () {
    $client = mockClient(
        'POST',
        'fine_tuning/checkpoints/ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB/permissions',
        ['project_ids' => ['proj_abGMw1llN8IrBb6SvvY5A1iH']],
        Response::from(checkpointPermissionListResource(), metaHeaders())
    );

    $result = $client->fineTuning()->checkpoints()->createPermission('ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB', [
        'project_ids' => ['proj_abGMw1llN8IrBb6SvvY5A1iH'],
    ]);

    expect($result)
        ->toBeInstanceOf(ListPermissionsResponse::class)
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(PermissionResponse::class);

    expect($result->data[0])
        ->id->toBe('cp_zc4Q7MP6XxulcVzj4MZdwsAB')
        ->createdAt->toBe(1721764867)
        ->object->toBe('checkpoint.permission')
        ->projectId->toBe('proj_abGMw1llN8IrBb6SvvY5A1iH');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('delete permission', function () {
    $client = mockClient(
        'DELETE',
        'fine_tuning/checkpoints/ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB/permissions/cp_zc4Q7MP6XxulcVzj4MZdwsAB',
        [],
        Response::from(checkpointPermissionDeleteResource(), metaHeaders())
    );

    $result = $client->fineTuning()->checkpoints()->deletePermission(
        'ftckpt_zc4Q7MP6XxulcVzj4MZdwsAB',
        'cp_zc4Q7MP6XxulcVzj4MZdwsAB'
    );

    expect($result)
        ->toBeInstanceOf(DeletePermissionResponse::class)
        ->id->toBe('cp_zc4Q7MP6XxulcVzj4MZdwsAB')
        ->object->toBe('checkpoint.permission')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
