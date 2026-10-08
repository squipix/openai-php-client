<?php

use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListResponse;
use OpenAI\Responses\Anthropic\Skills\ListVersionsResponse;
use OpenAI\Responses\Anthropic\Skills\SkillResponse;
use OpenAI\Responses\Anthropic\Skills\SkillVersionResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('create', function () {
    $client = anthropicMockClient('POST', 'skills', [], Response::from(anthropicSkill(), anthropicMetaHeaders()), validateParams: false);

    $result = $client->skills()->create([
        'display_name' => 'Excel Report Builder',
        'files' => [fileResourceResource()],
    ]);

    expect($result)
        ->toBeInstanceOf(SkillResponse::class)
        ->id->toBe('skill_01JAbcdefghijklmnopqrstuvw')
        ->displayName->toBe('Excel Report Builder')
        ->latestVersionId->toBe('1759178010641129')
        ->source->toBe('custom');
});

test('list', function () {
    $client = anthropicMockClient('GET', 'skills', ['source' => 'custom'], Response::from(anthropicPage(anthropicSkill()), anthropicMetaHeaders()));

    expect($client->skills()->list(['source' => 'custom']))
        ->toBeInstanceOf(ListResponse::class)
        ->data->toHaveCount(2)
        ->data->each->toBeInstanceOf(SkillResponse::class);
});

test('retrieve', function () {
    $client = anthropicMockClient('GET', 'skills/skill_01JAbcdefghijklmnopqrstuvw', [], Response::from(anthropicSkill(), anthropicMetaHeaders()));

    expect($client->skills()->retrieve('skill_01JAbcdefghijklmnopqrstuvw'))
        ->updatedAt->toBe('2026-10-08T13:00:00Z');
});

test('delete', function () {
    $client = anthropicMockClient('DELETE', 'skills/skill_01JAbcdefghijklmnopqrstuvw', [], Response::from(['id' => 'skill_01JAbcdefghijklmnopqrstuvw', 'type' => 'skill_deleted'], anthropicMetaHeaders()));

    expect($client->skills()->delete('skill_01JAbcdefghijklmnopqrstuvw'))
        ->toBeInstanceOf(DeleteResponse::class)
        ->type->toBe('skill_deleted');
});

test('create version', function () {
    $client = anthropicMockClient('POST', 'skills/skill_01JAbcdefghijklmnopqrstuvw/versions', [], Response::from(anthropicSkillVersion(), anthropicMetaHeaders()), validateParams: false);

    expect($client->skills()->versions()->create('skill_01JAbcdefghijklmnopqrstuvw', ['files' => [fileResourceResource()]]))
        ->toBeInstanceOf(SkillVersionResponse::class)
        ->skillId->toBe('skill_01JAbcdefghijklmnopqrstuvw')
        ->name->toBe('excel-report-builder');
});

test('list versions', function () {
    $client = anthropicMockClient('GET', 'skills/skill_01JAbcdefghijklmnopqrstuvw/versions', ['limit' => 2], Response::from(anthropicPage(anthropicSkillVersion()), anthropicMetaHeaders()));

    expect($client->skills()->versions()->list('skill_01JAbcdefghijklmnopqrstuvw', ['limit' => 2]))
        ->toBeInstanceOf(ListVersionsResponse::class)
        ->data->each->toBeInstanceOf(SkillVersionResponse::class);
});

test('retrieve version', function () {
    $client = anthropicMockClient('GET', 'skills/skill_01JAbcdefghijklmnopqrstuvw/versions/1759178010641129', [], Response::from(anthropicSkillVersion(), anthropicMetaHeaders()));

    expect($client->skills()->versions()->retrieve('skill_01JAbcdefghijklmnopqrstuvw', '1759178010641129'))
        ->description->toBe('Builds formatted Excel reports from CSV data.');
});

test('delete version', function () {
    $client = anthropicMockClient('DELETE', 'skills/skill_01JAbcdefghijklmnopqrstuvw/versions/1759178010641129', [], Response::from(['id' => '1759178010641129', 'type' => 'skill_version_deleted'], anthropicMetaHeaders()));

    expect($client->skills()->versions()->delete('skill_01JAbcdefghijklmnopqrstuvw', '1759178010641129'))
        ->type->toBe('skill_version_deleted');
});

test('encodes the skill id in version paths', function () {
    $client = anthropicMockClient('GET', 'skills/a%2Fb/versions', [], Response::from(anthropicPage(anthropicSkillVersion()), anthropicMetaHeaders()));

    expect($client->skills()->versions()->list('a/b'))->toBeInstanceOf(ListVersionsResponse::class);
});
