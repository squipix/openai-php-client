<?php

use OpenAI\Responses\Anthropic\Files\DeleteResponse;
use OpenAI\Responses\Anthropic\Files\FileResponse;
use OpenAI\Responses\Anthropic\Files\ListResponse;

test('from', function () {
    expect(FileResponse::from(anthropicFile(), meta()))
        ->type->toBe('file')
        ->createdAt->toBe('2026-10-08T12:00:00Z');
});

test('downloadable is optional', function () {
    $attributes = anthropicFile();
    unset($attributes['downloadable']);

    $response = FileResponse::from($attributes, meta());

    expect($response->downloadable)->toBeNull()
        ->and($response->toArray())->toBe($attributes);
});

test('as array accessible', function () {
    expect(FileResponse::from(anthropicFile(), meta())['mime_type'])->toBe('application/pdf');
});

test('to array', function () {
    expect(FileResponse::from(anthropicFile(), meta())->toArray())->toBe(anthropicFile());
});

test('fake', function () {
    expect(FileResponse::fake(['filename' => 'data.csv']))
        ->filename->toBe('data.csv')
        ->downloadable->toBeFalse()
        ->and(ListResponse::fake()->data[0]->id)->toBe('file_011CNha8iCJcU1wXNR6q4V8w')
        ->and(DeleteResponse::fake()->toArray())->toBe(['id' => 'file_011CNha8iCJcU1wXNR6q4V8w', 'type' => 'file_deleted']);
});
