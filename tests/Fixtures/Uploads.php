<?php

/**
 * @return array<string, mixed>
 */
function uploadResource(): array
{
    return [
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

/**
 * @return array<string, mixed>
 */
function uploadCompletedResource(): array
{
    return [
        'id' => 'upload_abc123',
        'object' => 'upload',
        'bytes' => 2147483648,
        'created_at' => 1719184911,
        'expires_at' => 1719127296,
        'filename' => 'training_examples.jsonl',
        'purpose' => 'fine-tune',
        'status' => 'completed',
        'file' => [
            'id' => 'file-xyz321',
            'object' => 'file',
            'bytes' => 2147483648,
            'created_at' => 1719186911,
            'expires_at' => null,
            'filename' => 'training_examples.jsonl',
            'purpose' => 'fine-tune',
            'status' => 'processed',
            'status_details' => null,
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function uploadCancelledResource(): array
{
    return [
        'id' => 'upload_abc123',
        'object' => 'upload',
        'bytes' => 2147483648,
        'created_at' => 1719184911,
        'expires_at' => 1719127296,
        'filename' => 'training_examples.jsonl',
        'purpose' => 'fine-tune',
        'status' => 'cancelled',
        'file' => null,
    ];
}

/**
 * @return array<string, mixed>
 */
function uploadPartResource(): array
{
    return [
        'id' => 'part_abc123',
        'object' => 'upload.part',
        'created_at' => 1719184911,
        'upload_id' => 'upload_abc123',
    ];
}
