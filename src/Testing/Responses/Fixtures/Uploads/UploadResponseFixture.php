<?php

namespace OpenAI\Testing\Responses\Fixtures\Uploads;

final class UploadResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'upload_abc123',
        'object' => 'upload',
        'bytes' => 2147483648,
        'created_at' => 1719184911,
        'expires_at' => 1719127296,
        'filename' => 'training_examples.jsonl',
        'purpose' => 'fine-tune',
        'status' => 'pending',
        'file' => null,
    ];
}
