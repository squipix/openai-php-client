<?php

namespace OpenAI\Testing\Responses\Fixtures\Uploads;

final class UploadPartResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'part_abc123',
        'object' => 'upload.part',
        'created_at' => 1719184911,
        'upload_id' => 'upload_abc123',
    ];
}
