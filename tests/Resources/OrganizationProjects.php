<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Organization\Projects\ListProjectsResponse;
use OpenAI\Responses\Organization\Projects\ProjectResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('list projects', function () {
    $client = mockClient(
        'GET',
        'organization/projects',
        [],
        Response::from(projectListResource(), metaHeaders())
    );

    $result = $client->organization()->projects()->list();

    expect($result)
        ->toBeInstanceOf(ListProjectsResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(ProjectResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('create project', function () {
    $client = mockClient(
        'POST',
        'organization/projects',
        ['name' => 'Production API'],
        Response::from(projectResource(), metaHeaders())
    );

    $result = $client->organization()->projects()->create([
        'name' => 'Production API',
    ]);

    expect($result)
        ->toBeInstanceOf(ProjectResponse::class)
        ->id->toBe('proj_123456')
        ->object->toBe('organization.project')
        ->name->toBe('Production API')
        ->createdAt->toBe(1720000000)
        ->status->toBe('active');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve project', function () {
    $client = mockClient(
        'GET',
        'organization/projects/proj_123456',
        [],
        Response::from(projectResource(), metaHeaders())
    );

    $result = $client->organization()->projects()->retrieve('proj_123456');

    expect($result)
        ->toBeInstanceOf(ProjectResponse::class)
        ->id->toBe('proj_123456');
});

test('modify project', function () {
    $client = mockClient(
        'POST',
        'organization/projects/proj_123456',
        ['name' => 'Staging API'],
        Response::from(array_merge(projectResource(), ['name' => 'Staging API']), metaHeaders())
    );

    $result = $client->organization()->projects()->modify('proj_123456', [
        'name' => 'Staging API',
    ]);

    expect($result)
        ->toBeInstanceOf(ProjectResponse::class)
        ->id->toBe('proj_123456')
        ->name->toBe('Staging API');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('archive project', function () {
    $client = mockClient(
        'POST',
        'organization/projects/proj_123456/archive',
        [],
        Response::from(array_merge(projectResource(), ['status' => 'archived', 'archived_at' => 1720050000]), metaHeaders())
    );

    $result = $client->organization()->projects()->archive('proj_123456');

    expect($result)
        ->toBeInstanceOf(ProjectResponse::class)
        ->id->toBe('proj_123456')
        ->status->toBe('archived')
        ->archivedAt->toBe(1720050000);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
