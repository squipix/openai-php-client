<?php

use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListResponse;
use OpenAI\Responses\Anthropic\Skills\ListVersionsResponse;
use OpenAI\Responses\Anthropic\Skills\SkillResponse;
use OpenAI\Responses\Anthropic\Skills\SkillVersionResponse;

test('to array', function () {
    expect(SkillResponse::from(anthropicSkill(), meta())->toArray())->toBe(anthropicSkill())
        ->and(SkillVersionResponse::from(anthropicSkillVersion(), meta())->toArray())->toBe(anthropicSkillVersion())
        ->and(ListResponse::from(anthropicPage(anthropicSkill()), meta())->toArray())->toBe(anthropicPage(anthropicSkill()))
        ->and(ListVersionsResponse::from(anthropicPage(anthropicSkillVersion()), meta())->toArray())->toBe(anthropicPage(anthropicSkillVersion()));
});

test('as array accessible', function () {
    expect(SkillResponse::from(anthropicSkill(), meta())['display_name'])->toBe('Excel Report Builder')
        ->and(SkillVersionResponse::from(anthropicSkillVersion(), meta())['skill_id'])->toBe('skill_01JAbcdefghijklmnopqrstuvw');
});

test('latest version may be null', function () {
    expect(SkillResponse::from([...anthropicSkill(), 'latest_version_id' => null], meta())->latestVersionId)->toBeNull();
});

test('fake', function () {
    expect(SkillResponse::fake(['source' => 'anthropic']))->source->toBe('anthropic')
        ->and(SkillVersionResponse::fake())->name->toBe('excel-report-builder')
        ->and(ListResponse::fake()->data[0])->displayName->toBe('Excel Report Builder')
        ->and(ListVersionsResponse::fake()->data[0])->id->toBe('1759178010641129')
        ->and(DeleteResponse::fake())->type->toBe('skill_deleted');
});
