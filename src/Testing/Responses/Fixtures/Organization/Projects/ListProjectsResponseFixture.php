<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Projects;

final class ListProjectsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            ProjectResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'proj_123456',
        'last_id' => 'proj_123456',
        'has_more' => false,
    ];
}
