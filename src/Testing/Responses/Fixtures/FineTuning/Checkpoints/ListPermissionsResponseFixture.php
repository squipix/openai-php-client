<?php

namespace OpenAI\Testing\Responses\Fixtures\FineTuning\Checkpoints;

final class ListPermissionsResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            PermissionResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'cp_zc4Q7MP6XxulcVzj4MZdwsAB',
        'last_id' => 'cp_zc4Q7MP6XxulcVzj4MZdwsAB',
        'has_more' => false,
    ];
}
