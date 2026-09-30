<?php

use OpenAI\Resources\Uploads;
use OpenAI\Responses\Uploads\UploadPartResponse;
use OpenAI\Responses\Uploads\UploadResponse;
use OpenAI\Testing\ClientFake;

it('records an upload create request', function () {
    $fake = new ClientFake([
        UploadResponse::fake(),
    ]);

    $fake->uploads()->create([
        'bytes' => 2147483648,
        'filename' => 'training_examples.jsonl',
        'mime_type' => 'text/jsonl',
        'purpose' => 'fine-tune',
    ]);

    $fake->assertSent(Uploads::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['bytes'] === 2147483648 &&
            $parameters['filename'] === 'training_examples.jsonl';
    });
});

it('records an upload part request', function () {
    $fake = new ClientFake([
        UploadPartResponse::fake(),
    ]);

    $fake->uploads()->uploadPart('upload_abc123', [
        'data' => 'dummy',
    ]);

    $fake->assertSent(Uploads::class, function ($method, $uploadId, $parameters) {
        return $method === 'uploadPart' &&
            $uploadId === 'upload_abc123' &&
            $parameters['data'] === 'dummy';
    });
});

it('records an upload complete request', function () {
    $fake = new ClientFake([
        UploadResponse::fake(),
    ]);

    $fake->uploads()->complete('upload_abc123', [
        'part_ids' => ['part_def456'],
    ]);

    $fake->assertSent(Uploads::class, function ($method, $uploadId, $parameters) {
        return $method === 'complete' &&
            $uploadId === 'upload_abc123' &&
            $parameters['part_ids'] === ['part_def456'];
    });
});

it('records an upload cancel request', function () {
    $fake = new ClientFake([
        UploadResponse::fake(),
    ]);

    $fake->uploads()->cancel('upload_abc123');

    $fake->assertSent(Uploads::class, function ($method, $uploadId) {
        return $method === 'cancel' &&
            $uploadId === 'upload_abc123';
    });
});
