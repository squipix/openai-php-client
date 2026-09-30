<?php

use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Uploads\UploadPartResponse;
use OpenAI\Responses\Uploads\UploadResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('create', function () {
    $client = mockClient('POST', 'uploads', [
        'bytes' => 2147483648,
        'filename' => 'training_examples.jsonl',
        'mime_type' => 'text/jsonl',
        'purpose' => 'fine-tune',
    ], Response::from(uploadResource(), metaHeaders()));

    $result = $client->uploads()->create([
        'bytes' => 2147483648,
        'filename' => 'training_examples.jsonl',
        'mime_type' => 'text/jsonl',
        'purpose' => 'fine-tune',
    ]);

    expect($result)
        ->toBeInstanceOf(UploadResponse::class)
        ->id->toBe('upload_abc123')
        ->object->toBe('upload')
        ->bytes->toBe(2147483648)
        ->createdAt->toBe(1719184911)
        ->expiresAt->toBe(1719127296)
        ->filename->toBe('training_examples.jsonl')
        ->purpose->toBe('fine-tune')
        ->status->toBe('pending')
        ->file->toBeNull();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('upload part', function () {
    $client = mockClient('POST', 'uploads/upload_abc123/parts', [
        'data' => fileResourceResource(),
    ], Response::from(uploadPartResource(), metaHeaders()), validateParams: false);

    $result = $client->uploads()->uploadPart('upload_abc123', [
        'data' => fileResourceResource(),
    ]);

    expect($result)
        ->toBeInstanceOf(UploadPartResponse::class)
        ->id->toBe('part_abc123')
        ->object->toBe('upload.part')
        ->createdAt->toBe(1719184911)
        ->uploadId->toBe('upload_abc123');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('complete', function () {
    $client = mockClient('POST', 'uploads/upload_abc123/complete', [
        'part_ids' => ['part_def456', 'part_ghi789'],
    ], Response::from(uploadCompletedResource(), metaHeaders()));

    $result = $client->uploads()->complete('upload_abc123', [
        'part_ids' => ['part_def456', 'part_ghi789'],
    ]);

    expect($result)
        ->toBeInstanceOf(UploadResponse::class)
        ->id->toBe('upload_abc123')
        ->object->toBe('upload')
        ->status->toBe('completed')
        ->file->id->toBe('file-xyz321')
        ->file->status->toBe('processed');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('cancel', function () {
    $client = mockClient('POST', 'uploads/upload_abc123/cancel', [], Response::from(uploadCancelledResource(), metaHeaders()));

    $result = $client->uploads()->cancel('upload_abc123');

    expect($result)
        ->toBeInstanceOf(UploadResponse::class)
        ->id->toBe('upload_abc123')
        ->object->toBe('upload')
        ->status->toBe('cancelled');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
