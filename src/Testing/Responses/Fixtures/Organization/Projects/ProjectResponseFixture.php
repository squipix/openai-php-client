<?php

namespace OpenAI\Testing\Responses\Fixtures\Organization\Projects;

final class ProjectResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'proj_123456',
        'object' => 'organization.project',
        'name' => 'Production API',
        'created_at' => 1720000000,
        'archived_at' => null,
        'status' => 'active',
    ];
}
