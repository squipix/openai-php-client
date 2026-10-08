<?php

namespace OpenAI\Testing\Responses\Fixtures\Anthropic\Skills;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'data' => [
            SkillResponseFixture::ATTRIBUTES,
        ],
        'has_more' => false,
        'first_id' => 'skill_01JAbcdefghijklmnopqrstuvw',
        'last_id' => 'skill_01JAbcdefghijklmnopqrstuvw',
    ];
}
