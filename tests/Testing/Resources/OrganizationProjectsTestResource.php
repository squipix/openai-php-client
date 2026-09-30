<?php

use OpenAI\Resources\OrganizationProjects;
use OpenAI\Responses\Organization\Projects\ListProjectsResponse;
use OpenAI\Responses\Organization\Projects\ProjectResponse;
use OpenAI\Testing\ClientFake;

it('records a project list request', function () {
    $fake = new ClientFake([
        ListProjectsResponse::fake(),
    ]);

    $fake->organization()->projects()->list();

    $fake->assertSent(OrganizationProjects::class, function ($method) {
        return $method === 'list';
    });
});

it('records a project create request', function () {
    $fake = new ClientFake([
        ProjectResponse::fake(),
    ]);

    $fake->organization()->projects()->create([
        'name' => 'Production API',
    ]);

    $fake->assertSent(OrganizationProjects::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['name'] === 'Production API';
    });
});

it('records a project retrieve request', function () {
    $fake = new ClientFake([
        ProjectResponse::fake(),
    ]);

    $fake->organization()->projects()->retrieve('proj_123456');

    $fake->assertSent(OrganizationProjects::class, function ($method, $projectId) {
        return $method === 'retrieve' &&
            $projectId === 'proj_123456';
    });
});

it('records a project modify request', function () {
    $fake = new ClientFake([
        ProjectResponse::fake(),
    ]);

    $fake->organization()->projects()->modify('proj_123456', [
        'name' => 'Staging API',
    ]);

    $fake->assertSent(OrganizationProjects::class, function ($method, $projectId, $parameters) {
        return $method === 'modify' &&
            $projectId === 'proj_123456' &&
            $parameters['name'] === 'Staging API';
    });
});

it('records a project archive request', function () {
    $fake = new ClientFake([
        ProjectResponse::fake(),
    ]);

    $fake->organization()->projects()->archive('proj_123456');

    $fake->assertSent(OrganizationProjects::class, function ($method, $projectId) {
        return $method === 'archive' &&
            $projectId === 'proj_123456';
    });
});
