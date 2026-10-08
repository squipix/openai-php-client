<?php

namespace OpenAI\Testing\Responses\Fixtures\Anthropic\Skills;

final class ListVersionsResponseFixture
{
    public const ATTRIBUTES = [
        'data' => [
            SkillVersionResponseFixture::ATTRIBUTES,
        ],
        'has_more' => false,
        'first_id' => '1759178010641129',
        'last_id' => '1759178010641129',
    ];
}
