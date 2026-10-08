<?php

use OpenAI\Resources\Anthropic\Skills;
use OpenAI\Resources\Anthropic\SkillsVersions;
use OpenAI\Responses\Anthropic\Skills\DeleteResponse;
use OpenAI\Responses\Anthropic\Skills\ListResponse;
use OpenAI\Responses\Anthropic\Skills\ListVersionsResponse;
use OpenAI\Responses\Anthropic\Skills\SkillResponse;
use OpenAI\Responses\Anthropic\Skills\SkillVersionResponse;
use OpenAI\Testing\AnthropicClientFake;

it('records skill and version requests', function () {
    $fake = new AnthropicClientFake([
        SkillResponse::fake(),
        ListResponse::fake(),
        SkillResponse::fake(),
        DeleteResponse::fake(),
        SkillVersionResponse::fake(),
        ListVersionsResponse::fake(),
        SkillVersionResponse::fake(),
        DeleteResponse::fake(['type' => 'skill_version_deleted']),
    ]);

    $fake->skills()->create(['display_name' => 'Excel', 'files' => []]);
    $fake->skills()->list();
    $fake->skills()->retrieve('skill_1');
    $fake->skills()->delete('skill_1');
    $fake->skills()->versions()->create('skill_1', ['files' => []]);
    $fake->skills()->versions()->list('skill_1');
    $fake->skills()->versions()->retrieve('skill_1', '1');
    $fake->skills()->versions()->delete('skill_1', '1');

    $fake->assertSent(Skills::class, 4);
    $fake->assertSent(SkillsVersions::class, 4);
    $fake->assertSent(SkillsVersions::class, fn (string $method, string $skillId, mixed $version = null): bool => $method === 'retrieve' && $skillId === 'skill_1' && $version === '1');
});
